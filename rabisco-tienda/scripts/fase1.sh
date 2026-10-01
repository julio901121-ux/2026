#!/usr/bin/env bash
# Fase 1 — configuración base de Rabisco Paper Studio (antes Stikka) con WP-CLI (aplicada el 1 oct 2026).
# Sirve como registro y para rehacer el sitio desde cero. Es seguro repetirlo,
# salvo la creación de menús (crearía menús duplicados).
# Después de esto: scripts/desplegar.sh y scripts/paginas.sh.
set -euo pipefail

ssh rabisco 'bash -s' <<'REMOTO'
set -euo pipefail
cd ~/domains/forestgreen-quetzal-442345.hostingersite.com/public_html

# --- Generales
wp language core install es_CO --activate
wp option update timezone_string America/Bogota
wp option update date_format 'j \d\e F \d\e Y'
wp option update blogname "Rabisco Paper Studio"
wp option update blogdescription "Papelería personalizada, hecha en familia"
wp option update blog_public 0            # oculto para buscadores hasta el lanzamiento
wp rewrite structure "/%postname%/" --hard

# --- WooCommerce
wp plugin install woocommerce --activate
wp language plugin install woocommerce es_CO
for kv in "woocommerce_currency COP" "woocommerce_currency_pos left" \
          "woocommerce_price_num_decimals 0" "woocommerce_price_thousand_sep ." \
          "woocommerce_price_decimal_sep ," "woocommerce_default_country CO:DC" \
          "woocommerce_store_city Bogotá" "woocommerce_allowed_countries specific" \
          "woocommerce_manage_stock no" "woocommerce_calc_taxes no" \
          "woocommerce_enable_guest_checkout yes" "woocommerce_weight_unit g" \
          "woocommerce_dimension_unit cm" "woocommerce_allow_tracking no" \
          "woocommerce_show_marketplace_suggestions no" "woocommerce_coming_soon no"; do
	set -- $kv; wp option update "$1" "$2" --quiet
done
wp option update woocommerce_specific_allowed_countries '["CO"]' --format=json

# --- Tema: Kadence + hijo (el hijo se sube con desplegar.sh)
wp theme install kadence
wp theme activate stikka-child
wp option update kadence_global_palette '{"palette":[{"color":"#c2416f","slug":"palette1","name":"Palette Color 1"},{"color":"#a23459","slug":"palette2","name":"Palette Color 2"},{"color":"#2b2b2b","slug":"palette3","name":"Palette Color 3"},{"color":"#3f3b3a","slug":"palette4","name":"Palette Color 4"},{"color":"#625c59","slug":"palette5","name":"Palette Color 5"},{"color":"#8a827e","slug":"palette6","name":"Palette Color 6"},{"color":"#ede7e3","slug":"palette7","name":"Palette Color 7"},{"color":"#faf7f4","slug":"palette8","name":"Palette Color 8"},{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"}],"second-palette":[],"third-palette":[],"active":"palette"}'
wp theme mod set page_content_style unboxed
wp eval 'set_theme_mod("footer_items", array(
	"top"    => array("top_1"=>array(),"top_2"=>array(),"top_3"=>array(),"top_4"=>array(),"top_5"=>array()),
	"middle" => array("middle_1"=>array(),"middle_2"=>array(),"middle_3"=>array(),"middle_4"=>array(),"middle_5"=>array()),
	"bottom" => array("bottom_1"=>array("footer-navigation"),"bottom_2"=>array("footer-html"),"bottom_3"=>array(),"bottom_4"=>array(),"bottom_5"=>array()),
));
set_theme_mod("footer_bottom_columns", "2");
set_theme_mod("footer_html_content", "© {year} Rabisco Paper Studio · Hecho en familia en Bogotá");'

# --- Páginas de WooCommerce en español (IDs de esta instalación)
wp post update 6 --post_title="Tienda" --post_name=tienda
wp post update 7 --post_title="Carrito" --post_name=carrito
wp post update 8 --post_title="Finalizar compra" --post_name=finalizar-compra
wp post update 9 --post_title="Mi cuenta" --post_name=mi-cuenta
REMOTO

# --- Contenido de páginas desde contenido/paginas/
"$(dirname "$0")/paginas.sh"

ssh rabisco 'bash -s' <<'REMOTO'
set -euo pipefail
cd ~/domains/forestgreen-quetzal-442345.hostingersite.com/public_html
id() { wp post list --post_type=page --post_status=any --fields=ID,post_name --format=csv | awk -F, -v s="$1" '$2==s {print $1; exit}'; }
INICIO=$(id inicio)
wp option update show_on_front page
wp option update page_on_front "$INICIO"
wp option update woocommerce_terms_page_id "$(id terminos-y-condiciones)"
wp option update wp_page_for_privacy_policy "$(id tratamiento-de-datos)"
wp option update woocommerce_refund_returns_page_id "$(id politica-de-cambios)"
wp post meta update "$INICIO" _kad_post_title hide
wp post meta update "$INICIO" _kad_post_layout fullwidth
wp post meta update "$INICIO" _kad_post_content_style unboxed
wp post meta update "$INICIO" _kad_post_vertical_padding hide

# Menús (LiteSpeed ensucia la salida de --porcelain; por eso se buscan por nombre)
wp menu create "Principal" >/dev/null; wp menu create "Pie de página" >/dev/null
M=$(wp menu list --fields=term_id,name --format=csv | awk -F, '$2=="Principal"{print $1}')
F=$(wp menu list --fields=term_id,name --format=csv | awk -F, '$2=="Pie de página"{print $1}')
for s in tienda como-funciona preguntas-frecuentes contacto; do wp menu item add-post "$M" "$(id $s)" --quiet; done
for s in terminos-y-condiciones tratamiento-de-datos politica-de-cambios contacto; do wp menu item add-post "$F" "$(id $s)" --quiet; done
wp menu location assign "$M" primary; wp menu location assign "$M" mobile; wp menu location assign "$F" footer
wp litespeed-purge all
REMOTO
