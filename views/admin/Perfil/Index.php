<?php
// Assuming session is started and user data is available
session_start();

// Example user data (replace with actual data source)
$user = [
    'name' => 'Admin User',
    'correo' => 'admin@starhotelhub.com',
    'role' => 'Administrator',
    'profile_pic' => '/assets/images/admin_profile.png'
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Administrador | StarHotelHub</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; }
        .perfil-container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #ccc; padding: 32px; }
        .perfil-header { display: flex; align-items: center; }
        .perfil-header img { width: 80px; height: 80px; border-radius: 50%; margin-right: 24px; }
        .perfil-header h2 { margin: 0; }
        .perfil-info { margin-top: 24px; }
        .perfil-info p { margin: 8px 0; font-size: 16px; }
        .perfil-actions { margin-top: 32px; }
        .perfil-actions a { text-decoration: none; color: #fff; background: #007bff; padding: 10px 24px; border-radius: 4px; margin-right: 12px; transition: background 0.2s; }
        .perfil-actions a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="perfil-container">
        <div class="perfil-header">
            <img src="<?= htmlspecialchars($user['profile_pic']) ?>" alt="Foto de perfil">
            <div>
                <h2><?= htmlspecialchars($user['name']) ?></h2>
                <span style="color: #888;"><?= htmlspecialchars($user['role']) ?></span>
            </div>
        </div>
        <div class="perfil-info">
            <p><strong>correo:</strong> <?= htmlspecialchars($user['correo']) ?></p>
            <!-- Puedes agregar más información aquí -->
        </div>
        <div class="perfil-actions">
            <a href="/admin/editar_perfil.php">Editar Perfil</a>
            <a href="/admin/cambiar_contrasena.php">Cambiar Contraseña</a>
            <a href="/logout.php" style="background:#dc3545;">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>