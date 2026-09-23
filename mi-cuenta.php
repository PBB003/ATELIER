<?php
require_once "conexion.php";
require_once "auth.php";

// Página protegida: si no hay sesión activa, se redirige al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$titulo_pagina = "Mi cuenta";
include "header.php";
?>

<section>
  <div class="contenedor" style="padding-top:56px; padding-bottom:56px;">
    <p class="hero-eyebrow" style="color:var(--accent-2); letter-spacing:.14em;">Tu cuenta</p>
    <h1>Hola, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></h1>
    <p style="max-width:520px; line-height:1.7; color:var(--ink-soft);">
      Iniciaste sesión como <strong><?php echo htmlspecialchars($_SESSION["usuario_rol"]); ?></strong>.
      Esta página solo la puede ver alguien que inició sesión correctamente.
    </p>

    <?php if ($_SESSION["usuario_rol"] === "admin"): ?>
      <a href="productos.php" class="btn btn-primario"
         style="border-radius:20px; padding:10px 28px; display:inline-block; margin-top:16px;">
        Gestionar productos
      </a>
    <?php endif; ?>
  </div>
</section>

<?php include "footer.php"; ?>
