<?php
/**
 * Stikka Core: ajustes editables desde Ajustes → Stikka.
 *
 * - Banner de fecha límite: se muestra arriba del sitio hasta la fecha indicada
 *   (hora de Bogotá) y se oculta solo al vencer.
 * - Botón flotante de WhatsApp: se oculta si no hay número.
 */

defined( 'ABSPATH' ) || exit;

const STIKKA_OPCION = 'stikka_ajustes';

function stikka_ajustes() {
	return wp_parse_args(
		get_option( STIKKA_OPCION, array() ),
		array(
			'banner_texto' => '',
			'banner_hasta' => '',
			'whatsapp'     => '',
			'whatsapp_msj' => '¡Hola Stikka! Quiero hacer un pedido 💌',
		)
	);
}

/* ---------- Página de ajustes ---------- */

add_action( 'admin_menu', function () {
	add_options_page( 'Stikka', 'Stikka', 'manage_options', 'stikka', 'stikka_pagina_ajustes' );
} );

add_action( 'admin_init', function () {
	register_setting( 'stikka', STIKKA_OPCION, array(
		'type'              => 'array',
		'sanitize_callback' => function ( $v ) {
			return array(
				'banner_texto' => sanitize_text_field( $v['banner_texto'] ?? '' ),
				'banner_hasta' => preg_match( '/^\d{4}-\d{2}-\d{2}$/', $v['banner_hasta'] ?? '' ) ? $v['banner_hasta'] : '',
				'whatsapp'     => preg_replace( '/\D/', '', $v['whatsapp'] ?? '' ),
				'whatsapp_msj' => sanitize_text_field( $v['whatsapp_msj'] ?? '' ),
			);
		},
	) );
} );

function stikka_pagina_ajustes() {
	$a = stikka_ajustes();
	?>
	<div class="wrap">
		<h1>Stikka</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'stikka' ); ?>
			<h2>Banner de fecha límite</h2>
			<table class="form-table">
				<tr>
					<th><label for="stikka-bt">Texto</label></th>
					<td><input id="stikka-bt" class="large-text" name="<?php echo STIKKA_OPCION; ?>[banner_texto]" value="<?php echo esc_attr( $a['banner_texto'] ); ?>" placeholder="Pide antes del 15 de diciembre y llega antes de Navidad 🎄"></td>
				</tr>
				<tr>
					<th><label for="stikka-bh">Mostrar hasta</label></th>
					<td><input id="stikka-bh" type="date" name="<?php echo STIKKA_OPCION; ?>[banner_hasta]" value="<?php echo esc_attr( $a['banner_hasta'] ); ?>">
					<p class="description">Incluye ese día completo (hora de Bogotá). Vacío = no se muestra.</p></td>
				</tr>
			</table>
			<h2>WhatsApp</h2>
			<table class="form-table">
				<tr>
					<th><label for="stikka-wa">Número</label></th>
					<td><input id="stikka-wa" name="<?php echo STIKKA_OPCION; ?>[whatsapp]" value="<?php echo esc_attr( $a['whatsapp'] ); ?>" placeholder="573001234567">
					<p class="description">Con indicativo 57 y sin espacios. Vacío = se oculta el botón.</p></td>
				</tr>
				<tr>
					<th><label for="stikka-wm">Mensaje inicial</label></th>
					<td><input id="stikka-wm" class="large-text" name="<?php echo STIKKA_OPCION; ?>[whatsapp_msj]" value="<?php echo esc_attr( $a['whatsapp_msj'] ); ?>"></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/* ---------- Banner ---------- */

function stikka_banner_vigente( $a ) {
	if ( '' === $a['banner_texto'] || '' === $a['banner_hasta'] ) {
		return false;
	}
	$hoy = wp_date( 'Y-m-d' ); // Usa la zona horaria del sitio (America/Bogota).
	return $hoy <= $a['banner_hasta'];
}

add_action( 'wp_body_open', function () {
	$a = stikka_ajustes();
	if ( ! stikka_banner_vigente( $a ) ) {
		return;
	}
	printf( '<div class="stikka-banner" role="note">%s</div>', esc_html( $a['banner_texto'] ) );
}, 5 );

/* ---------- WhatsApp ---------- */

add_action( 'wp_footer', function () {
	$a = stikka_ajustes();
	if ( '' === $a['whatsapp'] ) {
		return;
	}
	$url = 'https://wa.me/' . $a['whatsapp'] . '?text=' . rawurlencode( $a['whatsapp_msj'] );
	?>
	<a class="stikka-whatsapp" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="Escríbenos por WhatsApp">
		<svg viewBox="0 0 32 32" width="28" height="28" aria-hidden="true"><path fill="currentColor" d="M16 3C9 3 3.3 8.6 3.3 15.6c0 2.2.6 4.4 1.7 6.3L3 29l7.3-1.9c1.8 1 3.8 1.5 5.8 1.5 7 0 12.7-5.7 12.7-12.7S23 3 16 3zm0 23.3c-1.9 0-3.7-.5-5.3-1.4l-.4-.2-4.3 1.1 1.2-4.2-.3-.4a10.5 10.5 0 1 1 9.1 5.1zm5.8-7.9c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-1 1.2-.2.2-.4.2-.7.1a8.6 8.6 0 0 1-4.3-3.7c-.3-.6.3-.5 1-1.7.1-.2 0-.4 0-.6l-1-2.4c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.4 1.4 3.6c.2.2 2.4 3.7 5.9 5.2 2.2.9 3 1 4.1.8.7-.1 1.9-.8 2.2-1.5.3-.8.3-1.4.2-1.5-.1-.2-.3-.3-.6-.4z"/></svg>
	</a>
	<?php
} );

/* ---------- Estilos de ambos ---------- */

add_action( 'wp_head', function () {
	?>
	<style id="stikka-core">
		.stikka-banner{background:var(--stikka-turquesa-suave,#e3f4f1);color:var(--stikka-turquesa-texto,#1e6f66);text-align:center;font-weight:700;padding:.6rem 1rem;font-size:.95rem}
		.stikka-whatsapp{position:fixed;right:16px;bottom:16px;z-index:9999;width:56px;height:56px;border-radius:50%;background:#25d366;color:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(0,0,0,.18);transition:transform .15s}
		.stikka-whatsapp:hover{transform:scale(1.06);color:#fff}
		@media (prefers-reduced-motion:reduce){.stikka-whatsapp{transition:none}}
	</style>
	<?php
} );
