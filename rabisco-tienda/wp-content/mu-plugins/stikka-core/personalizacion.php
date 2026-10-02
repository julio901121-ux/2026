<?php
/**
 * Campos de personalización por producto.
 *
 * Cada producto define sus campos en el meta `_rabisco_campos` (JSON):
 *   [{"clave":"nino","etiqueta":"Nombre del niño o niña","obligatorio":true,"max":25,"ayuda":"..."}]
 *
 * Los valores se piden en la página del producto, se validan al agregar al carrito,
 * se muestran en carrito/checkout y quedan guardados en cada línea del pedido.
 */

defined( 'ABSPATH' ) || exit;

function rabisco_campos( $product_id ) {
	$campos = json_decode( (string) get_post_meta( $product_id, '_rabisco_campos', true ), true );
	return is_array( $campos ) ? $campos : array();
}

function rabisco_campo_nombre( $clave ) {
	return 'rabisco_' . sanitize_key( $clave );
}

/* Formulario en la página del producto */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	global $product;
	$campos = rabisco_campos( $product->get_id() );
	if ( ! $campos ) {
		return;
	}
	echo '<div class="rabisco-campos"><p class="rabisco-campos-titulo">Personalízalo</p>';
	foreach ( $campos as $c ) {
		$nombre = rabisco_campo_nombre( $c['clave'] );
		$valor  = isset( $_POST[ $nombre ] ) ? sanitize_text_field( wp_unslash( $_POST[ $nombre ] ) ) : '';
		printf(
			'<p class="rabisco-campo"><label for="%1$s">%2$s%3$s</label><input type="text" id="%1$s" name="%1$s" value="%4$s" maxlength="%5$d" %6$s autocomplete="off">%7$s</p>',
			esc_attr( $nombre ),
			esc_html( $c['etiqueta'] ),
			! empty( $c['obligatorio'] ) ? ' <abbr title="obligatorio">*</abbr>' : ' <span class="rabisco-opcional">(opcional)</span>',
			esc_attr( $valor ),
			(int) ( $c['max'] ?? 30 ),
			! empty( $c['obligatorio'] ) ? 'required' : '',
			! empty( $c['ayuda'] ) ? '<small>' . esc_html( $c['ayuda'] ) . '</small>' : ''
		);
	}
	echo '<p class="rabisco-revisa">Revisa bien la ortografía: lo imprimimos tal cual lo escribes.</p></div>';
} );

/* Validación al agregar al carrito */
add_filter( 'woocommerce_add_to_cart_validation', function ( $ok, $product_id ) {
	foreach ( rabisco_campos( $product_id ) as $c ) {
		$v = isset( $_POST[ rabisco_campo_nombre( $c['clave'] ) ] ) ? trim( sanitize_text_field( wp_unslash( $_POST[ rabisco_campo_nombre( $c['clave'] ) ] ) ) ) : '';
		if ( ! empty( $c['obligatorio'] ) && '' === $v ) {
			wc_add_notice( sprintf( 'Falta: %s.', $c['etiqueta'] ), 'error' );
			$ok = false;
		} elseif ( mb_strlen( $v ) > (int) ( $c['max'] ?? 30 ) ) {
			wc_add_notice( sprintf( '%s puede tener máximo %d caracteres.', $c['etiqueta'], (int) $c['max'] ), 'error' );
			$ok = false;
		}
	}
	return $ok;
}, 10, 2 );

/* Guardar en el ítem del carrito (cada personalización es una línea distinta) */
add_filter( 'woocommerce_add_cart_item_data', function ( $data, $product_id ) {
	foreach ( rabisco_campos( $product_id ) as $c ) {
		$v = isset( $_POST[ rabisco_campo_nombre( $c['clave'] ) ] ) ? trim( sanitize_text_field( wp_unslash( $_POST[ rabisco_campo_nombre( $c['clave'] ) ] ) ) ) : '';
		if ( '' !== $v ) {
			$data['rabisco'][ $c['etiqueta'] ] = $v;
		}
	}
	return $data;
}, 10, 2 );

/* Mostrar en carrito y checkout */
add_filter( 'woocommerce_get_item_data', function ( $items, $cart_item ) {
	foreach ( $cart_item['rabisco'] ?? array() as $etiqueta => $v ) {
		$items[] = array( 'key' => $etiqueta, 'value' => $v );
	}
	return $items;
}, 10, 2 );

/* Guardar en la línea del pedido (se ve en el admin y en los correos) */
add_action( 'woocommerce_checkout_create_order_line_item', function ( $item, $key, $values ) {
	foreach ( $values['rabisco'] ?? array() as $etiqueta => $v ) {
		$item->add_meta_data( $etiqueta, $v, true );
	}
}, 10, 3 );

/* ---------- Preventa con unidades limitadas ---------- */

// Texto de existencias: "Preventa · quedan 58 de 60" en vez de "58 disponibles".
add_filter( 'woocommerce_get_availability_text', function ( $texto, $product ) {
	$total = (int) $product->get_meta( '_rabisco_unidades_total' );
	if ( ! $total || ! $product->managing_stock() ) {
		return $texto;
	}
	if ( ! $product->is_in_stock() ) {
		return 'Agotado: se vendieron las ' . $total . ' unidades 💛';
	}
	return sprintf( 'Quedan %d de %d', $product->get_stock_quantity(), $total );
}, 10, 2 );

// Etiqueta "Preventa" sobre la foto en la tienda y en el producto.
function rabisco_etiqueta_preventa() {
	global $product;
	if ( $product && $product->get_meta( '_rabisco_preventa' ) && $product->is_in_stock() ) {
		echo '<span class="rabisco-preventa">Preventa</span>';
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'rabisco_etiqueta_preventa', 9 );
add_action( 'woocommerce_before_single_product_summary', 'rabisco_etiqueta_preventa', 9 );

// Línea de entrega bajo el precio.
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	$entrega = $product->get_meta( '_rabisco_entrega' );
	if ( $entrega ) {
		printf( '<p class="rabisco-entrega">🚚 %s</p>', esc_html( $entrega ) );
	}
}, 11 );
