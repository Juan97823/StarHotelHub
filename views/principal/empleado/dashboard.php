<?php include_once 'views/template/header-empleado.php'; ?>

<div class="container py-4">
  <h2 class="mb-4">Panel de Empleado</h2>
  <p>Bienvenido, <?php echo $data['nombre_usuario']; ?>.</p>

  <!-- Aquí iría el contenido específico del dashboard del empleado -->

</div>

<script src="<?php echo RUTA_PRINCIPAL; ?>Assets/principal/js/page/inactivity.js"></script>
<?php include_once 'views/template/footer-empleado.php'; ?>