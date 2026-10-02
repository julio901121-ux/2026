<?php
/**
 * Envíos en Bogotá por localidad.
 *
 * WooCommerce no sabe en qué localidad queda una dirección, así que en el checkout se pide
 * la localidad cuando el departamento es Bogotá y solo se muestra la tarifa que corresponde:
 *   - Usaquén y Chapinero → "Domicilio Bogotá norte" (opción rabisco_envio_norte)
 *   - Las demás           → "Domicilio resto de Bogotá" (opción rabisco_envio_resto)
 * Recoger siempre está disponible. Las zonas y tarifas se crean en scripts/envios.sh.
 */

defined( 'ABSPATH' ) || exit;

const RABISCO_LOCALIDADES_NORTE = array( 'Usaquén', 'Chapinero' );

function rabisco_localidades() {
	return array(
		'Usaquén', 'Chapinero', 'Santa Fe', 'San Cristóbal', 'Usme', 'Tunjuelito', 'Bosa',
		'Kennedy', 'Fontibón', 'Engativá', 'Suba', 'Barrios Unidos', 'Teusaquillo',
		'Los Mártires', 'Antonio Nariño', 'Puente Aranda', 'La Candelaria',
		'Rafael Uribe Uribe', 'Ciudad Bolívar', 'Sumapaz',
	);
}

/* "Localidad / Ciudad" (etiqueta de WooCommerce para Colombia) se confunde con la localidad de Bogotá */
add_filter( 'woocommerce_get_country_locale', function ( $locale ) {
	$locale['CO']['city']['label'] = 'Ciudad o municipio';
	return $locale;
} );

/* Textos sin traducir en el resumen del pedido */
add_filter( 'gettext', function ( $t, $original, $dominio ) {
	return ( 'woocommerce' === $dominio && 'Shipment' === $original ) ? 'Envío' : $t;
}, 10, 3 );
add_filter( 'ngettext', function ( $t, $singular, $plural, $n, $dominio ) {
	return ( 'woocommerce' === $dominio && 'Shipment' === $singular ) ? 'Envío' : $t;
}, 10, 5 );
add_filter( 'gettext_with_context', function ( $t, $original, $contexto, $dominio ) {
	return ( 'woocommerce' === $dominio && 'Shipment' === $original ) ? 'Envío' : $t;
}, 10, 4 );

/* Campo en el checkout */
add_filter( 'woocommerce_checkout_fields', function ( $campos ) {
	$opciones = array( '' => 'Elige tu localidad…' );
	foreach ( rabisco_localidades() as $l ) {
		$opciones[ $l ] = $l;
	}
	$campos['billing']['billing_localidad'] = array(
		'type'     => 'select',
		'label'    => 'Localidad en Bogotá <abbr class="required" title="obligatorio">*</abbr>',
		'options'  => $opciones,
		'required' => false, // Se exige solo para Bogotá en la validación de abajo.
		'class'    => array( 'form-row-wide', 'rabisco-localidad' ),
		'priority' => 85,
	);
	return $campos;
} );

add_action( 'woocommerce_after_checkout_validation', function ( $datos, $errores ) {
	if ( 'CO-DC' === ( $datos['billing_state'] ?? '' ) && empty( $_POST['billing_localidad'] ) ) {
		$errores->add( 'localidad', 'Elige tu <strong>localidad</strong> para calcular el domicilio en Bogotá.' );
	}
}, 10, 2 );

/* La localidad viaja con el paquete de envío (así WooCommerce recalcula al cambiarla) */
function rabisco_localidad_actual() {
	if ( isset( $_POST['billing_localidad'] ) ) { // Al confirmar el pedido.
		return sanitize_text_field( wp_unslash( $_POST['billing_localidad'] ) );
	}
	return WC()->session ? (string) WC()->session->get( 'rabisco_localidad', '' ) : '';
}

add_action( 'woocommerce_checkout_update_order_review', function ( $post_data ) {
	parse_str( $post_data, $datos );
	$nueva = sanitize_text_field( $datos['billing_localidad'] ?? '' );
	if ( '' !== $nueva && $nueva !== WC()->session->get( 'rabisco_localidad', '' ) ) {
		// Al elegir o cambiar la localidad se selecciona el domicilio de esa zona, para que no
		// quede pegado "Recoger" (que es lo único disponible antes de elegirla).
		$id = in_array( $nueva, RABISCO_LOCALIDADES_NORTE, true ) ? get_option( 'rabisco_envio_norte' ) : get_option( 'rabisco_envio_resto' );
		WC()->session->set( 'chosen_shipping_methods', array( 'flat_rate:' . $id ) );
		// WooCommerce aplica el método marcado en el formulario justo después de esta acción;
		// sin esto, el "Recoger" que venía marcado pisaría la selección.
		unset( $_POST['shipping_method'] );
	}
	WC()->session->set( 'rabisco_localidad', $nueva );
} );

add_filter( 'woocommerce_cart_shipping_packages', function ( $paquetes ) {
	foreach ( $paquetes as &$p ) {
		$p['rabisco_localidad'] = rabisco_localidad_actual();
	}
	return $paquetes;
} );

add_filter( 'woocommerce_package_rates', function ( $tarifas, $paquete ) {
	if ( 'CO-DC' !== ( $paquete['destination']['state'] ?? '' ) ) {
		return $tarifas;
	}
	$loc   = $paquete['rabisco_localidad'] ?? '';
	$norte = 'flat_rate:' . get_option( 'rabisco_envio_norte' );
	$resto = 'flat_rate:' . get_option( 'rabisco_envio_resto' );
	if ( '' === $loc ) {
		unset( $tarifas[ $norte ], $tarifas[ $resto ] ); // Hasta que elija localidad, solo "Recoger".
	} elseif ( in_array( $loc, RABISCO_LOCALIDADES_NORTE, true ) ) {
		unset( $tarifas[ $resto ] );
	} else {
		unset( $tarifas[ $norte ] );
	}
	return $tarifas;
}, 10, 2 );

/* Mostrar / ocultar el campo según el departamento y recalcular al cambiarlo */
add_action( 'wp_footer', function () {
	if ( ! is_checkout() ) {
		return;
	}
	?>
	<script>
	jQuery( function ( $ ) {
		function rabiscoLocalidad() {
			$( '#billing_localidad_field' ).toggle( $( '#billing_state' ).val() === 'CO-DC' );
		}
		$( document.body ).on( 'change', '#billing_state', rabiscoLocalidad );
		$( document.body ).on( 'change', '#billing_localidad', function () {
			$( document.body ).trigger( 'update_checkout' );
		} );
		rabiscoLocalidad();
	} );
	</script>
	<?php
} );

/* La localidad en el pedido: admin y correos */
add_action( 'woocommerce_admin_order_data_after_billing_address', function ( $order ) {
	$loc = $order->get_meta( '_billing_localidad' );
	if ( $loc ) {
		printf( '<p><strong>Localidad:</strong> %s</p>', esc_html( $loc ) );
	}
} );

add_filter( 'woocommerce_email_order_meta_fields', function ( $campos, $sent_to_admin, $order ) {
	$loc = $order->get_meta( '_billing_localidad' );
	if ( $loc ) {
		$campos['localidad'] = array( 'label' => 'Localidad', 'value' => $loc );
	}
	return $campos;
}, 10, 3 );
