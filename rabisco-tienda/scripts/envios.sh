#!/usr/bin/env bash
# Zonas y tarifas de envío (aplicado el 1 oct 2026). Borra las zonas existentes y las recrea.
# La regla "Usaquén y Chapinero = norte" vive en wp-content/mu-plugins/stikka-core/envios.php,
# que usa las opciones rabisco_envio_norte / rabisco_envio_resto que guarda este script.
set -euo pipefail

ssh rabisco 'cd ~/domains/forestgreen-quetzal-442345.hostingersite.com/public_html
wp option update woocommerce_default_country "CO:CO-DC"
wp option update woocommerce_ship_to_destination billing_only   # se envía a la dirección de facturación
wp option update woocommerce_enable_shipping_calc no
wp option update woocommerce_shipping_cost_requires_address yes
wp option update woocommerce_checkout_phone_field required
wp eval '"'"'
foreach ( WC_Shipping_Zones::get_zones() as $z ) { WC_Shipping_Zones::delete_zone( $z["id"] ); }
function rab_metodo( $zona, $tipo, $titulo, $costo ) {
	$id = $zona->add_shipping_method( $tipo );
	$s  = array( "title" => $titulo, "tax_status" => "none", "cost" => "flat_rate" === $tipo ? (string) $costo : "" );
	update_option( "woocommerce_{$tipo}_{$id}_settings", $s );
	return $id;
}
$bog = new WC_Shipping_Zone(); $bog->set_zone_name( "Bogotá" ); $bog->set_zone_order( 1 );
$bog->add_location( "CO:CO-DC", "state" ); $bog->save();
update_option( "rabisco_envio_norte", rab_metodo( $bog, "flat_rate", "Domicilio Bogotá norte (Usaquén y Chapinero)", 6000 ) );
update_option( "rabisco_envio_resto", rab_metodo( $bog, "flat_rate", "Domicilio resto de Bogotá", 8500 ) );
rab_metodo( $bog, "local_pickup", "Recoger en Santa Bárbara Oriental (gratis)", 0 );
$nal = new WC_Shipping_Zone(); $nal->set_zone_name( "Resto de Colombia" ); $nal->set_zone_order( 2 );
$nal->add_location( "CO", "country" ); $nal->save();
rab_metodo( $nal, "flat_rate", "Envío nacional", 15000 );
rab_metodo( $nal, "local_pickup", "Recoger en Bogotá, Santa Bárbara Oriental (gratis)", 0 );
echo "Zonas creadas\n";
'"'"'
wp litespeed-purge all'
