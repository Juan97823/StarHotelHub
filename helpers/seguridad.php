<?php
function verificarSesion($rolEsperado)
{
    session_start();
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== $rolEsperado) {
        header('Location: ' . RUTA_PRINCIPAL . 'login');
        exit;
    }
}
