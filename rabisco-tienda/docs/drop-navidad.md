# Drop de Navidad 2026

Los primeros (y por ahora únicos) productos de Rabisco. El drop es lo principal del sitio:

- **Inicio:** portada del drop ("Navidad con nombre propio"), cuadrícula de productos, la banda
  "¿Se te pasó la fecha?" y un último botón ("Quiero el mío").
- **Menú:** "✦ Drop de Navidad", resaltado en terracota, en el lugar de "Tienda".
- **Categoría:** `Drop de Navidad`, en `/categoria/drop-navidad/`. Es la categoría por defecto de
  los productos nuevos.
- Mientras no haya productos publicados, el inicio, la tienda y la categoría muestran "Muy pronto ✨".

## Primer lanzamiento: Kit del Elfo (preventa)

- **60 unidades**, con inventario activo solo para este producto. Se cierra solo al agotarse
  ("Agotado: se vendieron las 60 unidades 💛").
- **Entrega asegurada antes del 10 de noviembre.** Aparece bajo el precio, en la descripción y en
  la portada.
- Etiqueta azul "Preventa" sobre la foto y el texto "Quedan N de 60".
- **Personalización:** nombre del niño o niña (obligatorio, máx. 25) y nombre del elfo (opcional,
  máx. 20; si va vacío, queda en blanco en el certificado para bautizarlo en casa). Se guarda en
  cada línea del pedido y sale en el admin y en los correos.
- Contenido del kit: [`contenido/productos/kit-del-elfo.html`](../contenido/productos/kit-del-elfo.html).
- La portada y los botones "Quiero mi Kit del Elfo" / "Quiero el mío" llevan a `/producto/kit-del-elfo/`
  (da 404 mientras el producto esté en borrador).
- Probado el 1 oct con un precio de prueba: valida el nombre obligatorio, la personalización llega
  al carrito y al checkout, y no queda nada en inglés. Después volvió a borrador sin precio.

**Para publicarlo falta:** precio y fotos. Al publicarlo, conviene activar el banner en
Ajustes → Rabisco, por ejemplo "Preventa Kit del Elfo · solo 60 kits · entrega antes del 10 de noviembre".

## Productos (en borrador)

| ID | Producto | Tipo | Falta |
|---|---|---|---|
| 41 | Tags navideños para regalos | Variable: 20 tags (#45), 40 tags (#46) | Precio de cada opción, fotos, campos de personalización |
| 42 | Carta a Santa personalizada | Simple | Precio, fotos, campos |
| 43 | Kit del Elfo | Simple, 60 unidades | **Precio y fotos** (lo demás está listo) |
| 44 | Combo Navidad | Simple | Precio, fotos, qué incluye exactamente |

Se publican cuando tengan precio y al menos una foto. Los textos cortos son provisionales.

## Pendiente para el drop

- [ ] Confirmar si estos son todos los productos o si hay más.
- [ ] **Fecha límite de pedidos** para que llegue antes de Navidad (Bogotá y nacional). Se pone
      en el texto de la portada y en el banner (Ajustes → Rabisco).
- [ ] ¿Cupos o unidades limitadas? La portada dice "hay pocas unidades"; si hay un número real,
      se puede activar el inventario solo para estos productos.
- [ ] Fecha de apertura del drop, si se quiere anunciar antes de abrir la venta.
