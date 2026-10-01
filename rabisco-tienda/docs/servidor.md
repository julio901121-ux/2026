# Servidor

Datos del hosting, sin claves ni contraseñas.

| Dato | Valor |
|---|---|
| Proveedor | Hostinger |
| Plan | Premium (incluye SSH y WP-CLI) |
| Vence | 20 may 2028 |
| Host SSH | 88.223.84.43 |
| Puerto SSH | 65002 |
| Usuario SSH | u320508150 |
| Alias en el Mac | `ssh rabisco` (en `~/.ssh/config`) |
| Ruta del sitio | `~/domains/forestgreen-quetzal-442345.hostingersite.com/public_html` |

> En el mismo hosting también vive **axisejecutivo.com**. No se toca: todo el trabajo se queda dentro de la carpeta de la tienda.
| URL temporal de WordPress | https://forestgreen-quetzal-442345.hostingersite.com |
| Dominio definitivo | _pendiente_ (al 1 oct estaban libres rabisco.co, rabisco.com.co, rabiscopaper.co, rabiscopaper.com y rabiscopaperstudio.com/.co) |

## Estado inicial (1 oct 2026, visto desde fuera)

- WordPress 7.1.2 recién instalado, PHP 8.3, HTTPS activo, CDN de Hostinger.
- Sin título ni descripción y con zona horaria UTC: se ajusta en la Fase 1.
- WooCommerce no se ve activo desde fuera; se confirma por SSH.

## Inventario por SSH (1 oct 2026)

- WordPress 7.1.2 · PHP 8.3.33 · WP-CLI 2.12.0 · base de datos de 2 MB · `wp-content` de 130 MB.
- Plugins: hostinger, hostinger-easy-onboarding, hostinger-reach, litespeed-cache 7.9.1; mu-plugins: hostinger-preview-domain, hostinger-auto-updates.
- Tema activo: hostinger-ai-theme (se reemplaza por Kadence + stikka-child en la Fase 1).
- WooCommerce: **no instalado**. Idioma: inglés. Zona horaria: UTC.

## Respaldos

- Script: [`scripts/respaldo.sh`](../scripts/respaldo.sh) (`wp db export` no funciona aquí; usa mysqldump).
- En el servidor: `~/respaldos/rabisco/` (fuera de public_html, permisos 700).
- En el Mac: `~/Documents/PROYECTOS/rabisco-respaldos/` (nunca en Git).
- Primer respaldo: `20261001-1633-inicial` (29 tablas, BD de 23 KB comprimida, wp-content de 40 MB).
- Pendiente de Julio: confirmar en hPanel → Respaldos que los respaldos automáticos estén activos.

## Acceso

- Se entra por llave SSH (`~/.ssh/stikka_hostinger` en el Mac de Julio). La llave privada nunca sale de ese equipo.
- La llave pública está cargada en hPanel → Avanzado → Acceso SSH → Llaves SSH.
