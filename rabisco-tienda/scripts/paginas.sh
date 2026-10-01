#!/usr/bin/env bash
# Sube el contenido de contenido/paginas/*.html a WordPress.
# El nombre del archivo es el slug de la página; crea la página si no existe.
# Ojo: sobrescribe lo que se haya editado a mano en el admin para esas páginas.
# Uso: scripts/paginas.sh [slug ...]   (sin argumentos: todas)
set -euo pipefail

cd "$(dirname "$0")/../contenido/paginas"
WP="cd ~/domains/forestgreen-quetzal-442345.hostingersite.com/public_html && wp"

titulo() {
	case "$1" in
		inicio) echo "Inicio" ;;
		como-funciona) echo "Cómo funciona" ;;
		preguntas-frecuentes) echo "Preguntas frecuentes" ;;
		contacto) echo "Contacto" ;;
		tratamiento-de-datos) echo "Tratamiento de datos personales" ;;
		terminos-y-condiciones) echo "Términos y condiciones" ;;
		politica-de-cambios) echo "Política de cambios y devoluciones" ;;
		*) echo "$1" ;;
	esac
}

SLUGS=("$@")
[ ${#SLUGS[@]} -eq 0 ] && SLUGS=($(ls *.html | sed 's/\.html$//'))

for slug in "${SLUGS[@]}"; do
	scp -q "$slug.html" "rabisco:/tmp/stikka-$slug.html"
	# --name con --post_status=any no encuentra borradores; por eso se filtra la lista completa.
	id=$(ssh rabisco "$WP post list --post_type=page --post_status=publish,draft,pending,private --fields=ID,post_name --format=csv" | awk -F, -v s="$slug" '$2==s {print $1; exit}')
	if [ -z "$id" ]; then
		id=$(ssh rabisco "$WP post create /tmp/stikka-$slug.html --post_type=page --post_status=publish --post_name=$slug --post_title='$(titulo "$slug")' --porcelain")
		echo "Creada:      $slug (#$id)"
	else
		ssh rabisco "$WP post update $id /tmp/stikka-$slug.html --post_status=publish --quiet"
		echo "Actualizada: $slug (#$id)"
	fi
	ssh rabisco "rm -f /tmp/stikka-$slug.html"
done
