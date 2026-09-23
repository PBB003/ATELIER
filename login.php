<?php
require_once "conexion.php";
require_once "auth.php";

// Si ya inició sesión, no tiene sentido mostrarle el formulario de nuevo
if (isset($_SESSION["usuario_id"])) {
    header("Location: mi-cuenta.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Completa correo y contraseña.";
    } else {
        $stmt = $conexion->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario = $resultado->fetch_assoc()) {
            if (password_verify($password, $usuario["password"])) {
                // Credenciales correctas: se guarda el usuario en la sesión
                $_SESSION["usuario_id"]     = $usuario["id"];
                $_SESSION["usuario_nombre"] = $usuario["nombre"];
                $_SESSION["usuario_rol"]    = $usuario["rol"];
                header("Location: mi-cuenta.php");
                exit;
            }
        }
        $error = "Correo o contraseña incorrectos.";
    }
}

$titulo_pagina = "Iniciar sesión";
include "header.php";
?>

<section>
  <div class="contenedor" style="max-width:440px; padding-top:56px; padding-bottom:56px;">
    <p class="hero-eyebrow" style="color:var(--accent-2); letter-spacing:.14em;">Bienvenido de nuevo</p>
    <h1 style="margin-bottom:24px;">Inicia sesión</h1>

    <?php if ($error): ?>
      <p class="error-msg" style="margin-bottom:16px;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="campo">
        <label for="email">Correo electrónico *</label>
        <input type="email" id="email" name="email" required placeholder="tu@correo.com" style="border-radius:8px;">
      </div>
      <div class="campo">
        <label for="password">Contraseña *</label>
        <input type="password" id="password" name="password" required style="border-radius:8px;">
      </div>
      <button type="submit" class="btn btn-primario" style="border-radius:20px; padding:10px 28px;">Entrar</button>
    </form>

  </div>
</section>

<?php include "footer.php"; ?>
