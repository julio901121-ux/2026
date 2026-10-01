# Marca en la tienda

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

- Logo (wordmark con la doble "kk"): por ahora el encabezado muestra "Stikka" en texto.
- Actualizar el manual: dice que la tienda en línea es "a futuro" y el contacto está vacío.
