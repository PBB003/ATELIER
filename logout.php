<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vacía y destruye toda la información de la sesión actual
$_SESSION = [];
session_unset();
session_destroy();

header("Location: login.php");
exit;
