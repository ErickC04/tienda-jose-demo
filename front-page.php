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
				<a class="btn btn--pericon" href="<?php echo esc_url( nia_term_url( 'tapetes', $shop ) ); ?>">Ver tapetes <span class="arrow">→</span></a>
				<a class="btn btn--light" href="#a-medida"><span class="lbl-long">Encarga una pieza a medida</span><span class="lbl-short">Encarga a medida</span></a>
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
						<figure class="polaroid<?php echo $p[2] ? ' tall' : ''; ?>"><img src="<?php echo esc_url( nia_img( $p[0] ) ); ?>" alt="<?php echo esc_attr( $p[1] ); ?>" width="460" height="575"></figure>
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
		<div class="loom" data-loom aria-label="Animación: cómo nace un tapete a medida, de la idea al envío">
			<div class="loom-frame">
				<span class="loom-beam loom-beam--top" aria-hidden="true"></span>
				<canvas class="loom-canvas" width="480" height="600" aria-hidden="true"></canvas>
				<span class="loom-beam loom-beam--bottom" aria-hidden="true"></span>
				<!-- Capas de cada etapa -->
				<div class="loom-layer loom-layer--idea" data-layer="0" aria-hidden="true">
					<span class="dim dim--w">2.0 m</span><span class="dim dim--h">3.0 m</span>
					<span class="loom-note">Sala · 4 × 5 m · luz de tarde</span>
				</div>
				<div class="loom-layer loom-layer--color" data-layer="1" aria-hidden="true">
					<span class="chip" style="--c:#ffcc29">Pericón</span>
					<span class="chip" style="--c:#1d1b19">Carbón</span>
					<span class="chip" style="--c:#f4efe6">Lana cruda</span>
				</div>
				<div class="loom-layer loom-layer--quote" data-layer="2" aria-hidden="true">
					<div class="quote-card"><b>Cotización</b><span>Tapete de lana · 200 × 300 cm</span><span>Entrega estimada: 6 semanas</span><span class="quote-ok">Anticipo recibido ✓</span></div>
				</div>
				<div class="loom-layer loom-layer--weave" data-layer="3" aria-hidden="true">
					<span class="loom-note loom-note--live"><i></i>Foto de avance · <b data-loom-pct>0</b>%</span>
				</div>
				<div class="loom-layer loom-layer--ship" data-layer="4" aria-hidden="true">
					<span class="loom-note">Listo · Teotitlán del Valle → tu ciudad</span>
				</div>
			</div>
		</div>
		<div>
			<p class="eyebrow">A medida</p>
			<h2 class="h-l" id="custom-title">Diseñamos el tapete de tu espacio</h2>
			<p class="lede">Mándanos medidas, fotos del lugar y referencias. José propone diseño y paleta, te enviamos muestra de color y avances desde el telar.</p>
			<ol class="custom-steps loom-steps">
				<li data-step="0"><button type="button"><b>01</b><div><strong>Cuéntanos tu idea</strong><span>Medidas, fotos del espacio y referencias.</span></div></button><i class="step-bar"></i></li>
				<li data-step="1"><button type="button"><b>02</b><div><strong>Diseño y muestra de color</strong><span>Definimos fibra, tintes y composición.</span></div></button><i class="step-bar"></i></li>
				<li data-step="2"><button type="button"><b>03</b><div><strong>Cotización y anticipo</strong><span>Precio y fecha de entrega por escrito.</span></div></button><i class="step-bar"></i></li>
				<li data-step="3"><button type="button"><b>04</b><div><strong>Tejido con fotos de avance</strong><span>De 4 a 8 semanas según la medida.</span></div></button><i class="step-bar"></i></li>
				<li data-step="4"><button type="button"><b>05</b><div><strong>Envío</strong><span>A todo México y al extranjero.</span></div></button><i class="step-bar"></i></li>
			</ol>
			<a class="btn btn--pericon" <?php echo nia_wa_attrs( $wa_q ); ?>><?php echo nia_icon( 'wa', 'icon' ); ?>Cotizar mi diseño por WhatsApp</a>
		</div>
	</div>
</section>

<section class="projects section" id="proyectos" aria-labelledby="projects-title">
	<div class="wrap projects-top">
		<div>
			<p class="eyebrow">Arquitectos, interioristas y hoteles</p>
			<h2 class="h-l" id="projects-title">Tapetes para <em>proyectos</em></h2>
		</div>
		<div class="projects-intro">
			<p class="lede">Piezas de gran formato, series para hoteles y diseños a partir de tus planos o tu paleta. Trabajamos con despachos de arquitectura e interiorismo.</p>
			<a class="btn" <?php echo nia_wa_attrs( $wa_p ); ?>>Cotizar un proyecto <span class="arrow">→</span></a>
		</div>
	</div>
	<?php
	$obras = array(
		array( 'tapete-organico-ambientado-sala.jpg', 'Ya en casa', 'Lana · formas orgánicas' ),
		array( 'tapete-ajedrez-mostaza-240x450.jpg', 'Tablero mostaza', '2.4 × 4.5 m' ),
		array( 'tapete-300x500-diamantes-neutros.jpg', 'Rombos neutros', '3 × 5 m' ),
		array( 'tapete-470x200-verde-olivo-rayas.jpg', 'Rayas verde olivo', '2 × 4.7 m' ),
		array( 'tapete-gran-formato-terracota-taller.jpg', 'Terracota', 'Gran formato' ),
		array( 'tapete-ovalado-azul-crudo-taller.jpg', 'Óvalo añil', '150 × 220 cm' ),
	);
	?>
	<div class="obras" aria-label="Obras del taller">
		<div class="obras-track"><div class="obras-set">
			<?php foreach ( $obras as $o ) : ?>
				<figure class="obra"><img src="<?php echo esc_url( nia_img( $o[0] ) ); ?>" alt="<?php echo esc_attr( $o[1] . ', ' . $o[2] ); ?>" loading="lazy" width="460" height="575"><figcaption><b><?php echo esc_html( $o[1] ); ?></b><span><?php echo esc_html( $o[2] ); ?></span></figcaption></figure>
			<?php endforeach; ?>
		</div></div>
	</div>
	<div class="wrap">
		<?php echo nia_ornament(); // phpcs:ignore ?>
		<ul class="features">
			<li><b>01</b><strong>Muestras de color</strong><span>Antes de tejer, recibes la paleta en lana para aprobarla con tu cliente.</span></li>
			<li><b>02</b><strong>Series y volumen</strong><span>Varias piezas iguales o una familia de diseños para todo un hotel.</span></li>
			<li><b>03</b><strong>Hasta 4.7 × 5.6 m</strong><span>Gran formato en una sola pieza, sin uniones.</span></li>
			<li><b>04</b><strong>A partir de tus planos</strong><span>Medidas, paleta y diseño desde tu proyecto. Factura por confirmar.</span></li>
		</ul>
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
			<div class="material"><span class="weave weave--lana" aria-hidden="true"></span><strong>Lana</strong><p>Cálida, suave y muy durable. La fibra principal del taller.</p><em>Salas · recámaras · tapices</em></div>
			<div class="material"><span class="weave weave--yute" aria-hidden="true"></span><strong>Yute</strong><p>Textura natural y resistente, ideal para zonas de paso.</p><em>Pasillos · terrazas · entradas</em></div>
			<div class="material"><span class="weave weave--algodon" aria-hidden="true"></span><strong>Algodón</strong><p>Ligero y fácil de lavar, para piezas de uso diario.</p><em>Cocinas · baños · cuartos de niños</em></div>
		</div>
		<div class="dyes" aria-label="Tintes naturales">
			<span><i style="background:#8d353d"></i>Cochinilla · rojos y rosas</span>
			<span><i style="background:#27425d"></i>Añil índigo · azules</span>
			<span><i style="background:#d3a34e"></i>Pericón · amarillos</span>
			<span><i style="background:#efe6d6;border:1px solid #cbbfa9"></i>Fibra natural · sin teñir</span>
		</div>
		<?php echo nia_ornament( 'ornament--space' ); // phpcs:ignore ?>
		<div class="section-head">
			<div><p class="eyebrow">Proceso</p><h2 class="h-l">Del hilo al tapete</h2></div>
			<p class="lede" style="max-width:38ch">Fibra natural, un telar de pedal y semanas de trabajo en cada pieza.</p>
		</div>
		<ol class="steps4 steps-thread">
			<?php foreach ( $steps as $i => $s ) : ?>
				<li class="step">
					<span class="step-knot" aria-hidden="true"><b>0<?php echo (int) $i + 1; ?></b></span>
					<div class="step-img"><img src="<?php echo esc_url( nia_img( $s[0] ) ); ?>" alt="<?php echo esc_attr( $s[1] ); ?>" loading="lazy" width="460" height="460"></div>
					<strong><?php echo esc_html( $s[1] ); ?></strong>
					<p><?php echo esc_html( $s[2] ); ?></p>
				</li>
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
</section>

<section class="faq-band" id="preguntas" aria-labelledby="faq-title">
	<div class="wrap section faq-grid">
		<div class="faq-side">
			<p class="eyebrow">Preguntas frecuentes</p>
			<h2 class="h-l" id="faq-title">Antes de <em>escribirnos</em></h2>
			<p class="lede">Lo que más nos preguntan sobre materiales, tiempos y envíos.</p>
			<div class="faq-card">
				<strong>¿Tienes otra duda?</strong>
				<span>Te respondemos directo desde el taller.</span>
				<a class="btn btn--pericon" <?php echo nia_wa_attrs( nia_wa_link( 'Hola José, tengo una pregunta sobre los tapetes:' ) ); ?>><?php echo nia_icon( 'wa', 'icon' ); ?>Pregúntanos por WhatsApp</a>
			</div>
		</div>
		<div class="faq-list" data-faq>
			<?php foreach ( $faq as $i => $q ) : ?>
				<div class="faq-item<?php echo 0 === $i ? ' is-open' : ''; ?>">
					<button type="button" class="faq-q" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="faq-a-<?php echo (int) $i; ?>">
						<span class="faq-n"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<span class="faq-t"><?php echo esc_html( $q[0] ); ?></span>
						<span class="faq-ico" aria-hidden="true"><svg viewBox="0 0 16 16"><path d="M7 1h2v2h2v2h2v2h2v2h-2v2h-2v2H9v2H7v-2H5v-2H3V9H1V7h2V5h2V3h2z"/></svg></span>
					</button>
					<div class="faq-a" id="faq-a-<?php echo (int) $i; ?>" role="region"><div><p><?php echo esc_html( $q[1] ); ?></p></div></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
