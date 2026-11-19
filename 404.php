<?php
/**
 * Página no encontrada
 */
get_header();
?>
<div class="wrap not-found">
	<p class="eyebrow">Error 404</p>
	<h1 class="h-l">Esta página se nos fue del telar</h1>
	<p class="lede">El enlace no existe o la pieza ya se vendió.</p>
	<a class="btn" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>">Ver piezas disponibles</a>
</div>
<?php
get_footer();
