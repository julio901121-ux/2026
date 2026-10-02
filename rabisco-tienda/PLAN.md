# Rabisco Paper Studio — Plan para arrancar la tienda

> El 1 oct 2026 la marca pasó de **Stikka** a **Rabisco Paper Studio**. Las menciones de Stikka más abajo son históricas.

Mañana: jueves 1 de octubre de 2026. Meta: lanzar el sábado 3 de octubre.

| Día | Fase | Resultado al final del día |
|---|---|---|
| Jue 1 oct | 0 Preparación + 1 Base | Sitio en español/COP, tema hijo, páginas, banner y WhatsApp funcionando |
| Vie 2 oct | 2 Productos y checkout | Se puede comprar de punta a punta (Bold en pruebas) |
| Sáb 3 oct | 3 Lanzamiento | Compra real verificada, Píxel validado, sitio abierto |

El riesgo principal del calendario era **Bold**: ya está verificado (1 oct).

## Estado al 1 oct 2026

- **Fase 0 lista:** SSH con llave, inventario y primer respaldo ([docs/servidor.md](docs/servidor.md)).
- **Fase 1 casi lista:** sitio en español y COP, WooCommerce 11.1, tema `stikka-child` (Kadence), páginas, menús, banner y WhatsApp. Se configura todo en `scripts/fase1.sh`.
- **Marca:** se eligió la dirección (b), con base neutra, el tono de la "amiga cómplice" y Rosa y Turquesa suavizados. Detalle en [docs/marca.md](docs/marca.md).
- **Drop de Navidad:** el inicio, el menú y la categoría ya están armados, y los 4 productos están en borrador ([docs/drop-navidad.md](docs/drop-navidad.md)).
- **Falta de la Fase 1:** conversión a WebP en LiteSpeed (requiere QUIC.cloud y conviene hacerla con el dominio definitivo), número de WhatsApp y el visto bueno de Julio en el celular.

---

## 1. Antes de sentarte con Claude (tú, ~30 min)

Esto es lo único que bloquea el arranque. Ten estas respuestas a mano:

- [x] **Hostinger:** plan Premium, vence el 20 may 2028.
- [x] **SSH:** activado y con la llave cargada.
- [x] **WordPress:** instalado en https://forestgreen-quetzal-442345.hostingersite.com
- [x] **Dirección de marca:** se eligió la (b). Opciones que había:
  - (a) el manual de marca tal cual (colores vivos, tono divertido),
  - (b) la propuesta intermedia: base clara + Grafito, Rosa y Turquesa como acentos, tipografía redondeada (recomendada),
  - (c) fino/minimalista como decía el brief original.
- [x] **Git:** repo público github.com/julio901121-ux/2026 (sin claves ni respaldos).
- [x] **Bold:** cuenta verificada.

## 2. Sesión de mañana con Claude

### Bloque A — Fase 0, preparación (~2 h)

1. Claude genera la llave SSH; tú la pegas en hPanel → Acceso SSH → Llaves SSH.
2. Probar conexión y que WP-CLI responda en el servidor.
3. Inventario del servidor: versiones de PHP/WordPress/WooCommerce, plugins y temas instalados.
4. **Primer respaldo** (base de datos + `wp-content`), guardado fuera de la carpeta pública. Además verifica en hPanel que los respaldos automáticos estén activos.
5. Inicializar este repo con la estructura:
   ```
   stikka-tienda/
   ├── wp-content/themes/stikka-child/      ← diseño
   ├── wp-content/mu-plugins/stikka-core/   ← personalización, envíos, banner, WhatsApp
   ├── scripts/                             ← configuración con WP-CLI (repetible)
   └── docs/
   ```
6. Definir cómo se sube el código al servidor (git o rsync por SSH).

### Bloque B — Fase 1, base (~4–5 h)

Claude pide confirmación antes de cada cambio en el servidor.

1. Ajustes generales: es_CO, zona horaria de Bogotá, enlaces permanentes.
2. WooCommerce: COP sin decimales, sin control de stock, país Colombia.
3. Kadence + tema hijo `stikka-child` con la paleta y tipografía elegidas, wordmark provisional.
4. LiteSpeed Cache con conversión a WebP.
5. Crear páginas: inicio, tienda, cómo funciona, preguntas frecuentes, contacto, tratamiento de datos, términos y condiciones, política de cambios (borradores legales para revisión).
6. Banner de fecha límite editable desde el admin (se oculta solo al vencer).
7. Botón flotante de WhatsApp.
8. Commit, respaldo y **lista de pruebas desde el celular** → tu visto bueno para pasar a la fase 2.

## 3. Para tener listo el viernes (fase 2)

Puedes ir mandándolo mañana mientras Claude avanza:

- [ ] Precio de cada producto y variación (tags 20 / 40, carta a Santa, kit del elfo, combo).
- [ ] Fotos de producto (las más bonitas posibles: son la marca).
- [ ] Personalización: ¿un nombre por kit o lista de nombres? ¿Qué campos lleva cada producto? ¿Cuáles obligatorios? ¿Largo máximo de la dedicatoria?
- [ ] Combo: ¿precio propio y una sola personalización, o una por kit?
- [ ] Envíos: localidades que cuentan como "Bogotá norte", tarifas de las 3 zonas, envío gratis desde cierto monto, ¿recogida?
- [ ] Tiempos: días de producción y fecha límite para entregar antes de Navidad (Bogotá y nacional). ¿Se mantiene "listo mañana" en temporada?
- [ ] Número de WhatsApp y mensaje inicial.
- [ ] ID del Píxel de Meta.
- [ ] Datos del responsable del tratamiento de datos: nombre o razón social, cédula o NIT, dirección y correo para peticiones.
- [ ] ¿Están obligados a facturación electrónica? (tarea aparte si sí).

## 4. Para tener listo el sábado (lanzamiento)

- [ ] Dominio comprado y apuntado a Hostinger.
- [ ] Correo con el dominio (ej. hola@…) para que los correos de pedidos no caigan en spam.
- [ ] Bold verificado y en modo producción.
- [ ] Un abogado revisa (o al menos ya tiene) los textos legales.

## Dónde van las claves (nunca en el código ni en Git)

| Clave | Dónde la configuras tú |
|---|---|
| Bold | WooCommerce → Ajustes → Pagos → Bold |
| Píxel de Meta | Configuración del plugin oficial de Meta para WooCommerce |
| Contraseña del correo (SMTP) | Plugin de correo, cuando lleguemos a ese paso |
| Contraseña SSH / hPanel | Solo tú; Claude usa la llave SSH |

## Cómo retomar

Abre Claude Code y escribe: **"retomemos la tienda de Stikka"**, junto con las respuestas de la sección 1.
