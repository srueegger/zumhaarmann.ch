<?php
/**
 * Seed the Home page with the standard Haarmann one-pager block layout.
 *
 * Renders each Pattern (hero, welcome, booking, services, about, anreise,
 * map, gallery) once and writes the resulting block markup into the front
 * page's post_content, so all sections are immediately editable in the
 * Block Editor.
 *
 * Usage (from project root):
 *   ddev wp eval-file tools/seed-home-content.php
 *
 * Idempotent — running it again overwrites the Home content with a fresh
 * seed. Useful after a fresh DB import or when a section was accidentally
 * deleted in the editor.
 *
 * Bewusst ohne WP_CLI::-Calls geschrieben, damit auch ein "wp eval-file"
 * ohne CLI-Klassenkontext (oder eine statische Analyse ausserhalb von
 * WordPress) keinen Fehler wirft.
 */

if ( ! function_exists( 'get_theme_file_path' ) ) {
	fwrite( STDERR, "This script needs to run inside WordPress (use: ddev wp eval-file tools/seed-home-content.php).\n" );
	exit( 1 );
}

$slugs = array( 'hero', 'welcome', 'booking', 'services', 'about', 'anreise', 'map', 'gallery' );

$content = '';
foreach ( $slugs as $slug ) {
	$file = get_theme_file_path( "patterns/{$slug}.php" );
	if ( ! file_exists( $file ) ) {
		fwrite( STDERR, "Pattern file not found: {$file}\n" );
		exit( 1 );
	}
	ob_start();
	include $file;
	$rendered = trim( ob_get_clean() );
	$content .= $rendered . "\n\n";
}

$home_id = (int) get_option( 'page_on_front' );
if ( ! $home_id ) {
	fwrite( STDERR, "No front page set (option page_on_front is empty).\n" );
	exit( 1 );
}

$result = wp_update_post(
	array(
		'ID'           => $home_id,
		'post_content' => $content,
	),
	true
);

if ( is_wp_error( $result ) ) {
	fwrite( STDERR, 'wp_update_post failed: ' . $result->get_error_message() . "\n" );
	exit( 1 );
}

printf(
	"Home page (ID %d) updated with %d sections, %d KB of block markup.\n",
	$home_id,
	count( $slugs ),
	(int) ( strlen( $content ) / 1024 )
);
