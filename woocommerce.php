<?php
/**
 * Envoltura de WooCommerce. En tienda, categorías y etiquetas agrega encabezado, filtros y orden (en el navegador).
 */
get_header();

$is_archive = function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() );
if ( ! $is_archive ) :
	?>
	<div class="wrap woo-wrap"><?php woocommerce_content(); ?></div>
	<?php
	get_footer();
	return;
endif;

$title = is_shop() ? 'Toda la tienda' : single_term_title( '', false );
$desc  = is_shop() ? 'Tapetes y tapices de lana, yute y algodón, tejidos a mano en telar de pedal en Teotitlán del Valle.' : wp_strip_all_tags( term_description() );
if ( ! $desc && is_product_taxonomy() ) {
	$desc = 'Piezas tejidas a mano en Teotitlán del Valle. Cualquier diseño puede hacerse a medida.';
}
$groups = array(
	'cat'   => array( 'Tipo', array( 'tapetes' => 'Tapetes', 'tapices' => 'Tapices', 'cojines' => 'Cojines' ) ),
	'size'  => array( 'Medida', array( 'pequenos' => 'Pequeños · 60 × 100', 'medianos' => '80 × 150 cm', 'grandes' => '2 × 3 m', 'gran-formato' => 'Gran formato', 'pasilleros' => 'Pasilleros', 'circulares' => 'Circulares' ) ),
	'style' => array( 'Estilo', array( 'organico-abstracto' => 'Contemporáneo y orgánico', 'geometrico-contemporaneo' => 'Geométrico', 'minimalista-natural' => 'Minimalista', 'tradicional-zapoteca' => 'Grecas zapotecas' ) ),
	'stock' => array( 'Disponibilidad', array( 'stock' => 'En stock', 'pedido' => 'Por encargo' ) ),
	'price' => array( 'Precio', array( '0-5000' => 'Menos de $5,000', '5000-15000' => '$5,000 a $15,000', '15000-999999' => 'Más de $15,000' ) ),
);
?>
<div class="wrap shop">
	<?php woocommerce_breadcrumb(); ?>
	<header class="shop-head">
		<div>
			<p class="eyebrow">Tienda</p>
			<h1 class="h-l"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $desc ) : ?><p class="lede"><?php echo esc_html( $desc ); ?></p><?php endif; ?>
		</div>
	</header>

	<div class="shop-layout" data-shop>
		<aside class="shop-filters" id="shop-filters" aria-label="Filtros">
			<div class="shop-filters-head"><strong>Filtros</strong><button class="x" type="button" data-filters-close aria-label="Cerrar filtros"><?php echo nia_icon( 'x' ); ?></button></div>
			<?php foreach ( $groups as $key => $g ) : ?>
				<fieldset class="facet" data-facet="<?php echo esc_attr( $key ); ?>">
					<legend><?php echo esc_html( $g[0] ); ?></legend>
					<?php foreach ( $g[1] as $val => $label ) : ?>
						<label><input type="checkbox" value="<?php echo esc_attr( $val ); ?>"><span class="facet-label"><?php echo esc_html( $label ); ?></span><span class="facet-count" data-count-for="<?php echo esc_attr( $key . ':' . $val ); ?>"></span></label>
					<?php endforeach; ?>
				</fieldset>
			<?php endforeach; ?>
			<button class="btn btn--block shop-apply" type="button" data-filters-close>Ver piezas</button>
		</aside>

		<div class="shop-main">
			<div class="shop-toolbar">
				<button class="btn btn--ghost shop-filters-btn" type="button" data-filters-open><?php echo nia_icon( 'menu', 'icon' ); ?>Filtros</button>
				<span class="shop-count" data-shop-count role="status"></span>
				<label class="shop-sort">Ordenar
					<select data-shop-sort>
						<option value="">Destacados</option>
						<option value="price-asc">Precio: menor a mayor</option>
						<option value="price-desc">Precio: mayor a menor</option>
						<option value="area-asc">Medida: menor a mayor</option>
						<option value="area-desc">Medida: mayor a menor</option>
					</select>
				</label>
			</div>
			<div class="shop-chips" data-shop-chips></div>
			<?php woocommerce_content(); ?>
			<div class="shop-empty" data-shop-empty hidden>
				<p class="lede">No hay piezas con esos filtros ahora mismo.</p>
				<p>Cualquier diseño puede tejerse a medida.</p>
				<a class="btn btn--pericon" href="<?php echo esc_url( home_url( '/#a-medida' ) ); ?>">Pedir una pieza a medida</a>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
