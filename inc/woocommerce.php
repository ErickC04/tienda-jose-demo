<?php
/**
 * NIA · ajustes de WooCommerce
 */
if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) {
	return;
}

/* Sin barra lateral; 3 columnas en catálogo */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'loop_shop_per_page', function () { return 24; } );

/* Migas de pan con el estilo NIA */
add_filter( 'woocommerce_breadcrumb_defaults', function ( $d ) {
	$d['wrap_before'] = '<nav class="crumbs" aria-label="Ruta">';
	$d['wrap_after']  = '</nav>';
	$d['delimiter']   = '<span aria-hidden="true">/</span>';
	$d['home']        = 'Inicio';
	return $d;
} );

/* Contador del carrito en el encabezado (se actualiza al agregar por AJAX) */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$fragments['span.cart-count'] = '<span class="cart-count" data-count>' . (int) WC()->cart->get_cart_contents_count() . '</span>';
	return $fragments;
} );

/* Título del catálogo con antetítulo */
add_action( 'woocommerce_archive_description', function () {
	if ( is_shop() ) {
		echo '<p class="lede" style="margin:10px 0 0">Tapetes, tapices y cojines del taller, tejidos a mano en Teotitlán del Valle.</p>';
	}
}, 5 );

/* Ficha de producto ------------------------------------------------------ */

/* Botón de compra para piezas sobre pedido */
add_filter( 'woocommerce_product_single_add_to_cart_text', function ( $text, $product ) {
	return nia_is_made_to_order( $product->get_id() ) ? 'Apartar con anticipo' : 'Agregar al carrito';
}, 10, 2 );

/* Aviso de disponibilidad debajo del precio */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	if ( nia_is_made_to_order( $product->get_id() ) ) {
		echo '<div class="stock pedido"><i></i><span><b>Se teje sobre pedido.</b> Te confirmamos el tiempo de tejido al apartar.</span></div>';
	} elseif ( $product->is_in_stock() ) {
		echo '<div class="stock"><i></i><span><b>Pieza única.</b> Sale del taller en 2 a 4 días hábiles.</span></div>';
	}
}, 15 );

/* WhatsApp y especificaciones después del botón de compra */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$wa = nia_whatsapp_url( 'Hola, me interesa la pieza "' . $product->get_name() . '": ' . $product->get_permalink() );
	if ( $wa ) {
		echo '<a class="ask" href="' . esc_url( $wa ) . '" target="_blank" rel="noopener">' . nia_icon( 'wa', 'icon' ) . 'Preguntar por esta pieza en WhatsApp</a>'; // phpcs:ignore
	}
	$colors = wp_list_pluck( nia_product_colors( $product->get_id() ), 1 );
	$specs  = array(
		'Técnica'  => $product->get_meta( '_nia_tecnica' ) ? $product->get_meta( '_nia_tecnica' ) : 'Tejido a mano en telar de pedal',
		'Material' => $product->get_meta( '_nia_material' ) ? $product->get_meta( '_nia_material' ) : 'Lana',
		'Tintes'   => $product->get_meta( '_nia_tintes' ) ? $product->get_meta( '_nia_tintes' ) : 'Naturales: cochinilla, añil y pericón',
		'Colores'  => $colors ? implode( ', ', $colors ) : '',
		'Origen'   => 'Teotitlán del Valle, Oaxaca',
	);
	echo '<dl class="specs">';
	foreach ( $specs as $k => $v ) {
		if ( $v ) {
			echo '<dt>' . esc_html( $k ) . '</dt><dd>' . esc_html( $v ) . '</dd>';
		}
	}
	echo '</dl>';
	echo '<details class="acc"><summary>Cuidados</summary><div><p>Aspira sin cepillo giratorio. Gira el tapete cada pocos meses para que el desgaste sea parejo. Limpia derrames de inmediato con un paño húmedo y agua fría. Para limpieza profunda, recomendamos lavado profesional en seco.</p></div></details>';
	echo '<details class="acc"><summary>Envíos y devoluciones</summary><div><p>Enviamos a todo México con guía rastreable. Envíos internacionales bajo cotización. Las piezas a medida no admiten devolución.</p></div></details>';
}, 35 );

/* Quitar meta (SKU, categorías, etiquetas de color) de la ficha */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/* Pestañas: solo descripción, con título propio */
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	unset( $tabs['additional_information'], $tabs['reviews'] );
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = 'Sobre esta pieza';
	}
	return $tabs;
}, 98 );
add_filter( 'woocommerce_product_description_heading', '__return_empty_string' );

/* Relacionados */
add_filter( 'woocommerce_product_related_products_heading', function () { return 'También te puede gustar'; } );
add_filter( 'woocommerce_output_related_products_args', function ( $a ) {
	$a['posts_per_page'] = 4;
	$a['columns']        = 4;
	return $a;
} );

/* Texto del botón de agregar en listados de WooCommerce (bloques, widgets) */
add_filter( 'woocommerce_product_add_to_cart_text', function ( $text, $product ) {
	return $product->is_type( 'variable' ) ? 'Elegir medida' : 'Agregar al carrito';
}, 10, 2 );
