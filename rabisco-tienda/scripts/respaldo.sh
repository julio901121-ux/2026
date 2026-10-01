#!/usr/bin/env bash
# Respaldo de Rabisco: base de datos + wp-content.
# Guarda en el servidor (~/respaldos/rabisco, fuera de public_html) y trae una copia al Mac.
# Uso: scripts/respaldo.sh [etiqueta]     ej: scripts/respaldo.sh antes-fase1
#
# Nota: `wp db export` no funciona en este hosting (termina sin error y sin archivo),
# por eso se usa mysqldump con las credenciales de wp-config en un archivo temporal.
set -euo pipefail

ETIQUETA="${1:-manual}"
LOCAL="$HOME/Documents/PROYECTOS/rabisco-respaldos"

ssh rabisco "ETIQUETA='$ETIQUETA' bash -s" <<'REMOTO'
set -euo pipefail
S=~/domains/forestgreen-quetzal-442345.hostingersite.com/public_html
B=~/respaldos/rabisco
mkdir -p "$B" && chmod 700 ~/respaldos "$B"
cd "$S"
CNF=$(mktemp); chmod 600 "$CNF"; trap 'rm -f "$CNF"' EXIT
printf "[client]\nuser=%s\npassword=%s\nhost=%s\n" \
  "$(wp config get DB_USER)" "$(wp config get DB_PASSWORD)" "$(wp config get DB_HOST)" > "$CNF"
T="$(date +%Y%m%d-%H%M)-$ETIQUETA"
mysqldump --defaults-extra-file="$CNF" --single-transaction --no-tablespaces \
  "$(wp config get DB_NAME)" | gzip > "$B/$T-db.sql.gz"
tar czf "$B/$T-wp-content.tar.gz" wp-content
echo "Tablas: $(zcat "$B/$T-db.sql.gz" | grep -c 'CREATE TABLE')"
ls -lh "$B"/"$T"*
REMOTO

mkdir -p "$LOCAL"
scp -q "rabisco:respaldos/rabisco/*-$ETIQUETA-*" "$LOCAL/"
echo "Copia local en $LOCAL"
