<?php
require_once "conexion.php";
require_once "auth.php";
requerirAdmin();

if ($_SERVER["REQUEST_METHOD"] !== "POST"
    || !validarTokenCSRF($_POST["csrf_token"] ?? null)) {
    header("Location: productos.php?error=csrf");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

if ($id > 0) {
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: productos.php?ok=1");
exit;
