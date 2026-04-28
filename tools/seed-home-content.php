<?php
/**
 * Seed the Home page with the standard Haarmann one-pager block layout.
 *
 * Renders each Pattern (hero, welcome, booking, services, about, anreise, gallery)
 * once and writes the resulting block markup into the front page's post_content,
 * so all sections are immediately editable in the Block Editor.
 *
 * Usage (from project root):
 *   ddev wp eval-file tools/seed-home-content.php
 *
 * Idempotent — running it again overwrites the Home content with a fresh seed.
 * Useful after a fresh DB import or when a section was accidentally deleted.
 */

$slugs = array( 'hero', 'welcome', 'booking', 'services', 'about', 'anreise', 'gallery' );

$content = '';
foreach ( $slugs as $slug ) {
	$file = get_theme_file_path( "patterns/{$slug}.php" );
	if ( ! file_exists( $file ) ) {
		WP_CLI::error( "Pattern file not found: {$file}" );
	}
	ob_start();
	include $file;
	$rendered = trim( ob_get_clean() );
	$content .= $rendered . "\n\n";
}

$home_id = (int) get_option( 'page_on_front' );
if ( ! $home_id ) {
	WP_CLI::error( 'No front page set.' );
}

$result = wp_update_post(
	array(
		'ID'           => $home_id,
		'post_content' => $content,
	),
	true
);

if ( is_wp_error( $result ) ) {
	WP_CLI::error( $result->get_error_message() );
}

WP_CLI::success(
	sprintf(
		'Home page (ID %d) updated with %d sections, %d KB of block markup.',
		$home_id,
		count( $slugs ),
		strlen( $content ) / 1024
	)
);
