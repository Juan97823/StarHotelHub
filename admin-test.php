<?php
session_start();
$_SESSION['rol'] = 'Administrador';
$_SESSION['nombre'] = 'Juan Admin';
$_SESSION['usuario'] = [
    'rol' => 'Administrador',
    'nombre' => 'Juan Admin'
];

echo '✅ Sesión creada como administrador';
?>
