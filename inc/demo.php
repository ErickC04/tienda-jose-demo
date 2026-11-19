<?php
/**
 * NIA · instalación de la tienda de demostración
 * Apariencia › Demo NIA (o nia_demo_install() desde un blueprint).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nia_demo_tag_names() {
	return array(
		'pequenos' => 'Pequeños', 'medianos' => 'Medianos', 'grandes' => 'Grandes', 'gran-formato' => 'Gran formato',
		'corredores' => 'Corredores', 'redondos' => 'Redondos y ovalados',
		'tradicional-zapoteca' => 'Tradicional zapoteca', 'geometrico-contemporaneo' => 'Geométrico contemporáneo',
		'organico-abstracto' => 'Orgánico y abstracto', 'minimalista-natural' => 'Minimalista natural',
		'listo-para-enviar' => 'Listos para enviar', 'sobre-pedido' => 'Sobre pedido',
	);
}

/** Crea categorías, productos, menú y ajustes. Devuelve un resumen. */
function nia_demo_install() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return 'WooCommerce no está activo.';
	}
	@set_time_limit( 300 ); // phpcs:ignore
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	/* Ajustes de tienda */
	update_option( 'woocommerce_currency', 'MXN' );
	update_option( 'woocommerce_currency_pos', 'left' );
	update_option( 'woocommerce_price_thousand_sep', ',' );
	update_option( 'woocommerce_price_decimal_sep', '.' );
	update_option( 'woocommerce_price_num_decimals', 0 );
	update_option( 'woocommerce_default_country', 'MX:OA' );
	update_option( 'woocommerce_coming_soon', 'no' );
	update_option( 'woocommerce_store_pages_only', 'no' );
	update_option( 'blogname', 'NIA · Textiles José Mendoza' );
	update_option( 'blogdescription', 'Tapetes zapotecos tejidos a mano en Teotitlán del Valle' );
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	/* Direcciones en español */
	update_option( 'woocommerce_permalinks', array_merge( (array) get_option( 'woocommerce_permalinks', array() ), array(
		'product_base'  => '/producto',
		'category_base' => 'categoria',
		'tag_base'      => 'etiqueta',
	) ) );
	/* Páginas de WooCommerce en español */
	$pages = array( 'shop' => array( 'Tienda', 'tienda' ), 'cart' => array( 'Carrito', 'carrito' ), 'checkout' => array( 'Pago', 'pago' ), 'myaccount' => array( 'Mi cuenta', 'mi-cuenta' ) );
	foreach ( $pages as $key => $pg ) {
		$pid = wc_get_page_id( $key );
		if ( $pid > 0 ) {
			wp_update_post( array( 'ID' => $pid, 'post_title' => $pg[0], 'post_name' => $pg[1] ) );
		}
	}

	/* Pago de demostración: transferencia bancaria */
	$bacs = (array) get_option( 'woocommerce_bacs_settings', array() );
	update_option( 'woocommerce_bacs_settings', array_merge( $bacs, array(
		'enabled'      => 'yes',
		'title'        => 'Transferencia bancaria',
		'description'  => 'Tienda de demostración: el pedido se registra pero no se cobra nada.',
		'instructions' => 'Gracias. Esta es una tienda de demostración: no se realizó ningún cobro.',
	) ) );

	/* Envío: zona México con envío gratis de demostración */
	if ( class_exists( 'WC_Shipping_Zones' ) ) {
		$exists = false;
		foreach ( WC_Shipping_Zones::get_zones() as $z ) {
			if ( 'México' === $z['zone_name'] ) {
				$exists = true;
			}
		}
		if ( ! $exists ) {
			$zone = new WC_Shipping_Zone();
			$zone->set_zone_name( 'México' );
			$zone->add_location( 'MX', 'country' );
			$zone->save();
			$zone->add_shipping_method( 'free_shipping' );
		}
	}

	/* Categorías */
	$cats = array( 'tapetes' => 'Tapetes', 'tapices' => 'Tapices', 'cojines' => 'Cojines' );
	foreach ( $cats as $slug => $name ) {
		if ( ! term_exists( $slug, 'product_cat' ) ) {
			wp_insert_term( $name, 'product_cat', array( 'slug' => $slug ) );
		}
	}
	$tag_names = nia_demo_tag_names();
	$colors    = nia_color_map();

	/* Productos */
	$data    = include __DIR__ . '/demo-data.php';
	$created = 0;
	$images  = 0;
	foreach ( $data as $i => $p ) {
		if ( get_page_by_path( $p['slug'], OBJECT, 'product' ) ) {
			continue;
		}
		$variable = count( $p['sizes'] ) > 1;
		$product  = $variable ? new WC_Product_Variable() : new WC_Product_Simple();
		$product->set_name( $p['name'] );
		$product->set_slug( $p['slug'] );
		$product->set_status( 'publish' );
		$product->set_description( '<p>' . $p['desc'] . '</p>' );
		$product->set_short_description( '<p>' . $p['desc'] . '</p>' );
		$product->set_menu_order( $i );
		$product->set_sku( 'NIA-' . str_pad( (string) ( $i + 1 ), 3, '0', STR_PAD_LEFT ) );
		$pedido = in_array( 'sobre-pedido', $p['tags'], true );

		if ( $variable ) {
			$attr = new WC_Product_Attribute();
			$attr->set_name( 'Medida' );
			$attr->set_options( wp_list_pluck( $p['sizes'], 0 ) );
			$attr->set_visible( true );
			$attr->set_variation( true );
			$product->set_attributes( array( $attr ) );
		} else {
			$product->set_regular_price( (string) $p['sizes'][0][1] );
			$product->update_meta_data( '_nia_medida', $p['sizes'][0][0] );
			if ( $pedido ) {
				$product->set_manage_stock( false );
				$product->set_stock_status( 'onbackorder' );
			} else {
				$product->set_manage_stock( true );
				$product->set_stock_quantity( 1 );
				$product->set_sold_individually( true );
			}
		}
		$pid = $product->save();

		if ( $variable ) {
			foreach ( $p['sizes'] as $k => $s ) {
				$v = new WC_Product_Variation();
				$v->set_parent_id( $pid );
				$v->set_attributes( array( 'medida' => $s[0] ) );
				$v->set_regular_price( (string) $s[1] );
				$v->set_sku( 'NIA-' . str_pad( (string) ( $i + 1 ), 3, '0', STR_PAD_LEFT ) . '-' . ( $k + 1 ) );
				if ( $pedido || $k > 0 ) {
					$v->set_manage_stock( false );
					$v->set_stock_status( 'onbackorder' );
				} else {
					$v->set_manage_stock( true );
					$v->set_stock_quantity( 1 );
				}
				$v->save();
			}
			WC_Product_Variable::sync( $pid );
		}

		wp_set_object_terms( $pid, $p['cat'], 'product_cat' );
		$tag_ids = array();
		foreach ( $p['tags'] as $slug ) {
			$term = get_term_by( 'slug', $slug, 'product_tag' );
			if ( ! $term ) {
				$label = isset( $tag_names[ $slug ] ) ? $tag_names[ $slug ] : ( 0 === strpos( $slug, 'color-' ) && isset( $colors[ substr( $slug, 6 ) ] ) ? 'Color ' . strtolower( $colors[ substr( $slug, 6 ) ][1] ) : $slug );
				$ins   = wp_insert_term( $label, 'product_tag', array( 'slug' => $slug ) );
				if ( ! is_wp_error( $ins ) ) {
					$tag_ids[] = (int) $ins['term_id'];
				}
			} else {
				$tag_ids[] = (int) $term->term_id;
			}
		}
		wp_set_object_terms( $pid, $tag_ids, 'product_tag' );

		/* Foto: se copia desde la carpeta demo/ del tema a la biblioteca de medios */
		$att = nia_demo_attach( NIA_DIR . '/demo/' . $p['image'], $pid, $p['name'] );
		if ( $att && ! is_wp_error( $att ) ) {
			update_post_meta( $att, '_wp_attachment_image_alt', $p['name'] . ', tejido a mano en Teotitlán del Valle' );
			set_post_thumbnail( $pid, $att );
			$images++;
		}
		$created++;
	}

	/* Menú principal */
	if ( ! wp_get_nav_menu_object( 'Principal NIA' ) ) {
		$menu_id = wp_create_nav_menu( 'Principal NIA' );
		$items   = array(
			array( 'Tienda', wc_get_page_permalink( 'shop' ) ),
			array( 'Tapetes', nia_term_url( 'tapetes' ) ),
			array( 'A medida', home_url( '/#a-medida' ) ),
			array( 'El taller', home_url( '/#taller' ) ),
		);
		foreach ( $items as $it ) {
			wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => $it[0], 'menu-item-url' => $it[1], 'menu-item-status' => 'publish', 'menu-item-type' => 'custom' ) );
		}
		$loc              = get_theme_mod( 'nav_menu_locations', array() );
		$loc['principal'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $loc );
	}

	flush_rewrite_rules();
	update_option( 'nia_demo_done', time() );
	return sprintf( 'Listo: %d productos creados, %d fotos descargadas.', $created, $images );
}

/** Copia un archivo del tema a Medios y lo adjunta al producto. */
function nia_demo_attach( $path, $parent, $title ) {
	if ( ! file_exists( $path ) ) {
		return 0;
	}
	$upload = wp_upload_bits( basename( $path ), null, file_get_contents( $path ) ); // phpcs:ignore
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}
	$att = wp_insert_attachment( array(
		'post_mime_type' => 'image/jpeg',
		'post_title'     => $title,
		'post_status'    => 'inherit',
	), $upload['file'], $parent );
	if ( is_wp_error( $att ) ) {
		return 0;
	}
	wp_update_attachment_metadata( $att, wp_generate_attachment_metadata( $att, $upload['file'] ) );
	return $att;
}

/* Página en Apariencia › Demo NIA */
add_action( 'admin_menu', function () {
	add_theme_page( 'Demo NIA', 'Demo NIA', 'manage_options', 'nia-demo', 'nia_demo_page' );
} );

function nia_demo_page() {
	$msg = '';
	if ( isset( $_POST['nia_demo'] ) && check_admin_referer( 'nia_demo' ) ) {
		$msg = nia_demo_install();
	}
	echo '<div class="wrap"><h1>Tienda de demostración NIA</h1>';
	if ( $msg ) {
		echo '<div class="notice notice-success"><p>' . esc_html( $msg ) . '</p></div>';
	}
	if ( ! class_exists( 'WooCommerce' ) ) {
		echo '<p><strong>Primero instala y activa WooCommerce</strong> (Plugins › Añadir nuevo).</p></div>';
		return;
	}
	echo '<p>Crea las categorías Tapetes, Tapices y Cojines, 20 piezas de muestra con fotos, precios en pesos mexicanos y el menú principal. Los precios y medidas son de muestra: bórralos o reemplázalos antes de lanzar.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'nia_demo' );
	submit_button( get_option( 'nia_demo_done' ) ? 'Volver a ejecutar (solo agrega lo que falte)' : 'Instalar demostración', 'primary', 'nia_demo' );
	echo '</form></div>';
}

/* Aviso tras activar el tema */
add_action( 'admin_notices', function () {
	if ( get_option( 'nia_demo_done' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_nia-demo' === $screen->id ) {
		return;
	}
	echo '<div class="notice notice-info"><p><strong>NIA Telar:</strong> ¿Quieres cargar la tienda de demostración? <a href="' . esc_url( admin_url( 'themes.php?page=nia-demo' ) ) . '">Apariencia › Demo NIA</a></p></div>';
} );
