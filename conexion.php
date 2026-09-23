<?php

$configPath = __DIR__ . DIRECTORY_SEPARATOR . "config.php";

if (!is_file($configPath)) {
    die("No se pudo cargar la configuración de la base de datos.");
}

require_once $configPath;

$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conexion->connect_error) {
    error_log("Error de conexión a la base de datos: " . $conexion->connect_error);
    die("No se pudo conectar a la base de datos. Inténtalo más tarde.");
}

$conexion->set_charset("utf8mb4");