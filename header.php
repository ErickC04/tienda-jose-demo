<?php
/**
 * Encabezado
 */
$announce = array_filter( array_map( 'trim', explode( '|', (string) get_theme_mod( 'nia_announce', 'Tejido a mano en Teotitlán del Valle|Envíos a todo México y al extranjero|Diseños a medida por WhatsApp' ) ) ) );
$cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' );
$count    = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="sr-only" href="#main">Saltar al contenido</a>

<?php if ( $announce ) : ?>
<div class="announce" role="region" aria-label="Avisos"><div class="wrap">
	<?php foreach ( $announce as $a ) : ?><span><?php echo esc_html( $a ); ?></span><?php endforeach; ?>
</div></div>
<?php endif; ?>

<div class="section-header">
<header class="header">
	<div class="wrap">
		<nav class="nav" aria-label="Principal"><?php nia_nav_links( 'principal' ); ?></nav>
		<button class="tool menu-btn" type="button" data-open="mobile-nav" aria-label="Abrir menú"><?php echo nia_icon( 'menu' ); ?></button>
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>, inicio">
			<img src="<?php echo esc_url( nia_img( 'nia-logo.png' ) ); ?>" alt="" width="44" height="44">
			<span><b>Nia Design</b><small>Textiles José Mendoza</small></span>
		</a>
		<div class="tools">
			<button class="tool" type="button" data-open="search" aria-label="Buscar"><?php echo nia_icon( 'search' ); ?></button>
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a class="tool" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="Cuenta"><?php echo nia_icon( 'user' ); ?></a>
			<?php endif; ?>
			<a class="tool" href="<?php echo esc_url( $cart_url ); ?>" aria-label="Carrito"><?php echo nia_icon( 'bag' ); ?><span class="label">Carrito</span><span class="cart-count" data-count><?php echo (int) $count; ?></span></a>
		</div>
	</div>
</header>
</div>

<dialog class="drawer drawer--left" id="mobile-nav" aria-label="Menú">
	<div class="drawer-head">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( nia_img( 'nia-logo.png' ) ); ?>" alt="" width="38" height="38"><span><b>Nia Design</b></span></a>
		<button class="x" type="button" data-close aria-label="Cerrar menú"><?php echo nia_icon( 'x' ); ?></button>
	</div>
	<div class="drawer-body mnav">
		<?php nia_nav_links( 'principal' ); ?>
		<h3>Por tipo</h3>
		<div class="sub">
			<a href="<?php echo esc_url( nia_term_url( 'listo-para-enviar' ) ); ?>">En stock</a>
			<a href="<?php echo esc_url( nia_term_url( 'pasilleros' ) ); ?>">Pasilleros y corredores</a>
			<a href="<?php echo esc_url( nia_term_url( 'circulares' ) ); ?>">Circulares</a>
			<a href="<?php echo esc_url( nia_term_url( 'gran-formato' ) ); ?>">Gran formato</a>
			<a href="<?php echo esc_url( nia_term_url( 'tapices' ) ); ?>">Tapices</a>
			<a href="<?php echo esc_url( nia_term_url( 'ofertas' ) ); ?>">Ofertas</a>
		</div>
		<h3>Taller</h3>
		<div class="sub">
			<a href="<?php echo esc_url( home_url( '/#a-medida' ) ); ?>">A medida</a>
			<a href="<?php echo esc_url( home_url( '/#proyectos' ) ); ?>">Proyectos</a>
			<a href="<?php echo esc_url( home_url( '/#preguntas' ) ); ?>">Preguntas frecuentes</a>
		</div>
	</div>
</dialog>

<dialog class="search" id="search" aria-label="Buscar">
	<form class="search-field" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php echo nia_icon( 'search' ); ?>
		<label class="sr-only" for="q">Buscar piezas</label>
		<input id="q" type="search" name="s" placeholder="Busca por pieza, color o medida" autocomplete="off">
		<input type="hidden" name="post_type" value="product">
		<button class="x" type="button" data-close aria-label="Cerrar búsqueda"><?php echo nia_icon( 'x' ); ?></button>
	</form>
</dialog>

<main id="main">
