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
