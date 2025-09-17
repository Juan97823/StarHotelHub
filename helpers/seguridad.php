<?php
function verificarSesion($rolEsperado)
{
    // Se elimina session_start(); porque ya se inicia en config/config.php
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != $rolEsperado) {
        header('Location: ' . RUTA_PRINCIPAL . 'login');
        exit;
    }
}
?>