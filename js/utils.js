/**
 * Atelier - Utilidades y funciones reutilizables
 * Funciones de apoyo para formateo de precios, validaciones y filtros del catálogo.
 */

/**
 * Formatea un número como precio en pesos dominicanos (RD$) con separador de miles.
 * Si recibe un valor no válido, devuelve RD$0 por seguridad.
 *
 * @param {number|string} monto - Número o precio a formatear.
 * @param {string} [moneda="DOP"] - Código de moneda (por defecto peso dominicano DOP).
 * @param {string} [locale="es-DO"] - Región para dar el formato correcto (República Dominicana).
 * @returns {string} Precio formateado (ej: "RD$2,450").
 */
function formatearMoneda(monto, moneda = "DOP", locale = "es-DO") {
  const valorNumerico = Number(monto);

  if (!Number.isFinite(valorNumerico) || Number.isNaN(valorNumerico)) {
    return "RD$0";
  }

  return new Intl.NumberFormat(locale, {
    style: "currency",
    currency: moneda,
    minimumFractionDigits: Number.isInteger(valorNumerico) ? 0 : 2,
    maximumFractionDigits: 2
  }).format(valorNumerico);
}

/**
 * Valida que el email tenga un formato correcto antes de procesarlo.
 *
 * @param {string} correo - Correo a validar.
 * @returns {boolean} true si es un correo válido, false si no.
 */
function validarEmail(correo) {
  if (typeof correo !== "string") {
    return false;
  }

  const correoLimpio = correo.trim();
  const patronEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

  return patronEmail.test(correoLimpio);
}

/**
 * Verifica que el texto cumpla un mínimo de caracteres y no tenga caracteres extraños.
 *
 * @param {string} cadena - Texto que ingresó el usuario.
 * @param {number} [minLen=3] - Cantidad mínima de caracteres requerida.
 * @param {RegExp} [patronCaracteres] - Patrón de caracteres permitidos.
 * @returns {boolean} true si el texto es válido.
 */
function validarTexto(
  cadena,
  minLen = 3,
  patronCaracteres = /^[\p{L}\p{N}\s.,'’\-:;()!?¿¡"/%]+$/u
) {
  if (typeof cadena !== "string") {
    return false;
  }

  const textoLimpio = cadena.trim();

  if (textoLimpio.length < minLen) {
    return false;
  }

  return patronCaracteres instanceof RegExp ? patronCaracteres.test(textoLimpio) : true;
}

/**
 * Filtra los productos por su categoría sin modificar el arreglo original.
 * Si se pasa "todas", regresa la lista completa.
 *
 * @param {Array<Object>} lista - Catálogo de productos.
 * @param {string} categoria - Categoría elegida (ej: "Vestidos").
 * @returns {Array<Object>} Lista filtrada de productos.
 */
function filtrarPorCategoria(lista, categoria) {
  if (!Array.isArray(lista)) {
    return [];
  }

  const categoriaBuscada = (categoria || "").trim().toLowerCase();

  if (!categoriaBuscada || categoriaBuscada === "todas") {
    return [...lista];
  }

  return lista.filter(producto => {
    return (
      Boolean(producto) &&
      typeof producto.categoria === "string" &&
      producto.categoria.trim().toLowerCase() === categoriaBuscada
    );
  });
}

/**
 * Calcula el total aplicando un porcentaje de descuento (de 0 a 100).
 *
 * @param {number} precio - Precio base del producto.
 * @param {number} [porcentajeDescuento=0] - Porcentaje de descuento a aplicar.
 * @returns {number} Precio con el descuento ya aplicado.
 */
function calcularTotalConDescuento(precio, porcentajeDescuento = 0) {
  const precioBase = Number(precio);
  const descuento = Number(porcentajeDescuento);

  if (!Number.isFinite(precioBase) || precioBase < 0) {
    return 0;
  }

  if (!Number.isFinite(descuento) || descuento <= 0) {
    return Math.round(precioBase * 100) / 100;
  }

  const descuentoAcotado = Math.min(Math.max(descuento, 0), 100);
  const total = precioBase * (1 - descuentoAcotado / 100);

  return Math.round(total * 100) / 100;
}
