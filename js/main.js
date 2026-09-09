/* ==========================================================================
   ATELIER - FASE 2: CONFIGURACIÓN BASE Y ESTRUCTURA DE DATOS
   ========================================================================== */

// Variables de configuración global (Tipos primitivos: String, Number, Boolean)
const NOMBRE_TIENDA = "ATELIER"; // String
const VERSION_APP = 2.0;          // Number
const MODO_DEPURACION = true;     // Boolean

// Estructura de datos inicial
const configApp = {
  tienda: NOMBRE_TIENDA,
  version: VERSION_APP,
  activa: MODO_DEPURACION
};

// Mensaje de verificación en consola
console.log(`[${configApp.tienda}] Entorno JavaScript cargado correctamente (v${configApp.version})`);

// Datos de los productos del catálogo
const productos = [
  {
    nombre: "Vestido midi crudo",
    precio: 2450,
    categoria: "Vestidos",
    imagen: "https://plus.unsplash.com/premium_photo-1674327105078-5b2cdcc86929?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfd8fGVufDB8fHx8fA%3D%3D",
    etiqueta: "Novedad",
    colores: ["#211E1B", "#B23A2E", "#EFEBE2"]
  },
  {
    nombre: "Camisa de lino",
    precio: 1890,
    categoria: "Camisas",
    imagen: "https://images.pexels.com/photos/29732777/pexels-photo-29732777.jpeg",
    colores: ["#3F5D54", "#FBFAF7"]
  },
  {
    nombre: "Pantalón sastre",
    precio: 2100,
    categoria: "Pantalones",
    imagen: "https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=500&q=80&auto=format&fit=crop",
    etiqueta: "Oferta",
    colores: ["#907e6c"]
  },
  {
    nombre: "Botines de cuero",
    precio: 3300,
    categoria: "Zapatos",
    imagen: "https://images.pexels.com/photos/27256443/pexels-photo-27256443.jpeg",
    colores: ["#211E1B"]
  }
];

/* ==========================================================================
   ATELIER - FUNCIONES Y UTILIDADES
   ========================================================================== */

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

function mostrarProductos(lista) {
  if (typeof document === "undefined") return;
  const contenedor = document.getElementById("productos-container");

  if (!contenedor) return; // esta página no tiene catálogo (contacto/nosotros)

  contenedor.innerHTML = "";

  if (lista.length === 0) {
    contenedor.innerHTML = `<p style="grid-column:1 / -1; color:var(--ink-soft);">No encontramos productos que coincidan con tu búsqueda.</p>`;
    return;
  }

  lista.forEach(producto => {
    const tarjeta = document.createElement("li");

    tarjeta.classList.add("producto-card");

    tarjeta.innerHTML = `
      <div class="producto-imagen">
        ${producto.etiqueta ? `<span class="etiqueta">${producto.etiqueta}</span>` : ""}
        <img src="${producto.imagen}" alt="${producto.nombre}">
      </div>

     <div class="producto-info">
        <h3>${producto.nombre}</h3>
        <p class="producto-precio">${formatearMoneda(producto.precio)}</p>

        <div class="colores">
          ${producto.colores.map(color => `
            <span style="background:${color};"></span>
          `).join("")}
        </div>
      </div>
    `;

    contenedor.appendChild(tarjeta);
  });
}

mostrarProductos(productos);


/*BUSCADOR Y FILTRO INTERACTIVO DEL HEADER
   Alterna la navegación por un campo de búsqueda + selector de categoría,
   y filtra el array "productos". */

const btnBuscar = typeof document !== "undefined" ? document.getElementById("btn-buscar") : null;
const navSearchZone = typeof document !== "undefined" ? document.getElementById("nav-search-zone") : null;
const utilidades = typeof document !== "undefined" ? document.querySelector(".utilidades") : null;
const inputBuscar = typeof document !== "undefined" ? document.getElementById("buscador-input") : null;
const selectCategoria = typeof document !== "undefined" ? document.getElementById("filtro-categoria") : null;

// Calcula cuánto debe desplazarse la lupa (#btn-buscar)
// desde su posición normal en .utilidades hasta el borde izquierdo del
// buscador. Usa getBoundingClientRect para que el número sea exacto sin
// importar el ancho de pantalla.
function moverLupa(activar) {
  if (!btnBuscar || !navSearchZone) return;

  // En mobile el buscador se abre como panel debajo del header
  if (window.innerWidth <= 640) {
    btnBuscar.style.setProperty("--lupa-x", "0px");
    btnBuscar.style.setProperty("--lupa-y", "0px");
    return;
  }

  if (activar) {
    const rectBoton = btnBuscar.getBoundingClientRect();
    const rectZona = navSearchZone.getBoundingClientRect();


    const destinoX = rectZona.left + 70;
    const destinoY = rectZona.top + rectZona.height / 2;

    const origenX = rectBoton.left + rectBoton.width / 2;
    const origenY = rectBoton.top + rectBoton.height / 2;

    btnBuscar.style.setProperty("--lupa-x", (destinoX - origenX) + "px");
    btnBuscar.style.setProperty("--lupa-y", (destinoY - origenY) + "px");
  } else {
    btnBuscar.style.setProperty("--lupa-x", "0px");
    btnBuscar.style.setProperty("--lupa-y", "0px");
  }
}

function abrirBuscador() {
  if (navSearchZone) navSearchZone.classList.add("modo-busqueda");
  if (utilidades) utilidades.classList.add("modo-busqueda");
  if (btnBuscar) {
    btnBuscar.classList.add("activo");
    btnBuscar.setAttribute("aria-expanded", "true");
    btnBuscar.setAttribute("aria-label", "Cerrar búsqueda");
  }
  moverLupa(true);
  setTimeout(() => inputBuscar && inputBuscar.focus(), 200);
}

function cerrarBuscador() {
  if (navSearchZone) navSearchZone.classList.remove("modo-busqueda");
  if (utilidades) utilidades.classList.remove("modo-busqueda");
  if (btnBuscar) {
    btnBuscar.classList.remove("activo");
    btnBuscar.setAttribute("aria-expanded", "false");
    btnBuscar.setAttribute("aria-label", "Buscar");
  }
  moverLupa(false);
  if (inputBuscar) inputBuscar.value = "";
  if (selectCategoria) selectCategoria.value = "todas";
  aplicarFiltros();
}

if (btnBuscar) {
  btnBuscar.addEventListener("click", () => {
    const estaActivo = btnBuscar.classList.contains("activo");
    estaActivo ? cerrarBuscador() : abrirBuscador();
  });
}

if (typeof document !== "undefined") {
  document.addEventListener("keydown", (evento) => {
    if (evento.key === "Escape" && btnBuscar && btnBuscar.classList.contains("activo")) {
      cerrarBuscador();
    }
  });
}

if (typeof window !== "undefined") {
  window.addEventListener("resize", () => {
    if (btnBuscar && btnBuscar.classList.contains("activo")) {
      moverLupa(true);
    }
  });
}

function aplicarFiltros() {
  const texto = (inputBuscar ? inputBuscar.value : "").trim().toLowerCase();
  const categoria = selectCategoria ? selectCategoria.value : "todas";

  // Reutilizamos la función pura filtrarPorCategoria
  const listaPorCategoria = filtrarPorCategoria(productos, categoria);

  const filtrados = listaPorCategoria.filter(producto => {
    return (
      texto === "" ||
      producto.nombre.toLowerCase().includes(texto) ||
      producto.categoria.toLowerCase().includes(texto)
    );
  });

  mostrarProductos(filtrados);
}

if (inputBuscar) inputBuscar.addEventListener("input", aplicarFiltros);
if (selectCategoria) selectCategoria.addEventListener("change", aplicarFiltros);

/* ==========================================================================
   VALIDACIONES INTERACTIVAS DE FORMULARIOS (Newsletter y Contacto)
   ========================================================================== */

// Validación del formulario de Boletín / Newsletter
const formNewsletter = typeof document !== "undefined" ? document.getElementById("newsletter-form") : null;
const inputNewsletter = typeof document !== "undefined" ? document.getElementById("newsletter-email") : null;

if (formNewsletter && inputNewsletter) {
  formNewsletter.addEventListener("submit", (evento) => {
    evento.preventDefault();
    const email = inputNewsletter.value;

    if (validarEmail(email)) {
      alert(`¡Suscripción exitosa! Hemos enviado un 10% de descuento a: ${email.trim()}`);
      inputNewsletter.value = "";
    } else {
      alert("Por favor ingresa una dirección de correo válida (ej. usuario@dominio.com).");
      inputNewsletter.focus();
    }
  });
}

// Validación del formulario de contacto
const formContacto = typeof document !== "undefined" ? document.querySelector("main form") : null;
if (formContacto) {
  formContacto.addEventListener("submit", (evento) => {
    evento.preventDefault();

    const inputNombre = document.getElementById("nombre");
    const inputEmail = document.getElementById("email");
    const inputMensaje = document.getElementById("mensaje");

    const nombreValido = inputNombre ? validarTexto(inputNombre.value, 3) : true;
    const emailValido = inputEmail ? validarEmail(inputEmail.value) : true;
    const mensajeValido = inputMensaje ? validarTexto(inputMensaje.value, 5) : true;

    if (!nombreValido) {
      alert("El nombre debe tener al menos 3 caracteres y contener caracteres válidos.");
      inputNombre && inputNombre.focus();
      return;
    }

    if (!emailValido) {
      alert("Por favor ingresa un correo electrónico con formato válido.");
      inputEmail && inputEmail.focus();
      return;
    }

    if (!mensajeValido) {
      alert("Por favor ingresa un mensaje de al menos 5 caracteres.");
      inputMensaje && inputMensaje.focus();
      return;
    }

    alert("¡Mensaje enviado con éxito! Nos pondremos en contacto contigo a la brevedad.");
    formContacto.reset();
  });
}