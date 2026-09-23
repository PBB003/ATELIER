<?php
/**
 * header.php — encabezado compartido de las páginas PHP internas
 * (login, mi-cuenta, productos, producto-form).
 *
 * Antes de incluir este archivo, la página puede definir $titulo_pagina.
 * Este archivo llama a session_start() si todavía no se había llamado,
 * así que es seguro incluirlo como primera línea de output de la página.
 */
require_once "auth.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($titulo_pagina) ? htmlspecialchars($titulo_pagina) . " — ATELIER" : "ATELIER"; ?></title>
  <link rel="icon" href="data:,">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="site-header">
  <div class="contenedor">
    <a href="index.php">
      <img src="img/logo.png" alt="ATELIER" style="width: 42px; height: auto;">
    </a>
    <a href="index.php" id="logo">TELIER</a>

    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="nav-toggle-label" aria-label="Abrir menú">
      <span></span><span></span><span></span>
    </label>

    <div class="nav-search-zone" id="nav-search-zone">
      <nav class="main-nav" aria-label="Navegación principal">
        <ul>
          <li><a href="index.php#coleccion">Mujer</a></li>
          <li><a href="index.php#coleccion">Hombre</a></li>
          <li><a href="index.php#coleccion">Niños</a></li>
          <li><a href="sobre-nosotros.html">Nosotros</a></li>
          <li><a href="contacto.php">Contacto</a></li>
          <?php if (isset($_SESSION["usuario_id"])): ?>
            <li><a href="productos.php">Productos</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>

    <div class="utilidades">
      <?php if (isset($_SESSION["usuario_id"])): ?>
        <span style="font-family:var(--font-mono); font-size:.78rem; color:var(--ink-soft);">
          Hola, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?>
        </span>
        <a href="logout.php" class="btn btn-secundario" style="padding:8px 16px; min-height:auto;">Cerrar sesión</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-primario" style="padding:8px 16px; min-height:auto;">Iniciar sesión</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main>
