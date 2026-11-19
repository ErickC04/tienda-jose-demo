<?php
/**
 * Página de inicio · Nia Design · Textiles José Mendoza
 * Orden: portada → categorías → piezas en stock → a medida → proyectos → colecciones → medidas → materiales y proceso → taller → visita → preguntas.
 */
get_header();

$shop    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$stock   = nia_term_url( 'listo-para-enviar', $shop );
$wa_q    = nia_wa_link( 'Hola José, vi la página de Nia Design y quiero cotizar un tapete a medida. Medidas aproximadas: ' );
$wa_p    = nia_wa_link( 'Hola José, quiero cotizar tapetes para un proyecto (arquitectura / interiorismo / hotel).' );
$wa_v    = nia_wa_link( 'Hola José, me gustaría agendar una visita al taller.' );
$email   = get_theme_mod( 'nia_email', '' );
$ig      = get_theme_mod( 'nia_instagram', 'https://www.instagram.com/josemendozatextiles/' );
$address = get_theme_mod( 'nia_address', 'Prolongación de Buenavista 54, Teotitlán del Valle, Oaxaca, 70420' );

$collage = array(
	1 => array(
		array( 'tapete-organico-ambientado-sala.jpg', 'Un tapete del taller, ya en casa.', false ),
		array( 'proceso-tejido-hilos-lana-colores.jpg', 'Madejas teñidas a mano, antes del telar.', false ),
		array( 'tapete-ovalado-azul-crudo-taller.jpg', 'Óvalo añil, recién bajado del telar.', false ),
	),
	2 => array(
		array( 'telar-nuevo-520cm-madera.jpg', 'El telar nuevo: 5.20 m de madera.', true ),
		array( 'tapete-contemporaneo-formas-organicas.jpg', 'Formas orgánicas en lana teñida.', false ),
		array( 'tapete-ajedrez-mostaza-240x450.jpg', 'Ajedrez mostaza, 2.4 × 4.5 m.', false ),
	),
	3 => array(
		array( 'tapete-gran-formato-terracota-taller.jpg', 'Gran formato, extendido para revisión.', false ),
		array( 'proceso-telar-canillas-hilo.jpg', 'Canillas cargadas, sobre la trama.', false ),
		array( 'tapete-minimalista-crudo-cuadros-negros.jpg', 'Cuadros carbón sobre lana cruda.', false ),
	),
);
/* Categorías como las historias destacadas de Instagram */
$cats = array(
	array( 'listo-para-enviar', 'En stock', 'tapetes-estrella-enrollados.jpg' ),
	array( 'pasilleros', 'Pasilleros y corredores', 'tapete-corredor-80x300-rombos-negro.jpg' ),
	array( 'circulares', 'Circulares', 'tapete-redondo-natural-jaspe.jpg' ),
	array( 'gran-formato', 'Gran formato', 'tapete-300x500-diamantes-neutros.jpg' ),
	array( 'tapices', 'Tapices', 'tapiz-montanas-tierra.jpg' ),
	array( 'ofertas', 'Ofertas', 'tapete-60x100-trueno-de-colores.jpg' ),
);
$sizes = array(
	array( 'pequenos', 'Pequeños', '60 × 100 cm', 'Entrada · junto a la cama', 100, 60, false ),
	array( 'medianos', '80 × 150 cm', '80 × 150 a 120 × 180', 'Recámara · estudio', 180, 120, false ),
	array( 'grandes', '2 × 3 m', '160 × 230 a 200 × 300', 'Sala · comedor', 300, 200, false ),
	array( 'gran-formato', 'Gran formato', '2.4 × 4.5 m y más', 'Salas amplias · proyectos', 500, 300, false ),
	array( 'pasilleros', 'Pasilleros', '80 × 300 cm', 'Pasillos · cocinas', 300, 80, false ),
	array( 'circulares', 'Circulares', 'Ø 150 a 150 × 220', 'Comedor · rincones', 220, 150, true ),
);
$styles = array(
	array( 'organico-abstracto', 'Contemporáneo y orgánico', 'Formas libres y bloques de color, cercanos al arte textil.', 'tapete-contemporaneo-formas-organicas.jpg' ),
	array( 'geometrico-contemporaneo', 'Geométrico', 'Retículas, franjas, tableros y ángulos.', 'tapete-80x150-geometrico-naranja-gris.jpg' ),
	array( 'minimalista-natural', 'Minimalista', 'Lana cruda, jaspes y líneas de carbón.', 'tapete-minimalista-crudo-cuadros-negros.jpg' ),
	array( 'tradicional-zapoteca', 'Grecas zapotecas', 'Grecas, rombos y estrellas de la tradición del valle.', 'tapete-tradicional-80x150-grecas-zapotecas.jpg' ),
);
$steps = array(
	array( 'proceso-tejido-hilos-lana-colores.jpg', 'Teñido', 'La fibra se tiñe con cochinilla, añil y pericón hasta lograr la paleta del diseño.' ),
	array( 'telar-nuevo-520cm-madera.jpg', 'Urdido', 'Se montan los hilos de la urdimbre en el telar de pedal, a la medida de la pieza.' ),
	array( 'proceso-telar-canillas-hilo.jpg', 'Tejido', 'Pasada a pasada, el diseño aparece a mano. Una pieza grande toma semanas.' ),
	array( 'tapetes-estrella-enrollados.jpg', 'Acabado', 'Se anudan los flecos, se revisa la pieza y se enrolla para el envío.' ),
);
$faq = array(
	array( '¿Venden hilo de lana?', 'Escríbenos por WhatsApp con el color y la cantidad que buscas y te confirmamos si lo tenemos disponible en el taller.' ),
	array( '¿Los colores se destiñen?', 'Los tintes naturales se fijan en la fibra durante el teñido. Con el cuidado adecuado (sin sol directo por horas y sin lavadora) el color se conserva por muchos años.' ),
	array( '¿Cómo se limpia un tapete de lana o de yute?', 'Aspira sin cepillo giratorio y voltea el tapete cada pocos meses. Si se derrama algo, seca de inmediato con un paño y agua fría. Para limpieza profunda, lavado profesional en seco.' ),
	array( '¿Hacen envíos a Estados Unidos y Europa?', 'Sí. Enviamos a todo México y al extranjero; el costo y el tiempo dependen del destino y del tamaño de la pieza. Te cotizamos el envío por WhatsApp.' ),
	array( '¿Puedo mandar mi propio diseño?', 'Sí. Puedes enviarnos un dibujo, una foto de referencia o la paleta de tu proyecto, y José lo adapta al telar.' ),
	array( '¿Cuánto tarda un tapete a medida y cuánto es el anticipo?', 'Entre 4 y 8 semanas según la medida y el diseño. El anticipo y la fecha de entrega se acuerdan por escrito al cotizar.' ),
);

$featured = array();
if ( function_exists( 'wc_get_products' ) ) {
	$featured = wc_get_products( array( 'status' => 'publish', 'limit' => 8, 'tag' => array( 'listo-para-enviar' ), 'orderby' => 'menu_order', 'order' => 'ASC' ) );
	if ( count( $featured ) < 4 ) {
		$featured = wc_get_products( array( 'status' => 'publish', 'limit' => 8 ) );
	}
}
?>

<section class="hero on-dark" aria-labelledby="hero-title">
	<div class="wrap">
		<div class="hero-copy">
			<p class="eyebrow">Taller de José Mendoza · Teotitlán del Valle, Oaxaca</p>
			<h1 class="h-xl" id="hero-title">Tapetes zapotecos de diseño, tejidos <em>a mano en Teotitlán del Valle.</em></h1>
			<p class="lede"><span class="lede-long">Lana, yute y algodón teñidos con tintes naturales en telar de pedal. Piezas únicas y diseños a medida para casas, hoteles y proyectos de interiorismo.</span><span class="lede-short">Lana, yute y algodón con tintes naturales, tejidos en telar de pedal.</span></p>
			<div class="hero-actions">
				<a class="btn btn--pericon" <?php echo nia_wa_attrs( $wa_q ); ?>><?php echo nia_icon( 'wa', 'icon' ); ?><span class="lbl-long">Cotizar mi diseño por WhatsApp</span><span class="lbl-short">Cotizar diseño</span></a>
				<a class="btn btn--light" href="<?php echo esc_url( $stock ); ?>">Ver piezas en stock</a>
			</div>
			<div class="hero-meta hero-meta--4">
				<div><strong>Telar de pedal</strong>Tejido a mano</div>
				<div><strong>Lana, yute y algodón</strong>Con tintes naturales</div>
				<div><strong>Hasta 4.7 × 5.6 m</strong>Diseños a medida</div>
				<div><strong>+12 mil</strong>siguen el taller en Instagram</div>
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

<section class="values" aria-label="Por qué Nia Design">
	<div class="wrap"><ul>
		<li><?php echo nia_icon( 'loom' ); ?><div><strong>Hecho en telar de pedal</strong><span>Cada pieza pasa por las manos del taller.</span></div></li>
		<li><?php echo nia_icon( 'drop' ); ?><div><strong>Tintes naturales</strong><span>Cochinilla, añil índigo y pericón.</span></div></li>
		<li><?php echo nia_icon( 'diamond' ); ?><div><strong>Piezas únicas y a medida</strong><span>Tu medida, tu paleta, tu diseño.</span></div></li>
		<li><?php echo nia_icon( 'truck' ); ?><div><strong>Envío asegurado</strong><span>A todo México y al extranjero.</span></div></li>
	</ul></div>
</section>

<section class="section wrap" aria-labelledby="cats-title">
	<div class="section-head">
		<div><p class="eyebrow">La tienda</p><h2 class="h-l" id="cats-title">Tapetes de lana hechos a mano</h2></div>
		<a class="link" href="<?php echo esc_url( $shop ); ?>">Ver todo el catálogo <span class="arrow">→</span></a>
	</div>
	<div class="cats cats--6">
		<?php foreach ( $cats as $c ) : $n = nia_term_count( $c[0] ); ?>
			<a class="cat" href="<?php echo esc_url( nia_term_url( $c[0], $shop ) ); ?>">
				<img src="<?php echo esc_url( nia_img( $c[2] ) ); ?>" alt="" loading="lazy" width="460" height="575">
				<span class="cat-label"><strong><?php echo esc_html( $c[1] ); ?></strong><span><?php echo $n ? esc_html( nia_pieces( $n ) ) . ' →' : 'Ver piezas →'; ?></span></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<section class="section wrap" style="padding-top:0" aria-labelledby="new-title">
	<div class="section-head">
		<div><p class="eyebrow">En stock · listos para enviar</p><h2 class="h-l" id="new-title">Recién salido del telar</h2></div>
		<a class="link" href="<?php echo esc_url( $stock ); ?>">Ver todas las piezas en stock <span class="arrow">→</span></a>
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

<section class="custom section" id="a-medida" aria-labelledby="custom-title">
	<div class="wrap">
		<figure class="custom-media" style="margin:0"><img src="<?php echo esc_url( nia_img( 'tapete-470x200-verde-olivo-rayas.jpg' ) ); ?>" alt="Tapete verde olivo de gran formato extendido en el taller" loading="lazy" width="460" height="575"><figcaption>Rayas verde olivo, 2 × 4.7 m, tejido sobre pedido.</figcaption></figure>
		<div>
			<p class="eyebrow">A medida</p>
			<h2 class="h-l" id="custom-title">Diseñamos el tapete de tu espacio</h2>
			<p class="lede">Mándanos medidas, fotos del lugar y referencias. José propone diseño y paleta, y te enviamos muestra de color y avances desde el telar.</p>
			<ol class="custom-steps">
				<li><b>01</b><div><strong>Cuéntanos tu idea</strong><span>Medidas, fotos del espacio y referencias.</span></div></li>
				<li><b>02</b><div><strong>Diseño y muestra de color</strong><span>Definimos fibra, tintes y composición.</span></div></li>
				<li><b>03</b><div><strong>Cotización y anticipo</strong><span>Precio y fecha de entrega por escrito.</span></div></li>
				<li><b>04</b><div><strong>Tejido con fotos de avance</strong><span>De 4 a 8 semanas según la medida.</span></div></li>
				<li><b>05</b><div><strong>Envío</strong><span>A todo México y al extranjero.</span></div></li>
			</ol>
			<a class="btn btn--pericon" <?php echo nia_wa_attrs( $wa_q ); ?>><?php echo nia_icon( 'wa', 'icon' ); ?>Cotizar mi diseño por WhatsApp</a>
		</div>
	</div>
</section>

<section class="projects section" id="proyectos" aria-labelledby="projects-title">
	<div class="wrap">
		<div class="projects-grid">
			<div>
				<p class="eyebrow">Arquitectos, interioristas y hoteles</p>
				<h2 class="h-l" id="projects-title">Tapetes para proyectos</h2>
				<p class="lede">Piezas de gran formato, series para hoteles y diseños a partir de tus planos o tu paleta. Trabajamos con despachos de arquitectura e interiorismo.</p>
				<ul class="checklist">
					<li>Muestras de color antes de tejer</li>
					<li>Producción por volumen para series</li>
					<li>Gran formato hasta 4.7 × 5.6 m</li>
					<li>Factura (por confirmar)</li>
				</ul>
				<a class="btn" <?php echo nia_wa_attrs( $wa_p ); ?>>Cotizar un proyecto <span class="arrow">→</span></a>
			</div>
			<div class="projects-gallery">
				<figure><img src="<?php echo esc_url( nia_img( 'tapete-organico-ambientado-sala.jpg' ) ); ?>" alt="Tapete de formas orgánicas en una sala" loading="lazy" width="460" height="575"><figcaption>Sala residencial</figcaption></figure>
				<figure><img src="<?php echo esc_url( nia_img( 'tapete-ajedrez-mostaza-240x450.jpg' ) ); ?>" alt="Tapete de tablero mostaza de gran formato" loading="lazy" width="460" height="575"><figcaption>Gran formato 2.4 × 4.5 m</figcaption></figure>
				<figure><img src="<?php echo esc_url( nia_img( 'tapete-300x500-diamantes-neutros.jpg' ) ); ?>" alt="Tapete de diamantes en tonos neutros de 3 × 5 m" loading="lazy" width="460" height="575"><figcaption>Pieza de 3 × 5 m</figcaption></figure>
			</div>
		</div>
	</div>
</section>

<section class="section wrap" aria-labelledby="styles-title">
	<div class="section-head"><div><p class="eyebrow">Colecciones</p><h2 class="h-l" id="styles-title">Colecciones</h2></div></div>
	<div class="styles">
		<?php foreach ( $styles as $s ) : ?>
			<a class="style-card" href="<?php echo esc_url( nia_term_url( $s[0], $shop ) ); ?>"><div class="ph"><img src="<?php echo esc_url( nia_img( $s[3] ) ); ?>" alt="" loading="lazy" width="460" height="575"></div><strong><?php echo esc_html( $s[1] ); ?></strong><p><?php echo esc_html( $s[2] ); ?></p></a>
		<?php endforeach; ?>
	</div>
</section>

<section class="section wrap" style="padding-top:0" id="guia-de-medidas" aria-labelledby="size-title">
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

<section class="process section" id="proceso" aria-labelledby="materials-title">
	<div class="wrap">
		<div class="section-head">
			<div><p class="eyebrow">Materiales y tintes</p><h2 class="h-l" id="materials-title">Lana, yute y algodón</h2></div>
			<p class="lede" style="max-width:40ch">Fibras naturales, productos ecológicos y duraderos.</p>
		</div>
		<div class="materials">
			<div><strong>Lana</strong><p>Cálida, suave y muy durable. La fibra principal del taller.</p></div>
			<div><strong>Yute</strong><p>Textura natural y resistente, ideal para zonas de paso.</p></div>
			<div><strong>Algodón</strong><p>Ligero y fácil de lavar, para piezas de uso diario.</p></div>
		</div>
		<div class="dyes" aria-label="Tintes naturales">
			<span><i style="background:#8d353d"></i>Cochinilla · rojos y rosas</span>
			<span><i style="background:#27425d"></i>Añil índigo · azules</span>
			<span><i style="background:#d3a34e"></i>Pericón · amarillos</span>
			<span><i style="background:#efe6d6;border:1px solid #cbbfa9"></i>Fibra natural · sin teñir</span>
		</div>
		<div class="section-head" style="margin-top:clamp(56px,6vw,88px)">
			<div><p class="eyebrow">Proceso</p><h2 class="h-m">Del hilo al tapete</h2></div>
		</div>
		<ol class="steps4">
			<?php foreach ( $steps as $i => $s ) : ?>
				<li class="step"><img src="<?php echo esc_url( nia_img( $s[0] ) ); ?>" alt="<?php echo esc_attr( $s[1] ); ?>" loading="lazy" width="460" height="460"><b>0<?php echo (int) $i + 1; ?></b><strong><?php echo esc_html( $s[1] ); ?></strong><p><?php echo esc_html( $s[2] ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="visit on-dark" id="taller" aria-labelledby="story-title">
	<div class="wrap">
		<div class="visit-figs">
			<figure class="polaroid"><img src="<?php echo esc_url( nia_img( 'proceso-telar-canillas-hilo.jpg' ) ); ?>" alt="Canillas de hilo en el telar de madera" loading="lazy" width="460" height="575"><figcaption>La trama, pasada a pasada.</figcaption></figure>
			<figure class="polaroid"><img src="<?php echo esc_url( nia_img( 'tapete-gran-formato-terracota-taller.jpg' ) ); ?>" alt="Interior del taller con tapetes colgados" loading="lazy" width="460" height="575"><figcaption>El taller, en Teotitlán del Valle.</figcaption></figure>
		</div>
		<div>
			<p class="eyebrow">El taller</p>
			<h2 class="h-l" id="story-title">Un tapete tarda semanas en el telar. <em>Por eso ninguno se repite.</em></h2>
			<p class="lede">Nia Design es el taller de arte textil zapoteco de José Mendoza en Teotitlán del Valle, Oaxaca. Aquí se tiñe la fibra con tintes naturales y se teje a mano en telar de pedal, con diseños que van de la greca tradicional a la composición contemporánea.</p>
			<p class="sig">José Mendoza<span>Maestro tejedor · Teotitlán del Valle</span></p>
			<dl>
				<dt>Dónde</dt><dd><?php echo esc_html( $address ); ?></dd>
				<dt>Visitas</dt><dd><?php echo esc_html( get_theme_mod( 'nia_hours', 'Con cita previa' ) ); ?></dd>
				<?php if ( $email ) : ?><dt>Correo</dt><dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></dd><?php endif; ?>
			</dl>
			<div class="visit-links">
				<a class="btn btn--pericon" <?php echo nia_wa_attrs( $wa_v ); ?>><?php echo nia_icon( 'wa', 'icon' ); ?>Agenda tu visita por WhatsApp</a>
				<?php if ( $ig ) : ?><a class="link" href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener">Ver el taller en Instagram</a><?php endif; ?>
			</div>
		</div>
	</div>
	<div class="wrap visit-map">
		<iframe title="Mapa del taller en Teotitlán del Valle" src="https://maps.google.com/maps?q=<?php echo rawurlencode( $address ); ?>&amp;z=15&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
</section>

<section class="section wrap faq" id="preguntas" aria-labelledby="faq-title">
	<div class="faq-grid">
		<div><p class="eyebrow">Preguntas frecuentes</p><h2 class="h-l" id="faq-title">Antes de escribirnos</h2><p class="lede">¿Tienes otra duda? Pregúntanos por WhatsApp.</p></div>
		<div>
			<?php foreach ( $faq as $i => $q ) : ?>
				<details class="acc"<?php echo 0 === $i ? ' open' : ''; ?>><summary><?php echo esc_html( $q[0] ); ?></summary><div><p><?php echo esc_html( $q[1] ); ?></p></div></details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
