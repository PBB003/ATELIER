<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        "httponly" => true,
        "samesite" => "Lax",
        "secure"   => !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off"
    ]);

    session_start();
}

function requerirAdmin(): void
{
    if (!isset($_SESSION["usuario_id"])) {
        header("Location: login.php");
        exit;
    }

    if (($_SESSION["usuario_rol"] ?? "") !== "admin") {
        header("Location: mi-cuenta.php");
        exit;
    }
}

function generarTokenCSRF(): string
{
    if (empty($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    }

    return $_SESSION["csrf_token"];
}

function validarTokenCSRF(?string $token): bool
{
    return !empty($token)
        && !empty($_SESSION["csrf_token"])
        && hash_equals($_SESSION["csrf_token"], $token);
}
