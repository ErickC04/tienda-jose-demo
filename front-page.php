<?php
/**
 * Página de inicio NIA
 */
get_header();

$shop  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$wa_q  = nia_whatsapp_url( 'Hola, me interesa una pieza a medida. Medidas aproximadas: ' );
$wa_v  = nia_whatsapp_url( 'Hola, me gustaría agendar una visita al taller.' );
$email = get_theme_mod( 'nia_email', '' );
$ig    = get_theme_mod( 'nia_instagram', 'https://www.instagram.com/josemendozatextiles/' );

$collage = array(
	1 => array(
		array( 'tapetes-estrella-enrollados.jpg', 'Estrellas recién enrolladas, listas para salir del taller.', false ),
		array( 'proceso-tejido-hilos-lana-colores.jpg', 'Madejas teñidas a mano, antes del telar.', false ),
		array( 'tapete-ovalado-azul-crudo-taller.jpg', 'Óvalo añil, recién bajado del telar.', false ),
	),
	2 => array(
		array( 'telar-nuevo-520cm-madera.jpg', 'El telar nuevo: 5,20 m de madera.', true ),
		array( 'tapete-organico-ambientado-sala.jpg', 'Un tapete del taller, ya en casa.', false ),
		array( 'tapete-ajedrez-mostaza-240x450.jpg', 'Ajedrez mostaza, 2,4 × 4,5 m.', false ),
	),
	3 => array(
		array( 'tapete-gran-formato-terracota-taller.jpg', 'Gran formato, extendido para revisión.', false ),
		array( 'proceso-telar-canillas-hilo.jpg', 'Canillas cargadas, sobre la trama.', false ),
		array( 'tapete-tradicional-80x150-grecas-zapotecas.jpg', 'Grecas de la tradición del valle.', false ),
	),
);
$cats = array(
	array( 'tapetes', 'Tapetes', 'tapete-organico-ambientado-sala.jpg' ),
	array( 'tapices', 'Tapices', 'tapiz-montanas-tierra.jpg' ),
	array( 'cojines', 'Cojines', 'funda-cojin-lana-naranja.jpg' ),
	array( 'gran-formato', 'Gran formato', 'tapete-300x500-diamantes-neutros.jpg' ),
	array( 'listo-para-enviar', 'Listos para enviar', 'tapetes-estrella-enrollados.jpg' ),
);
$sizes = array(
	array( 'pequenos', 'Pequeños', '60 × 100 cm', 'Entrada · junto a la cama', 100, 60, false ),
	array( 'medianos', 'Medianos', '80 × 150 a 120 × 180', 'Recámara · estudio', 180, 120, false ),
	array( 'grandes', 'Grandes', '160 × 230 a 200 × 300', 'Sala · comedor', 300, 200, false ),
	array( 'gran-formato', 'Gran formato', '240 × 450 cm y más', 'Salas amplias · proyectos', 500, 300, false ),
	array( 'corredores', 'Corredores', '80 × 300 cm', 'Pasillos · cocinas', 300, 80, false ),
	array( 'redondos', 'Redondos y ovalados', 'Ø 150 a 150 × 220', 'Comedor · rincones', 220, 150, true ),
);
$styles = array(
	array( 'tradicional-zapoteca', 'Tradicional zapoteca', 'Grecas, rombos y estrellas escalonadas de la tradición del valle.', 'tapete-tradicional-80x150-grecas-zapotecas.jpg' ),
	array( 'geometrico-contemporaneo', 'Geométrico contemporáneo', 'Retículas, franjas y ángulos en paletas actuales.', 'tapete-80x150-geometrico-naranja-gris.jpg' ),
	array( 'organico-abstracto', 'Orgánico y abstracto', 'Formas libres y bloques de color, cercanos al arte textil.', 'tapete-contemporaneo-formas-organicas.jpg' ),
	array( 'minimalista-natural', 'Minimalista natural', 'Lana cruda, jaspes y líneas de carbón.', 'tapete-minimalista-crudo-cuadros-negros.jpg' ),
);
$steps = array(
	array( 'proceso-tejido-hilos-lana-colores.jpg', 'Teñido', 'La lana se tiñe con cochinilla, añil y pericón hasta lograr la paleta del diseño.' ),
	array( 'telar-nuevo-520cm-madera.jpg', 'Urdido', 'Se montan los hilos de la urdimbre en el telar de pedal, a la medida de la pieza.' ),
	array( 'proceso-telar-canillas-hilo.jpg', 'Tejido', 'Pasada a pasada, el diseño aparece a mano. Una pieza grande toma semanas.' ),
	array( 'tapetes-estrella-enrollados.jpg', 'Acabado', 'Se anudan los flecos, se revisa la pieza y se enrolla para el envío.' ),
);

$featured = array();
if ( function_exists( 'wc_get_products' ) ) {
	$featured = wc_get_products( array( 'status' => 'publish', 'limit' => 8, 'tag' => array( 'listo-para-enviar' ), 'orderby' => 'menu_order', 'order' => 'ASC' ) );
	if ( count( $featured ) < 4 ) {
		$featured = wc_get_products( array( 'status' => 'publish', 'limit' => 8 ) );
	}
}
$total = function_exists( 'wc_get_products' ) ? count( wc_get_products( array( 'status' => 'publish', 'limit' => -1, 'return' => 'ids' ) ) ) : 0;
?>

<section class="hero on-dark" aria-labelledby="hero-title">
	<div class="wrap">
		<div class="hero-copy">
			<p class="eyebrow">Taller de José Mendoza · Teotitlán del Valle</p>
			<h1 class="h-xl" id="hero-title">Tapetes zapotecos, tejidos <em>hilo por hilo.</em></h1>
			<p class="lede"><span class="lede-long">Lana teñida con cochinilla, añil y pericón, tejida a mano en telar de pedal. Piezas únicas listas para enviar y encargos hechos a la medida de tu espacio.</span><span class="lede-short">Tejidos a mano en telar de pedal, con tintes naturales.</span></p>
			<div class="hero-actions">
				<a class="btn btn--pericon" href="<?php echo esc_url( nia_term_url( 'tapetes', $shop ) ); ?>">Ver tapetes <span class="arrow">→</span></a>
				<a class="btn btn--light" href="#a-medida"><span class="lbl-long">Encarga una pieza a medida</span><span class="lbl-short">Encarga a medida</span></a>
			</div>
			<div class="hero-meta">
				<div><strong>Telar de pedal</strong>Tejido a mano, sin máquinas</div>
				<div><strong>Tintes naturales</strong>Cochinilla, añil y pericón</div>
				<div><strong>4,7 × 5,6 m</strong>Formato máximo a medida</div>
			</div>
		</div>
		<div class="collage" aria-label="Fotos del taller">
			<?php foreach ( $collage as $col ) : ?>
				<div class="collage-col"><div class="collage-track"><div class="collage-set">
					<?php foreach ( $col as $p ) : ?>
						<figure class="polaroid<?php echo $p[2] ? ' tall' : ''; ?>"><img src="<?php echo esc_url( nia_img( $p[0] ) ); ?>" alt="<?php echo esc_attr( $p[1] ); ?>" width="460" height="575"><figcaption><?php echo esc_html( $p[1] ); ?></figcaption></figure>
					<?php endforeach; ?>
				</div></div></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="values" aria-label="Por qué NIA">
	<div class="wrap"><ul>
		<li><?php echo nia_icon( 'loom' ); ?><div><strong>Hecho en telar de pedal</strong><span>Cada pieza pasa por las manos del taller.</span></div></li>
		<li><?php echo nia_icon( 'drop' ); ?><div><strong>Tintes naturales</strong><span>Colores de cochinilla, añil y pericón.</span></div></li>
		<li><?php echo nia_icon( 'diamond' ); ?><div><strong>Piezas únicas</strong><span>Ningún tapete sale igual a otro.</span></div></li>
		<li><?php echo nia_icon( 'truck' ); ?><div><strong>Envío asegurado</strong><span>A todo México. Internacional bajo cotización.</span></div></li>
	</ul></div>
</section>

<section class="section wrap" aria-labelledby="cats-title">
	<div class="section-head">
		<div><p class="eyebrow">La tienda</p><h2 class="h-l" id="cats-title">Compra por tipo de pieza</h2></div>
		<a class="link" href="<?php echo esc_url( $shop ); ?>">Ver todo el catálogo <span class="arrow">→</span></a>
	</div>
	<div class="cats">
		<?php foreach ( $cats as $i => $c ) : $n = nia_term_count( $c[0] ); ?>
			<a class="cat<?php echo 0 === $i ? ' cat--big' : ''; ?>" href="<?php echo esc_url( nia_term_url( $c[0], $shop ) ); ?>">
				<img src="<?php echo esc_url( nia_img( $c[2] ) ); ?>" alt="" loading="lazy" width="460" height="575">
				<span class="cat-label"><strong><?php echo esc_html( $c[1] ); ?></strong><span><?php echo $n ? esc_html( nia_pieces( $n ) ) . ' →' : 'Ver piezas →'; ?></span></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<section class="section wrap" style="padding-top:0" aria-labelledby="new-title">
	<div class="section-head">
		<div><p class="eyebrow">Recién salidos del telar</p><h2 class="h-l" id="new-title">Piezas disponibles</h2></div>
		<a class="link" href="<?php echo esc_url( $shop ); ?>"><?php echo $total ? 'Ver las ' . (int) $total . ' piezas' : 'Ver la tienda'; ?> <span class="arrow">→</span></a>
	</div>
	<div class="grid">
		<?php
		if ( $featured ) {
			foreach ( $featured as $product ) {
				$GLOBALS['product'] = $product; // phpcs:ignore
				get_template_part( 'template-parts/product-card', null, array( 'product' => $product ) );
			}
			wp_reset_postdata();
		} else {
			echo '<p class="lede">Aún no hay productos. Activa la demostración en Apariencia › Demo NIA o agrega productos en WooCommerce.</p>';
		}
		?>
	</div>
</section>

<section class="story on-dark section" id="historia" aria-labelledby="story-title">
	<div class="wrap">
		<div>
			<p class="eyebrow" style="color:#f6d79b">El taller</p>
			<h2 class="h-l" id="story-title">Un tapete tarda semanas en el telar. <em>Por eso ninguno se repite.</em></h2>
			<p class="lede">NIA es el taller de arte textil zapoteco de José Mendoza en Teotitlán del Valle, Oaxaca. Aquí se tiñe la lana con tintes naturales y se teje a mano en telar de pedal, con diseños que van de la greca tradicional a la composición contemporánea.</p>
			<p class="sig">José Mendoza<span>Maestro tejedor · Teotitlán del Valle</span></p>
		</div>
		<div class="story-figs">
			<figure><img src="<?php echo esc_url( nia_img( 'proceso-telar-canillas-hilo.jpg' ) ); ?>" alt="Canillas de hilo en el telar de madera" loading="lazy" width="460" height="575"><figcaption>La trama, pasada a pasada.</figcaption></figure>
			<figure><img src="<?php echo esc_url( nia_img( 'tapete-gran-formato-terracota-taller.jpg' ) ); ?>" alt="Tapete terracota de gran formato en el taller" loading="lazy" width="460" height="575"><figcaption>El taller, con piezas colgadas al fondo.</figcaption></figure>
		</div>
		<div class="facts">
			<div><strong>100% a mano</strong><span>Tejido en telar de pedal de madera.</span></div>
			<div><strong>3 tintes base</strong><span>Cochinilla, añil y pericón en la paleta del taller.</span></div>
			<div><strong>Hasta 4,7 × 5,6 m</strong><span>Proyectos monumentales, sujetos a evaluación.</span></div>
		</div>
	</div>
</section>

<section class="section wrap" id="guia-de-medidas" aria-labelledby="size-title">
	<div class="section-head">
		<div><p class="eyebrow">Guía de medidas</p><h2 class="h-l" id="size-title">Compra por medida</h2><p class="lede">Las figuras están dibujadas a la misma escala para que compares el tamaño real de cada formato.</p></div>
	</div>
	<div class="sizes">
		<?php foreach ( $sizes as $s ) : $w = $s[4] * 0.3; $h = $s[5] * 0.3; $n = nia_term_count( $s[0] ); ?>
			<a class="size-card" href="<?php echo esc_url( nia_term_url( $s[0], $shop ) ); ?>">
				<div class="size-draw"><svg width="<?php echo esc_attr( $w ); ?>" height="<?php echo esc_attr( $h ); ?>" viewBox="0 0 <?php echo esc_attr( $w . ' ' . $h ); ?>" aria-hidden="true">
					<?php if ( $s[6] ) : ?><ellipse cx="<?php echo esc_attr( $w / 2 ); ?>" cy="<?php echo esc_attr( $h / 2 ); ?>" rx="<?php echo esc_attr( $w / 2 ); ?>" ry="<?php echo esc_attr( $h / 2 ); ?>"/>
					<?php else : ?><rect x=".5" y=".5" width="<?php echo esc_attr( $w - 1 ); ?>" height="<?php echo esc_attr( $h - 1 ); ?>"/><?php endif; ?>
				</svg></div>
				<strong><?php echo esc_html( $s[1] ); ?></strong><span><?php echo esc_html( $s[2] ); ?></span><span><?php echo esc_html( $s[3] ); ?></span>
				<em><?php echo $n ? esc_html( nia_pieces( $n ) ) : 'Ver piezas'; ?> →</em>
			</a>
		<?php endforeach; ?>
	</div>
	<p class="size-note"><?php echo nia_icon( 'diamond', 'icon' ); ?>¿No encuentras tu medida? Cualquier diseño puede tejerse a medida. <a class="link" href="#a-medida">Cotizar</a></p>
</section>

<section class="section wrap" style="padding-top:0" aria-labelledby="styles-title">
	<div class="section-head"><div><p class="eyebrow">Colecciones</p><h2 class="h-l" id="styles-title">Cuatro lenguajes, un mismo telar</h2></div></div>
	<div class="styles">
		<?php foreach ( $styles as $s ) : ?>
			<a class="style-card" href="<?php echo esc_url( nia_term_url( $s[0], $shop ) ); ?>"><div class="ph"><img src="<?php echo esc_url( nia_img( $s[3] ) ); ?>" alt="" loading="lazy" width="460" height="575"></div><strong><?php echo esc_html( $s[1] ); ?></strong><p><?php echo esc_html( $s[2] ); ?></p></a>
		<?php endforeach; ?>
	</div>
</section>

<section class="process section" id="proceso" aria-labelledby="process-title">
	<div class="wrap">
		<div class="section-head">
			<div><p class="eyebrow">Proceso</p><h2 class="h-l" id="process-title">Del hilo al tapete</h2></div>
			<p class="lede" style="max-width:40ch">Así se hace cada pieza que ves en la tienda.</p>
		</div>
		<ol class="steps4">
			<?php foreach ( $steps as $i => $s ) : ?>
				<li class="step"><img src="<?php echo esc_url( nia_img( $s[0] ) ); ?>" alt="<?php echo esc_attr( $s[1] ); ?>" loading="lazy" width="460" height="460"><b>0<?php echo (int) $i + 1; ?></b><strong><?php echo esc_html( $s[1] ); ?></strong><p><?php echo esc_html( $s[2] ); ?></p></li>
			<?php endforeach; ?>
		</ol>
		<div class="dyes" aria-label="Tintes naturales">
			<span><i style="background:#8d353d"></i>Cochinilla · rojos y rosas</span>
			<span><i style="background:#27425d"></i>Añil · azules</span>
			<span><i style="background:#d3a34e"></i>Pericón · amarillos</span>
			<span><i style="background:#efe6d6;border:1px solid #cbbfa9"></i>Lana cruda · sin teñir</span>
		</div>
	</div>
</section>

<section class="custom section on-dark" id="a-medida" aria-labelledby="custom-title">
	<div class="wrap">
		<figure class="custom-media" style="margin:0"><img src="<?php echo esc_url( nia_img( 'tapete-470x200-verde-olivo-rayas.jpg' ) ); ?>" alt="Tapete verde olivo de gran formato extendido en el taller" loading="lazy" width="460" height="575"><figcaption>Rayas verde olivo, 2 × 4,7 m, tejido sobre pedido.</figcaption></figure>
		<div>
			<p class="eyebrow">A medida</p>
			<h2 class="h-l" id="custom-title">Una pieza pensada para tu espacio</h2>
			<p class="lede">Para casas, hoteles, restaurantes y despachos de interiorismo. Partimos de tu medida, tu paleta o un diseño del catálogo, y lo tejemos para ti.</p>
			<ol class="custom-steps">
				<li><b>01</b><div><strong>Cuéntanos tu idea</strong><span>Medidas, uso del espacio y referencias.</span></div></li>
				<li><b>02</b><div><strong>Diseño y muestra de color</strong><span>Definimos fibras, tintes y composición.</span></div></li>
				<li><b>03</b><div><strong>Cotización y anticipo</strong><span>Precio y tiempo de tejido por escrito.</span></div></li>
				<li><b>04</b><div><strong>Tejido y envío</strong><span>Te mandamos avances desde el telar.</span></div></li>
			</ol>
			<?php if ( $wa_q ) : ?>
				<a class="btn btn--pericon" href="<?php echo esc_url( $wa_q ); ?>" target="_blank" rel="noopener">Solicitar cotización <span class="arrow">→</span></a>
			<?php else : ?>
				<a class="btn btn--pericon" href="<?php echo esc_url( $email ? 'mailto:' . $email . '?subject=' . rawurlencode( 'Encargo a medida' ) : '#' ); ?>" data-demo="Agrega el WhatsApp en Apariencia › Personalizar › Datos de NIA">Solicitar cotización <span class="arrow">→</span></a>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="visit on-dark" id="taller" aria-labelledby="visit-title">
	<div class="wrap">
		<div class="visit-figs">
			<figure class="polaroid"><img src="<?php echo esc_url( nia_img( 'tapete-gran-formato-terracota-taller.jpg' ) ); ?>" alt="Interior del taller con tapetes colgados" loading="lazy" width="460" height="575"><figcaption>El taller, en Teotitlán del Valle.</figcaption></figure>
			<figure class="polaroid"><img src="<?php echo esc_url( nia_img( 'tapete-ovalado-azul-crudo-taller.jpg' ) ); ?>" alt="Tapete ovalado azul y crudo en el taller" loading="lazy" width="460" height="575"><figcaption>Piezas listas para elegir en persona.</figcaption></figure>
		</div>
		<div>
			<p class="eyebrow">Visita el taller</p>
			<h2 class="h-l" id="visit-title">Ven a Teotitlán y ve el telar en persona</h2>
			<p class="lede">Conoce el proceso, toca la lana y elige tu pieza en el taller. Agenda tu visita por WhatsApp.</p>
			<dl>
				<dt>Dónde</dt><dd><?php echo esc_html( get_theme_mod( 'nia_address', 'Teotitlán del Valle, Oaxaca, México' ) ); ?></dd>
				<dt>Visitas</dt><dd><?php echo esc_html( get_theme_mod( 'nia_hours', 'Con cita previa' ) ); ?></dd>
				<?php if ( $email ) : ?><dt>Correo</dt><dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></dd><?php endif; ?>
			</dl>
			<div class="visit-links">
				<?php if ( $wa_v ) : ?><a class="link" href="<?php echo esc_url( $wa_v ); ?>" target="_blank" rel="noopener">Agendar por WhatsApp <span class="arrow">→</span></a><?php endif; ?>
				<?php $maps = get_theme_mod( 'nia_maps', '' ); if ( $maps ) : ?><a class="link" href="<?php echo esc_url( $maps ); ?>" target="_blank" rel="noopener">Cómo llegar</a><?php endif; ?>
				<?php if ( $ig ) : ?><a class="link" href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener">Ver el taller en Instagram</a><?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
