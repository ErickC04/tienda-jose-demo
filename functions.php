<?php
/**
 * NIA Telar · funciones del tema
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NIA_VERSION', '1.0.0' );
define( 'NIA_URI', get_template_directory_uri() );
define( 'NIA_DIR', get_template_directory() );

require_once NIA_DIR . '/inc/helpers.php';
require_once NIA_DIR . '/inc/customizer.php';
require_once NIA_DIR . '/inc/woocommerce.php';
require_once NIA_DIR . '/inc/demo.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,
		'single_image_width'    => 1000,
		'product_grid'          => array( 'default_columns' => 4, 'default_rows' => 6 ),
	) );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	register_nav_menus( array(
		'principal' => 'Menú principal',
		'pie'       => 'Menú del pie',
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'nia', NIA_URI . '/assets/css/nia.css', array(), NIA_VERSION );
	wp_enqueue_style( 'nia-woo', NIA_URI . '/assets/css/woo.css', array( 'nia' ), NIA_VERSION );
	$fonts = '@font-face{font-family:"Fraunces";src:url(' . NIA_URI . '/assets/fonts/fraunces.woff2) format("woff2");font-weight:300 700;font-display:swap}'
		. '@font-face{font-family:"Fraunces";src:url(' . NIA_URI . '/assets/fonts/fraunces-italic.woff2) format("woff2");font-weight:300 700;font-style:italic;font-display:swap}'
		. '@font-face{font-family:"Instrument Sans";src:url(' . NIA_URI . '/assets/fonts/instrument-sans.woff2) format("woff2");font-weight:400 700;font-display:swap}';
	wp_add_inline_style( 'nia', $fonts );
	wp_enqueue_script( 'nia', NIA_URI . '/assets/js/nia.js', array(), NIA_VERSION, true );
} );

add_action( 'wp_head', function () {
	echo '<link rel="preload" href="' . esc_url( NIA_URI . '/assets/fonts/fraunces.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	echo '<link rel="preload" href="' . esc_url( NIA_URI . '/assets/fonts/instrument-sans.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
}, 1 );

/* Menú de respaldo cuando aún no se ha creado uno */
function nia_menu_fallback() {
	$shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	printf( '<a href="%s">Tienda</a>', esc_url( $shop ) );
	printf( '<a href="%s">Tapetes</a>', esc_url( nia_term_url( 'tapetes', $shop ) ) );
	printf( '<a href="%s">A medida</a>', esc_url( home_url( '/#a-medida' ) ) );
	printf( '<a href="%s">El taller</a>', esc_url( home_url( '/#taller' ) ) );
}
