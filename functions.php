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
	wp_enqueue_style( 'nia-v2', NIA_URI . '/assets/css/nia-v2.css', array( 'nia-woo' ), NIA_VERSION );
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

/* Sin el script de emojis de WordPress (más ligero) */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );

/* SEO de la portada (si se instala un plugin de SEO, ese manda) */
add_filter( 'pre_get_document_title', function ( $title ) {
	if ( is_front_page() && ! defined( 'WPSEO_VERSION' ) && ! class_exists( 'RankMath' ) ) {
		return 'Tapetes de lana hechos a mano en Oaxaca | Textiles José Mendoza';
	}
	return $title;
} );
add_action( 'wp_head', function () {
	if ( defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) ) {
		return;
	}
	$desc = '';
	if ( is_front_page() ) {
		$desc = 'Tapetes y tapices zapotecos de lana, yute y algodón, tejidos en telar de pedal con tintes naturales. Diseños a medida y envíos a México y el extranjero.';
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$desc = wp_strip_all_tags( get_the_excerpt() );
	} elseif ( is_tax() || is_category() ) {
		$desc = wp_strip_all_tags( term_description() );
	}
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( wp_trim_words( $desc, 30, '' ) ) . '">' . "\n";
	}
}, 2 );

/* Menú de respaldo cuando aún no se ha creado uno */
function nia_menu_fallback() {
	$shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	printf( '<a href="%s">Tienda</a>', esc_url( $shop ) );
	printf( '<a href="%s">Tapetes</a>', esc_url( nia_term_url( 'tapetes', $shop ) ) );
	printf( '<a href="%s">A medida</a>', esc_url( home_url( '/#a-medida' ) ) );
	printf( '<a href="%s">El taller</a>', esc_url( home_url( '/#taller' ) ) );
}
