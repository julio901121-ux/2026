<?php
/**
 * Tema hijo de Stikka.
 *
 * La lógica de negocio (banner, WhatsApp, personalización, envíos) vive en el
 * mu-plugin stikka-core para que no dependa del tema.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'stikka-fuentes',
		'https://fonts.googleapis.com/css2?family=Bodoni+Moda:opsz,wght@6..96,500;6..96,600;6..96,700&family=Nunito:wght@400;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'stikka-child',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}, 20 );

add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );
