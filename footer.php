<?php
/**
 * Pie de página
 */
$wa = nia_whatsapp_url();
$ig = get_theme_mod( 'nia_instagram', 'https://www.instagram.com/josemendozatextiles/' );
$fb = get_theme_mod( 'nia_facebook', '' );
?>
</main>

<footer class="footer on-dark">
	<div class="wrap footer-top">
		<div>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( nia_img( 'nia-logo.png' ) ); ?>" alt="" width="44" height="44"><span><b>Nia Design</b><small>Textiles José Mendoza</small></span></a>
			<p>Taller de arte textil zapoteco. Tapetes y tapices de lana, yute y algodón tejidos a mano en telar de pedal.</p>
			<p style="margin-top:12px"><?php echo esc_html( get_theme_mod( 'nia_address', 'Prolongación de Buenavista 54, Teotitlán del Valle, Oaxaca, 70420' ) ); ?></p>
			<?php $mail = get_theme_mod( 'nia_email', '' ); if ( $mail ) : ?><p style="margin-top:6px"><a href="mailto:<?php echo esc_attr( $mail ); ?>"><?php echo esc_html( $mail ); ?></a></p><?php endif; ?>
			<?php if ( $ig ) : ?><p style="margin-top:6px"><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener">@josemendozatextiles · +12 mil seguidores</a></p><?php endif; ?>
			<div class="social">
				<?php if ( $ig ) : ?><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo nia_icon( 'ig' ); ?></a><?php endif; ?>
				<?php if ( $fb ) : ?><a href="<?php echo esc_url( $fb ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo nia_icon( 'fb' ); ?></a><?php endif; ?>
				<?php if ( $wa ) : ?><a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?php echo nia_icon( 'wa' ); ?></a><?php endif; ?>
			</div>
		</div>
		<div><h3>Tienda</h3><ul>
			<li><a href="<?php echo esc_url( nia_term_url( 'listo-para-enviar' ) ); ?>">En stock</a></li>
			<li><a href="<?php echo esc_url( nia_term_url( 'pasilleros' ) ); ?>">Pasilleros y corredores</a></li>
			<li><a href="<?php echo esc_url( nia_term_url( 'circulares' ) ); ?>">Circulares</a></li>
			<li><a href="<?php echo esc_url( nia_term_url( 'gran-formato' ) ); ?>">Gran formato</a></li>
			<li><a href="<?php echo esc_url( nia_term_url( 'tapices' ) ); ?>">Tapices</a></li>
			<li><a href="<?php echo esc_url( nia_term_url( 'ofertas' ) ); ?>">Ofertas</a></li>
		</ul></div>
		<div><h3>Taller</h3><ul>
			<li><a href="<?php echo esc_url( home_url( '/#a-medida' ) ); ?>">A medida</a></li>
			<li><a href="<?php echo esc_url( home_url( '/#proyectos' ) ); ?>">Proyectos</a></li>
			<li><a href="<?php echo esc_url( home_url( '/#proceso' ) ); ?>">Materiales y proceso</a></li>
			<li><a href="<?php echo esc_url( home_url( '/#taller' ) ); ?>">Visita el taller</a></li>
			<li><a href="<?php echo esc_url( home_url( '/#preguntas' ) ); ?>">Preguntas frecuentes</a></li>
			<?php if ( $ig ) : ?><li><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener">Instagram</a></li><?php endif; ?>
		</ul></div>
		<div><h3>Ayuda</h3><ul>
			<?php if ( has_nav_menu( 'pie' ) ) : ?>
				<?php nia_nav_links( 'pie', 'li' ); ?>
			<?php else : ?>
				<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
					<li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Mi cuenta</a></li>
					<li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Carrito</a></li>
				<?php endif; ?>
				<?php $privacy = get_privacy_policy_url(); if ( $privacy ) : ?><li><a href="<?php echo esc_url( $privacy ); ?>">Aviso de privacidad</a></li><?php endif; ?>
			<?php endif; ?>
		</ul></div>
		<div class="news">
			<h3>Cartas del taller</h3>
			<p style="margin-top:0">Piezas nuevas recién salidas del telar, antes que en redes. Un correo al mes.</p>
			<form data-demo-form><label class="sr-only" for="news-email">Correo</label><input id="news-email" type="email" placeholder="Tu correo" autocomplete="email" required><button type="submit">Suscribirme</button></form>
		</div>
	</div>
	<div class="wrap footer-bottom">
		<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> NIA · Textiles José Mendoza · Teotitlán del Valle, Oaxaca</span>
		<span class="pay" aria-label="Formas de pago"><span>VISA</span><span>MASTERCARD</span><span>AMEX</span><span>OXXO</span><span>MERCADO PAGO</span></span>
	</div>
</footer>

<a class="wa-float" <?php echo nia_wa_attrs( nia_wa_link( 'Hola José, vi la página de Nia Design y me interesa un tapete.' ) ); ?> aria-label="Escríbenos por WhatsApp"><?php echo nia_icon( 'wa', 'icon' ); ?><span>WhatsApp</span></a>
<div class="toast" id="toast" role="status" hidden></div>
<?php wp_footer(); ?>
</body>
</html>
