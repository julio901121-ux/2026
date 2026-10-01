# Marca en la tienda

## Nombre: Rabisco Paper Studio (desde el 1 oct 2026)

Reemplaza por completo a **Stikka**. En el sitio ya se cambiaron el título, el pie de página,
los textos, el remitente de los correos y el mensaje de WhatsApp.

- **Lema provisional:** "Papelería personalizada, hecha en familia". "La marca que sí pega"
  jugaba con los stickers de Stikka y ya no aplica, así que hay que definir un lema nuevo.
- **Nombres internos sin cambiar:** el tema `stikka-child`, el plugin `stikka-core` y la opción
  `stikka_ajustes`. Cambiar el slug del tema borraría los ajustes de Kadence y no se ven en el sitio.
  El alias `ssh stikka` sigue funcionando junto a `ssh rabisco`.
## Logo e identidad visual (1 oct 2026)

Los originales están en [`../branding/`](../branding/) y las versiones para web en `branding/web/`:

| Archivo | Uso |
|---|---|
| `rabisco-logo-completo-transparente.png` | Logo completo con óvalo, corazón y "Paper Studio" (2100 px) |
| `rabisco-logo-completo-crema.jpg` | El mismo sobre fondo crema, para redes |
| `rabisco-wordmark-transparente.png` | Solo "rabisco" a colores |
| `web/rabisco-logo-header.png` | Encabezado del sitio (600 px) |
| `web/rabisco-icono-512.png` | Ícono del sitio y favicon: la "r" terracota sobre crema |

La tienda sigue al logo: **fondo crema, títulos en serifa tipo Bodoni (Bodoni Moda) como "Paper
Studio", texto en Nunito**, y los colores de las letras solo como acentos. Esto reemplaza la
paleta rosa y turquesa que se había armado para Stikka.

| Uso | Color | Origen en el logo |
|---|---|---|
| Botones y enlaces | `#b8461f` | Terracota `#d2552b` oscurecido (contraste AA con texto blanco) |
| Títulos y hover | `#2b2724` | Tinta de "Paper Studio" |
| Fondo | `#fbf7ee` | Crema del fondo |
| Bordes | `#ece4d6` | |
| Etiqueta de oferta | `#2e4fb0` | Azul de la "a" |
| Banner | fondo `#e2f1ee`, texto `#1f6b63` | Turquesa de la "o" `#2a9086` |
| Acentos libres | `#e2a21a` mostaza, `#d9487a` rosa, `#3f8a5a` verde | "b", "i", "s" |

---

## Historial: decisión con el nombre Stikka (reemplazada en color y tipografía)

Decisión del 1 oct 2026: **base neutra, mismo tono y colores más suaves** (opción b).
El manual original (`Manual_de_Marca_Stikka.docx`, sept 2026) pedía colores vivos y saturados.
Se mantiene la personalidad de la "amiga cómplice" y se baja la intensidad visual para encajar
con una clienta sofisticada y "aesthetic".

## Qué se conserva del manual

- Tono: cercano, divertido, resolutivo. Se le habla de "tú", como a una amiga.
- Promesa: "listo mañana".
- Eslogan: "La marca que sí pega" (en el título del sitio).
- Tipografía redondeada: **Nunito** (400/600/700/800).

## Paleta aplicada

| Uso | Color | Origen |
|---|---|---|
| Botones y enlaces | `#c2416f` | Rosa Chicle `#FF3D81` oscurecido (contraste AA con texto blanco) |
| Hover | `#a23459` | |
| Títulos | `#2b2b2b` | Grafito (igual al manual) |
| Texto | `#625c59` / `#3f3b3a` | Grises cálidos |
| Fondos | `#faf7f4` / `#ede7e3` / `#ffffff` | Base clara cálida |
| Acento secundario | `#2a9d8f`, fondo `#e3f4f1`, texto `#1e6f66` | Turquesa Pop `#17C3B2` suavizado (banner, etiqueta de oferta) |

Amarillo Sol, Morado Uva y Naranja Coral quedan fuera de la tienda por ahora; pueden volver
en piezas de redes o en el empaque.

Todo está en `wp-content/themes/stikka-child/style.css`. Para cambiar un color, se edita ahí y en
`kadence_global_palette` (`scripts/fase1.sh`), y luego se corre `scripts/desplegar.sh`.

## Pendiente

- ~~Logo~~: listo, ver arriba.
- Actualizar el manual: dice que la tienda en línea es "a futuro" y el contacto está vacío.
