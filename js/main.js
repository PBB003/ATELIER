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