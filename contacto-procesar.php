<?php

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contacto.php");
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$asunto = trim($_POST["asunto"] ?? "");
$canal = trim($_POST["canal"] ?? "email");
$mensaje = trim($_POST["mensaje"] ?? "");
$boletin = isset($_POST["boletin"]) ? 1 : 0;

$asuntosPermitidos = ["pedido", "tallas", "devolucion", "otro"];
$canalesPermitidos = ["email", "telefono", "whatsapp"];

$esValido = true;

if ($nombre === "" || mb_strlen($nombre) < 3) {
    $esValido = false;
}

if ($email === "" || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $esValido = false;
}

if (!in_array($asunto, $asuntosPermitidos, true)) {
    $esValido = false;
}

if ($mensaje === "" || mb_strlen($mensaje) < 10) {
    $esValido = false;
}

if ($telefono !== "" && !ctype_digit($telefono)) {
    $esValido = false;
}

if (!in_array($canal, $canalesPermitidos, true)) {
    $esValido = false;
}

if (!$esValido) {
    header("Location: contacto.php?error=validacion");
    exit;
}

$telefonoParaGuardar = $telefono === "" ? null : $telefono;

$stmt = $conexion->prepare(
    "INSERT INTO mensajes_contacto
    (nombre, email, telefono, asunto, canal, mensaje, boletin)
    VALUES (?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    error_log("Error al preparar el registro de contacto: " . $conexion->error);
    header("Location: contacto.php?error=db");
    exit;
}

$stmt->bind_param(
    "ssssssi",
    $nombre,
    $email,
    $telefonoParaGuardar,
    $asunto,
    $canal,
    $mensaje,
    $boletin
);

if (!$stmt->execute()) {
    error_log("Error al guardar el mensaje de contacto: " . $stmt->error);
    header("Location: contacto.php?error=db");
    exit;
}

header("Location: contacto.php?ok=1");
exit;
