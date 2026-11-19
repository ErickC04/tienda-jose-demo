<?php
/**
 * Tarjeta de producto NIA (inicio y catálogo)
 *
 * @var array $args { product: WC_Product }
 */
$product = isset( $args['product'] ) ? $args['product'] : ( isset( $GLOBALS['product'] ) ? $GLOBALS['product'] : null );
if ( ! $product instanceof WC_Product ) {
	return;
}
$id      = $product->get_id();
$url     = $product->get_permalink();
$sizes   = nia_product_sizes( $product );
$type    = '';
$terms   = get_the_terms( $id, 'product_cat' );
if ( $terms && ! is_wp_error( $terms ) ) {
	$map  = array( 'tapetes' => 'Tapete', 'tapices' => 'Tapiz', 'cojines' => 'Cojín' );
	$slug = $terms[0]->slug;
	$type = isset( $map[ $slug ] ) ? $map[ $slug ] : $terms[0]->name;
}
$pedido = nia_is_made_to_order( $id );
?>
<article class="card">
	<div class="card-media">
		<a href="<?php echo esc_url( $url ); ?>" tabindex="-1" aria-hidden="true">
			<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'alt' => '' ) ); // phpcs:ignore ?>
		</a>
		<?php if ( ! $product->is_in_stock() ) : ?>
			<span class="badge">Vendido</span>
		<?php elseif ( $pedido ) : ?>
			<span class="badge badge--pedido">Sobre pedido</span>
		<?php elseif ( $product->is_on_sale() ) : ?>
			<span class="badge" style="background:var(--cochinilla);color:#fff">Oferta</span>
		<?php else : ?>
			<span class="badge">Pieza única</span>
		<?php endif; ?>
		<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
			<?php if ( $product->is_type( 'simple' ) ) : ?>
				<a class="card-quick button add_to_cart_button ajax_add_to_cart" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" data-product_id="<?php echo esc_attr( $id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow">Agregar al carrito</a>
			<?php else : ?>
				<a class="card-quick" href="<?php echo esc_url( $url ); ?>">Elegir medida</a>
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
