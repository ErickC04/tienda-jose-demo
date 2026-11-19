<?php
/**
 * Envoltura de las páginas de WooCommerce (catálogo, categorías, producto)
 */
get_header();
?>
<div class="wrap woo-wrap">
	<?php woocommerce_content(); ?>
</div>
<?php
get_footer();
