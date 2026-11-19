<?php
/**
 * NIA · utilidades
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Enlaces planos de un menú (solo primer nivel). $wrap = '' o 'li' */
function nia_nav_links( $location, $wrap = '' ) {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		if ( 'principal' === $location ) {
			nia_menu_fallback();
		}
		return;
	}
	$items = wp_get_nav_menu_items( $locations[ $location ] );
	if ( ! $items ) {
		return;
	}
	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent ) {
			continue;
		}
		$a = sprintf( '<a href="%s">%s</a>', esc_url( $item->url ), esc_html( $item->title ) );
		echo $wrap ? '<li>' . $a . '</li>' : $a; // phpcs:ignore
	}
}

/** URL de una imagen incluida en el tema */
function nia_img( $file ) {
	return NIA_URI . '/assets/img/' . $file;
}

/** Enlace a una categoría de producto por slug; si no existe, a $fallback */
function nia_term_url( $slug, $fallback = '' ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( ! $term ) {
		$term = get_term_by( 'slug', $slug, 'product_tag' );
	}
	if ( $term && ! is_wp_error( $term ) ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}
	if ( $fallback ) {
		return $fallback;
	}
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}

/** Número de productos en una categoría o etiqueta */
function nia_term_count( $slug ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( ! $term ) {
		$term = get_term_by( 'slug', $slug, 'product_tag' );
	}
	return $term && ! is_wp_error( $term ) ? (int) $term->count : 0;
}

function nia_pieces( $n ) {
	return $n . ( 1 === $n ? ' pieza' : ' piezas' );
}

/** Ícono de línea (SVG) */
function nia_icon( $name, $class = 'icon' ) {
	$paths = array(
		'search'  => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'bag'     => '<path d="M5 8h14l-1 12H6L5 8Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>',
		'user'    => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/>',
		'menu'    => '<path d="M3 7h18M3 12h18M3 17h18"/>',
		'x'       => '<path d="M6 6l12 12M18 6 6 18"/>',
		'loom'    => '<path d="M3 4.5h18M3 19.5h18M5.2 4.5v15M18.8 4.5v15M8.2 7.5v9M11.2 7.5v9M14.2 7.5v9M5.2 12h13.6"/>',
		'drop'    => '<path d="M12 3c3.8 5.2 6 8.2 6 11.2a6 6 0 0 1-12 0c0-3 2.2-6 6-11.2Z"/><path d="M9 15a3 3 0 0 0 3 3"/>',
		'diamond' => '<path d="M12 2.2 21.8 12 12 21.8 2.2 12Z"/><path d="M12 7.5l4.5 4.5-4.5 4.5-4.5-4.5Z"/>',
		'truck'   => '<path d="M2.2 6h12v10.5h-12zM14.2 9.8h4.5l3 3.7v3h-7.5"/><circle cx="6.8" cy="18" r="1.9"/><circle cx="18" cy="18" r="1.9"/>',
		'wa'      => '<path d="M4 20l1.2-3.6A8 8 0 1 1 8 19.1L4 20Z"/><path d="M9 9.5c0 3 2.5 5.5 5.5 5.5l1-1.5-2-1-1 .8a4 4 0 0 1-1.8-1.8l.8-1-1-2L9 9.5Z"/>',
		'ig'      => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".6"/>',
		'fb'      => '<path d="M14 8h3V4h-3a4 4 0 0 0-4 4v3H7v4h3v6h4v-6h3l1-4h-4V8Z"/>',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 24 24" aria-hidden="true">' . $paths[ $name ] . '</svg>';
}

/** WhatsApp limpio (solo dígitos) */
function nia_whatsapp() {
	return preg_replace( '/\D+/', '', (string) get_theme_mod( 'nia_whatsapp', '' ) );
}

function nia_whatsapp_url( $text = '' ) {
	$n = nia_whatsapp();
	if ( ! $n ) {
		return '';
	}
	return 'https://wa.me/' . $n . ( $text ? '?text=' . rawurlencode( $text ) : '' );
}

/** Enlace de WhatsApp con mensaje (o '' si aún no hay número) */
function nia_wa_link( $text = '' ) {
	return nia_whatsapp_url( $text );
}

/** Atributos para un enlace de WhatsApp: real si hay número; si no, aviso de demostración */
function nia_wa_attrs( $url ) {
	if ( $url ) {
		return 'href="' . esc_url( $url ) . '" target="_blank" rel="noopener"';
	}
	return 'href="#" data-demo="Aquí se conecta el WhatsApp del taller: al tocarlo se abre el chat con José y el mensaje ya escrito."';
}

/** Muestras de color a partir de etiquetas color-xxx */
function nia_color_map() {
	return array(
		'anil' => array( '#27425d', 'Añil' ), 'cochinilla' => array( '#8d353d', 'Cochinilla' ), 'pericon' => array( '#d3a34e', 'Pericón' ),
		'crudo' => array( '#ece4d5', 'Crudo' ), 'carbon' => array( '#25221f', 'Carbón' ), 'naranja' => array( '#c76a35', 'Naranja' ),
		'gris' => array( '#8c8780', 'Gris' ), 'verde' => array( '#5f6b3a', 'Verde' ), 'terracota' => array( '#a4553b', 'Terracota' ),
		'rosa' => array( '#d49a92', 'Rosa' ), 'turquesa' => array( '#2f8f95', 'Turquesa' ),
	);
}

function nia_product_colors( $product_id ) {
	$out  = array();
	$map  = nia_color_map();
	$tags = wp_get_post_terms( $product_id, 'product_tag', array( 'fields' => 'slugs' ) );
	if ( is_wp_error( $tags ) ) {
		return $out;
	}
	foreach ( $tags as $slug ) {
		if ( 0 === strpos( $slug, 'color-' ) ) {
			$key = substr( $slug, 6 );
			if ( isset( $map[ $key ] ) ) {
				$out[ $key ] = $map[ $key ];
			}
		}
	}
	return $out;
}

/** ¿La pieza se teje sobre pedido? */
function nia_is_made_to_order( $product_id ) {
	return has_term( 'sobre-pedido', 'product_tag', $product_id );
}

/** Medidas de un producto (atributo Medida o metadato) */
function nia_product_sizes( $product ) {
	if ( ! $product ) {
		return '';
	}
	$attr = $product->get_attribute( 'medida' );
	if ( ! $attr ) {
		$attr = $product->get_attribute( 'pa_medida' );
	}
	if ( ! $attr ) {
		$attr = $product->get_meta( '_nia_medida' );
	}
	return $attr ? str_replace( ', ', ' / ', str_replace( ' | ', ' / ', $attr ) ) : '';
}
