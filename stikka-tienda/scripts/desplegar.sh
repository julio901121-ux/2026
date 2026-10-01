#!/usr/bin/env bash
# Sube el código de Stikka al servidor por rsync.
# Solo toca las carpetas propias (tema hijo y mu-plugin); el resto de wp-content no se modifica.
# Uso: scripts/desplegar.sh            (sube)
#      scripts/desplegar.sh --dry-run  (muestra qué cambiaría)
set -euo pipefail

cd "$(dirname "$0")/.."
DEST="stikka:domains/forestgreen-quetzal-442345.hostingersite.com/public_html/wp-content"
OPTS=(-az --itemize-changes --exclude .gitkeep --exclude .DS_Store "$@")

# Revisión de sintaxis PHP en el servidor antes de subir nada (el Mac no tiene PHP).
for f in $(find wp-content -name '*.php'); do
	ssh stikka "php -l" < "$f" > /dev/null || { echo "Error de sintaxis en $f"; exit 1; }
done

rsync "${OPTS[@]}" --delete wp-content/themes/stikka-child/ "$DEST/themes/stikka-child/"
rsync "${OPTS[@]}" --delete wp-content/mu-plugins/stikka-core/ "$DEST/mu-plugins/stikka-core/"
rsync "${OPTS[@]}" wp-content/mu-plugins/stikka-core-loader.php "$DEST/mu-plugins/"
echo "Desplegado."
