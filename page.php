<?php
/**
 * Páginas (carrito, pago, cuenta, políticas)
 */
get_header();
while ( have_posts() ) :
	the_post();
	$is_wc = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
	?>
	<div class="wrap page-content<?php echo $is_wc ? ' page-content--wide' : ''; ?>">
		<h1 class="h-l"><?php the_title(); ?></h1>
		<div class="rte"><?php the_content(); ?></div>
	</div>
	<?php
endwhile;
get_footer();
