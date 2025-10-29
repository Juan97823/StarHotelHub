<?php
// Script de prueba para verificar la redirección de reservas
require_once 'config/config.php';
require_once 'config/app/Autoload.php';

// Simular una reserva exitosa
$_SESSION['ultima_reserva'] = 999; // ID de prueba

// Verificar que la sesión se guardó
echo "Sesión guardada: " . ($_SESSION['ultima_reserva'] ?? 'NO') . "<br>";

// Verificar la URL de redirección
$redirectUrl = RUTA_PRINCIPAL . 'reserva/confirmacion';
echo "URL de redirección: " . $redirectUrl . "<br>";

// Verificar que RUTA_PRINCIPAL está definida
echo "RUTA_PRINCIPAL: " . RUTA_PRINCIPAL . "<br>";

// Simular respuesta JSON
$response = [
    'status' => 'success',
    'msg' => 'Reserva realizada con éxito',
    'redirect' => $redirectUrl,
    'id_reserva' => 999
];

echo "<br>Respuesta JSON:<br>";
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

echo "<br><br><a href='" . $redirectUrl . "'>Ir a confirmación manualmente</a>";
?>

