<?php
/**
 * Tarjeta de producto NIA (inicio y catálogo). Lleva datos para los filtros y el carrito de vista previa.
 *
 * @var array $args { product: WC_Product }
 */
$product = isset( $args['product'] ) ? $args['product'] : ( isset( $GLOBALS['product'] ) ? $GLOBALS['product'] : null );
if ( ! $product instanceof WC_Product ) {
	return;
}
$id     = $product->get_id();
$url    = $product->get_permalink();
$sizes  = nia_product_sizes( $product );
$type   = '';
$cat    = '';
$terms  = get_the_terms( $id, 'product_cat' );
if ( $terms && ! is_wp_error( $terms ) ) {
	$map  = array( 'tapetes' => 'Tapete', 'tapices' => 'Tapiz', 'cojines' => 'Cojín' );
	$cat  = $terms[0]->slug;
	$type = isset( $map[ $cat ] ) ? $map[ $cat ] : $terms[0]->name;
}
$tags   = wp_get_post_terms( $id, 'product_tag', array( 'fields' => 'slugs' ) );
$tags   = is_wp_error( $tags ) ? array() : $tags;
$pedido = nia_is_made_to_order( $id );
$price  = (float) ( $product->is_type( 'variable' ) ? $product->get_variation_price( 'min' ) : $product->get_price() );
/* Área aproximada (cm²) para ordenar por medida */
$area = 0;
if ( preg_match( '/(\d+)\s*[×x]\s*(\d+)/u', $sizes, $m ) ) {
	$area = (int) $m[1] * (int) $m[2];
} elseif ( preg_match( '/Ø\s*(\d+)/u', $sizes, $m ) ) {
	$area = (int) $m[1] * (int) $m[1];
}
$img_id  = $product->get_image_id();
$img_src = $img_id ? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
$first   = trim( explode( '/', $sizes )[0] );
?>
<article class="card" data-cat="<?php echo esc_attr( $cat ); ?>" data-tags="<?php echo esc_attr( implode( ' ', $tags ) ); ?>" data-stock="<?php echo $pedido ? 'pedido' : 'stock'; ?>" data-price="<?php echo esc_attr( $price ); ?>" data-area="<?php echo esc_attr( $area ); ?>">
	<div class="card-media">
		<a href="<?php echo esc_url( $url ); ?>" tabindex="-1" aria-hidden="true" class="card-img">
			<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'alt' => '' ) ); // phpcs:ignore ?>
		</a>
		<?php if ( ! $product->is_in_stock() ) : ?>
			<span class="badge">Vendido</span>
		<?php elseif ( $pedido ) : ?>
			<span class="badge badge--pedido">Por encargo</span>
		<?php elseif ( $product->is_on_sale() ) : ?>
			<span class="badge badge--oferta">Oferta</span>
		<?php else : ?>
			<span class="badge badge--stock">En stock</span>
		<?php endif; ?>
		<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
			<?php if ( $product->is_type( 'simple' ) ) : ?>
				<a class="card-quick add_to_cart_button ajax_add_to_cart" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" data-product_id="<?php echo esc_attr( $id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" data-nia-name="<?php echo esc_attr( $product->get_name() ); ?>" data-nia-price="<?php echo esc_attr( $price ); ?>" data-nia-size="<?php echo esc_attr( $first ); ?>" data-nia-img="<?php echo esc_url( $img_src ); ?>" rel="nofollow"><span>Agregar al carrito</span></a>
			<?php else : ?>
				<a class="card-quick" href="<?php echo esc_url( $url ); ?>"><span>Elegir medida</span></a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="card-body">
		<h3 class="card-title"><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
		<p class="card-meta"><?php echo esc_html( trim( $type . ( $type && $sizes ? ' · ' : '' ) . $sizes ) ); ?></p>
		<p class="card-price"><?php echo $product->is_type( 'variable' ) && $product->get_variation_price( 'min' ) !== $product->get_variation_price( 'max' ) ? 'Desde ' . wc_price( $product->get_variation_price( 'min' ) ) : $product->get_price_html(); // phpcs:ignore ?></p>
		<?php $colors = nia_product_colors( $id ); if ( $colors ) : ?>
			<div class="swatches" aria-hidden="true"><?php foreach ( $colors as $c ) : ?><i style="background:<?php echo esc_attr( $c[0] ); ?>"></i><?php endforeach; ?></div>
		<?php endif; ?>
	</div>
</article>
