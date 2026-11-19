<?php
/**
 * NIA · Personalizar › Datos de NIA
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'nia_datos', array(
		'title'    => 'Datos de NIA',
		'priority' => 30,
	) );
	$fields = array(
		'nia_whatsapp'  => array( 'WhatsApp (con lada de país)', '', 'Ejemplo: 529511234567. Activa los botones de WhatsApp.' ),
		'nia_email'     => array( 'Correo de contacto', '', '' ),
		'nia_instagram' => array( 'Instagram', 'https://www.instagram.com/josemendozatextiles/', '' ),
		'nia_facebook'  => array( 'Facebook', '', '' ),
		'nia_address'   => array( 'Dirección del taller', 'Prolongación de Buenavista 54, Teotitlán del Valle, Oaxaca, 70420', '' ),
		'nia_hours'     => array( 'Horario de visitas', 'Con cita previa', '' ),
		'nia_maps'      => array( 'Enlace a Google Maps', '', '' ),
		'nia_announce'  => array( 'Avisos superiores (separados por |)', 'Tejido a mano en Teotitlán del Valle|Envíos a todo México y al extranjero|Diseños a medida por WhatsApp', '' ),
	);
	foreach ( $fields as $id => $f ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $f[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label'       => $f[0],
			'description' => $f[2],
			'section'     => 'nia_datos',
			'type'        => 'text',
		) );
	}
} );
