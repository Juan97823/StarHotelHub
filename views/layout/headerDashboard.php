<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | StarHotelHub</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= RUTA_PRINCIPAL ?>assets/css/dashboard.css">
</head>
<body>

<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <nav id="sidebar" class="bg-dark border-end">
    <div class="sidebar-header text-center py-4 text-white border-bottom">
      <h4><i class="fas fa-hotel me-2"></i>Admin</h4>
    </div>
    <ul class="list-unstyled ps-3">
      <li><a href="<?= RUTA_PRINCIPAL ?>admin/dashboard" class="text-white d-block py-2"><i class="fas fa-chart-line me-2"></i>Dashboard</a></li>
      <li><a href="#" class="text-white d-block py-2"><i class="fas fa-bed me-2"></i>Habitaciones</a></li>
      <li><a href="#" class="text-white d-block py-2"><i class="fas fa-users me-2"></i>Clientes</a></li>
      <li><a href="#" class="text-white d-block py-2"><i class="fas fa-calendar-check me-2"></i>Reservas</a></li>
      <li><a href="<?= RUTA_PRINCIPAL ?>logout" class="text-white d-block py-2"><i class="fas fa-sign-out-alt me-2"></i>Salir</a></li>
    </ul>
  </nav>

  <!-- Contenido principal -->
  <div id="page-content-wrapper" class="w-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom px-3 shadow-sm">
      <button class="btn btn-outline-dark" id="menu-toggle"><i class="fas fa-bars"></i></button>
      <div class="ms-auto fw-semibold">
        Bienvenido, <?= $_SESSION['nombre'] ?? 'Administrador' ?>
      </div>
    </nav>

    <div class="container-fluid mt-4">
