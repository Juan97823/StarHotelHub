<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title fw-semibold mb-0">Gestión de Blog</h5>
        </div>
        <div class="card-body">
            <a href="<?php echo RUTA_PRINCIPAL; ?>admin/blog/crear" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Nueva Entrada
            </a>

            <?php
            // Manejo de alertas de sesión
            if (isset($_SESSION['alerta'])) {
                $alerta = $_SESSION['alerta'];
                echo '<div class="alert alert-' . htmlspecialchars($alerta['tipo']) . ' alert-dismissible fade show" role="alert">'
                    . htmlspecialchars($alerta['mensaje']) . '
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>';
                unset($_SESSION['alerta']);
            }
            ?>

            <div class="table-responsive">
                <table id="tblBlog" class="table table-bordered table-striped" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- El contenido será cargado dinámicamente por DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>