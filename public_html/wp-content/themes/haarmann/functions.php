<?php
/**
 * Haarmann theme bootstrap.
 *
 * @package Haarmann
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'HAARMANN_THEME_VERSION' ) ) {
	define( 'HAARMANN_THEME_VERSION', '0.1.0' );
}

/**
 * Theme setup.
 */
function haarmann_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	load_theme_textdomain( 'haarmann', get_template_directory() . '/languages' );

	register_nav_menus(
		array(
			'primary' => __( 'Hauptmenü', 'haarmann' ),
			'footer'  => __( 'Footer', 'haarmann' ),
		)
	);
}
add_action( 'after_setup_theme', 'haarmann_setup' );

/**
 * Enqueue front-end assets.
 *
 * Schriften werden via theme.json fontFace lokal aus assets/fonts/ geladen
 * (WordPress Font-Library-API seit 6.5) — kein Google Fonts CDN nötig.
 */
function haarmann_enqueue_assets(): void {
	wp_enqueue_style(
		'haarmann-style',
		get_stylesheet_uri(),
		array(),
		HAARMANN_THEME_VERSION
	);

	wp_enqueue_style(
		'haarmann-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		array( 'haarmann-style' ),
		HAARMANN_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'haarmann_enqueue_assets' );

/**
 * Enqueue editor assets so block previews look like the front-end.
 */
function haarmann_editor_assets(): void {
	add_editor_style( 'assets/css/main.css' );
}
add_action( 'after_setup_theme', 'haarmann_editor_assets' );

/**
 * Allow SVG uploads for admin users.
 *
 * Hinweis: SVG-Uploads sind ein Sicherheitsrisiko (XSS via inline scripts).
 * Für Produktiv-Betrieb mit nicht-Admin-Editoren idealerweise das Plugin
 * "Safe SVG" einsetzen, das die SVG vor dem Speichern sanitisiert.
 */
function haarmann_allow_svg_upload( array $mimes ): array {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'haarmann_allow_svg_upload' );

/**
 * Fix WP filetype check for SVG (it doesn't natively detect SVG content).
 */
function haarmann_fix_svg_filetype( array $data, string $file, string $filename, ?array $mimes, ?string $real_mime ): array {
	if ( ! current_user_can( 'manage_options' ) ) {
		return $data;
	}
	$ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
	if ( in_array( $ext, array( 'svg', 'svgz' ), true ) ) {
		$data['ext']             = $ext;
		$data['type']            = 'image/svg+xml';
		$data['proper_filename'] = $filename;
	}
	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'haarmann_fix_svg_filetype', 10, 5 );

/**
 * Provide dimensions for SVG attachments so the Site-Logo block can render them.
 */
function haarmann_svg_image_size( $response, $attachment, $meta ) {
	if ( is_array( $response ) && isset( $response['mime'] ) && 'image/svg+xml' === $response['mime'] ) {
		$file = get_attached_file( $attachment->ID );
		if ( $file && file_exists( $file ) ) {
			$contents = file_get_contents( $file );
			if ( preg_match( '/viewBox=["\']\s*\d+\s+\d+\s+([\d.]+)\s+([\d.]+)/', $contents, $m ) ) {
				$response['width']  = (int) round( (float) $m[1] );
				$response['height'] = (int) round( (float) $m[2] );
			}
		}
	}
	return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'haarmann_svg_image_size', 10, 3 );

/**
 * Resolve the Google Maps API key.
 *
 * Reihenfolge:
 *   1. Konstante HAARMANN_GMAPS_API_KEY (z. B. in wp-config.php) — bevorzugt
 *      für Produktiv, weil der Key nicht in der DB liegt und Hosting-spezifisch
 *      gesetzt werden kann.
 *   2. wp_options-Eintrag "haarmann_gmaps_api_key" — bequem für lokal/staging
 *      via WP-CLI: ddev wp option update haarmann_gmaps_api_key "AIza..."
 *   3. Leerer String — Pattern fällt auf Fallback-Link zurück.
 */
function haarmann_get_gmaps_api_key(): string {
	if ( defined( 'HAARMANN_GMAPS_API_KEY' ) && is_string( HAARMANN_GMAPS_API_KEY ) ) {
		return trim( HAARMANN_GMAPS_API_KEY );
	}
	$option = get_option( 'haarmann_gmaps_api_key', '' );
	return is_string( $option ) ? trim( $option ) : '';
}

/**
 * Standort-Adresse für Google-Maps-Embeds (frei editierbar via wp_options).
 */
function haarmann_get_gmaps_address(): string {
	$option = get_option( 'haarmann_gmaps_address', 'Im Eisernen Zeit 1, 8057 Zürich' );
	return is_string( $option ) ? trim( $option ) : '';
}

/**
 * Standort-Koordinaten für die Map (Schaffhauserplatz Zürich als sinnvoller Default).
 *
 * @return array{lat: float, lng: float}
 */
function haarmann_get_gmaps_coords(): array {
	return array(
		'lat' => (float) get_option( 'haarmann_gmaps_lat', 47.3892 ),
		'lng' => (float) get_option( 'haarmann_gmaps_lng', 8.5402 ),
	);
}

/**
 * Lädt Google Maps JS API + Init-Script — aber nur auf Seiten, die das
 * Map-Pattern enthalten (Test via "haarmann-map"-Class im post_content).
 */
function haarmann_enqueue_maps_assets(): void {
	if ( ! is_singular() ) {
		return;
	}
	$post = get_post();
	if ( ! $post || strpos( (string) $post->post_content, 'haarmann-map' ) === false ) {
		return;
	}
	$api_key = haarmann_get_gmaps_api_key();
	if ( ! $api_key ) {
		return;
	}

	wp_enqueue_script(
		'haarmann-map',
		get_theme_file_uri( 'assets/js/map.js' ),
		array(),
		HAARMANN_THEME_VERSION,
		array( 'in_footer' => true )
	);

	$coords = haarmann_get_gmaps_coords();
	$config = array(
		'lat'     => (float) $coords['lat'],
		'lng'     => (float) $coords['lng'],
		'address' => haarmann_get_gmaps_address(),
		'zoom'    => 16,
	);
	// wp_add_inline_script statt wp_localize_script: localize würde alle
	// Werte zu Strings casten, wir brauchen lat/lng aber als JS-Number.
	wp_add_inline_script(
		'haarmann-map',
		'window.haarmannMapConfig = ' . wp_json_encode( $config ) . ';',
		'before'
	);

	wp_enqueue_script(
		'google-maps-js',
		'https://maps.googleapis.com/maps/api/js?key=' . rawurlencode( $api_key ) . '&loading=async&callback=haarmannMapInit',
		array( 'haarmann-map' ),
		null,
		array( 'in_footer' => true, 'strategy' => 'async' )
	);
}
add_action( 'wp_enqueue_scripts', 'haarmann_enqueue_maps_assets' );

/**
 * Register block pattern categories.
 */
function haarmann_register_pattern_categories(): void {
	register_block_pattern_category(
		'haarmann',
		array(
			'label'       => _x( 'Haarmann', 'Block pattern category', 'haarmann' ),
			'description' => __( 'Patterns für das Haarmann Theme.', 'haarmann' ),
		)
	);
}
add_action( 'init', 'haarmann_register_pattern_categories' );
