<?php
// Script de verificación de requisitos del servidor local - ATELIER
$extensiones_requeridas = [
    'mysqli'     => 'Conexión básica a MySQL',
    'pdo_mysql'  => 'Conexión mediante PDO (usada en conexion.php)',
    'curl'       => 'Peticiones HTTP',
    'mbstring'   => 'Manejo de cadenas de texto multicapa'
];

echo "<h2>Verificación de Requisitos del Servidor Local - ATELIER</h2>";
echo "<ul>";

foreach ($extensiones_requeridas as $ext => $descripcion) {
    if (extension_loaded($ext)) {
        echo "<li style='color: green;'>✓ Extensión <strong>$ext</strong> ($descripcion) está cargada correctamente.</li>";
    } else {
        echo "<li style='color: red;'>✗ Extensión <strong>$ext</strong> ($descripcion) NO está activa. Revisa php.ini.</li>";
    }
}

echo "</ul>";

echo "<h3>Detalles del Entorno:</h3>";
echo "<p><strong>Versión de PHP:</strong> " . phpversion() . "</p>";
echo "<p><strong>Servidor Web:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Ejecución por CLI') . "</p>";
?>