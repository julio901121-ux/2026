# Servidor

Datos del hosting, sin claves ni contraseñas.

| Dato | Valor |
|---|---|
| Proveedor | Hostinger |
| Plan | Premium (incluye SSH y WP-CLI) |
| Vence | 20 may 2028 |
| Host SSH | _pendiente_ |
| Puerto SSH | _pendiente_ |
| Usuario SSH | _pendiente_ |
| URL temporal de WordPress | https://forestgreen-quetzal-442345.hostingersite.com |
| Dominio definitivo | stikka.co (_pendiente de comprar/apuntar_) |

## Estado inicial (1 oct 2026, visto desde fuera)

- WordPress 7.1.2 recién instalado, PHP 8.3, HTTPS activo, CDN de Hostinger.
- Sin título ni descripción y con zona horaria UTC: se ajusta en la Fase 1.
- WooCommerce no se ve activo desde fuera; se confirma por SSH.

## Acceso

- Se entra por llave SSH (`~/.ssh/stikka_hostinger` en el Mac de Julio). La llave privada nunca sale de ese equipo.
- La llave pública está cargada en hPanel → Avanzado → Acceso SSH → Llaves SSH.
