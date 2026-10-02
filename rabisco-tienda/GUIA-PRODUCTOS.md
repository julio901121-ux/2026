# Guía para crear productos: Rabisco Paper Studio

Cada producto nuevo sale de una **ficha**. Ustedes la llenan con lo que saben del producto, la
mandan a Claude (o la pegan en el chat) y Claude lo arma en la tienda, lo prueba y lo publica.

**Cómo usarla**

1. Copien la [plantilla](#plantilla-de-ficha) y llénenla. Si no saben algo todavía, escriban
   `PENDIENTE`: no tiene que estar completa para empezar.
2. Dejen las fotos en `Documents/PROYECTOS/rabisco-tienda/FOTOS PRODUCTOS/<nombre-del-producto>/`.
3. Manden la ficha a Claude. El producto se arma en **borrador** (nadie lo ve) y solo se publica
   cuando tiene precio, fotos y el visto bueno de ustedes.

---

## Plantilla de ficha

```markdown
# Ficha: <nombre del producto>

## 1. Lo básico
- Nombre en la tienda:
- ¿Para quién es? (ej. niños de 3 a 8 años, mamás del colegio, regalo para profes):
- Precio (COP):
- ¿Tiene opciones? (ej. 20 o 40 tags, tamaño, color). Precio de cada una:
- ¿Hace parte de un drop o colección?:

## 2. Qué incluye
- (un elemento por línea; si quieren, con emoji)

## 3. Personalización
| Dato que escribe la clienta | ¿Obligatorio? | Máx. letras | ¿Dónde va impreso? |
|---|---|---|---|
| ej. Nombre del niño o niña | Sí | 25 | Carta y certificados |

- ¿Se puede pedir para varios niños en un solo pedido, o un producto por niño?:
- ¿Hay que elegir algo (ej. niño/niña, color del elfo)? Opciones:

## 4. Venta
- ¿Preventa o entrega inmediata?:
- Fecha de entrega asegurada o días de producción:
- ¿Unidades limitadas? ¿Cuántas?:
- ¿Fecha en que se cierra la venta?:

## 5. Textos
- En una frase, ¿por qué alguien lo querría?:
- Algo de la historia o del proceso que valga la pena contar:
- Preguntas que creen que les van a hacer:

## 6. Fotos
- Carpeta: FOTOS PRODUCTOS/<nombre-del-producto>/
- ¿Cuál es la principal?:

## 7. Notas
- (cuidados, materiales, tamaño, algo que NO se deba prometer, etc.)
```

---

## Fotos

| | Recomendación |
|---|---|
| Cantidad | De 3 a 6 por producto: 1 principal, el producto abierto, detalles y una "en uso" |
| Principal | Llámenla `01-principal.jpg`. Es la que sale en la tienda y en el inicio |
| Fondo | Claro y sin desorden. Una mesa blanca o de madera clara combina con el crema del sitio |
| Luz | Natural, de día, cerca de una ventana y sin flash |
| Formato | Cuadrado o vertical. Mándenlas originales y grandes; Claude las reduce para la web |
| Personalización | Al menos una foto donde se lea un nombre de ejemplo, para que se entienda qué se personaliza |
| No usar | Fotos de internet o de otras marcas, ni fotos de niños sin permiso de sus papás |

---

## Textos: cómo habla Rabisco

- **Como una amiga cómplice**: cercana, resolutiva y con buen gusto. Se le habla de **tú** a la clienta.
- La marca habla en **nosotros** (nunca "nosotras").
- Frases cortas. Primero la emoción y después los detalles.
- **Solo se promete lo que es verdad.** "Solo 60 unidades" se puede decir porque la tienda las
  cuenta y se cierra sola. "Entrega antes del 10 de noviembre" se puede decir si de verdad se
  cumple. Si un dato no está claro, se deja `PENDIENTE` en vez de inventarlo.
- Los datos de los niños se usan solo para hacer el producto (ver Tratamiento de datos).

---

## Lo que ya está resuelto para todos los productos

No hace falta repetirlo en cada ficha:

| Tema | Cómo funciona |
|---|---|
| Moneda | Pesos colombianos sin decimales ($90.000) |
| Envíos | Usaquén y Chapinero $6.000 · resto de Bogotá $8.500 · nacional $15.000 · recoger en Santa Bárbara Oriental gratis |
| Pagos | Bold: tarjeta, PSE y Nequi (por conectar) |
| Personalización | Se pide en la página del producto, se valida y queda en el pedido y en el correo |
| Unidades limitadas | La tienda muestra "Quedan N de X" y se cierra sola al agotarse |
| Preventa | Etiqueta azul "Preventa" y una línea de entrega bajo el precio |
| Devoluciones | Por ser personalizado no hay retracto; si el error es nuestro, se repone (Política de cambios) |

Si un producto necesita algo distinto (por ejemplo, un envío más caro por ser grande), se
anota en **Notas** de la ficha.

---

## Lo que hace Claude con cada ficha

1. Crea la carpeta de fotos y el producto en **borrador** con precio, opciones e inventario.
2. Escribe la descripción con el tono de la marca y la guarda en `contenido/productos/<producto>.html`.
3. Configura los campos de personalización.
4. Optimiza las fotos y las sube.
5. **Lo prueba de punta a punta:** campos obligatorios, carrito, checkout y envío por zona. Les
   manda capturas del celular.
6. Lo publica cuando ustedes den el visto bueno, y lo registra en la tabla de abajo.

---

## Estado de los productos

| Producto | Drop | Precio | Unidades | Fotos | Estado |
|---|---|---|---|---|---|
| Kit del Elfo | Navidad 2026 | $90.000 | 60 (preventa) | Pendientes | Listo, falta foto para publicar |
| Tags navideños (20 / 40) | Navidad 2026 | Pendiente | Pendiente | Pendientes | Borrador vacío |
| Carta a Santa personalizada | Navidad 2026 | Pendiente | Pendiente | Pendientes | Borrador vacío |
| Combo Navidad | Navidad 2026 | Pendiente | Pendiente | Pendientes | Borrador vacío |

---

## Ejemplo: ficha del Kit del Elfo

```markdown
# Ficha: Kit del Elfo

## 1. Lo básico
- Nombre en la tienda: Kit del Elfo
- ¿Para quién es?: Familias con niños pequeños que quieren vivir la tradición del elfo
- Precio (COP): 90.000
- ¿Tiene opciones?: No
- ¿Hace parte de un drop?: Drop de Navidad 2026 (primer lanzamiento)

## 2. Qué incluye
- 🧝‍♂️ Muñeco elfo navideño
- 📜 Carta de bienvenida desde el Polo Norte
- 🎖️ Certificado de adopción
- 🏅 Certificado oficial de Mejor Ayudante de Santa (lo deja el elfo al despedirse)
- 🎨 Cartilla para colorear "Colorea la magia"
- ✨ Tatuajes temporales
- 🎁 Stickers para travesuras
- 📘 Instrucciones para los padres
- 🍬 Dulce navideño
- 🎁 Bolsa oficial del Polo Norte, lista para entregar al niño

## 3. Personalización
| Dato que escribe la clienta | ¿Obligatorio? | Máx. letras | ¿Dónde va impreso? |
|---|---|---|---|
| Nombre del niño o niña | Sí | 25 | Carta de bienvenida y certificados |
| Nombre del elfo | No (si va vacío, se bautiza en casa) | 20 | Certificado de adopción |

- ¿Varios niños en un pedido?: PENDIENTE (hoy es un kit por niño)
- ¿Hay que elegir algo?: PENDIENTE (¿elfo niño o niña?)

## 4. Venta
- ¿Preventa o entrega inmediata?: Preventa
- Fecha de entrega asegurada: antes del 10 de noviembre de 2026
- ¿Unidades limitadas?: Sí, 60
- ¿Fecha en que se cierra la venta?: PENDIENTE (hoy se cierra al agotarse)

## 5. Textos
- En una frase: Un ayudante de Santa llega a tu casa con todo para hacer la Navidad mágica.

## 6. Fotos
- Carpeta: FOTOS PRODUCTOS/kit-del-elfo/
- ¿Cuál es la principal?: PENDIENTE

## 7. Notas
- El dulce es comestible: ¿hay que avisar de alérgenos? PENDIENTE
```
