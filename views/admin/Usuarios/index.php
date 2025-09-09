<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo RUTA_ADMIN . 'dashboard'; ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i>Lista de Usuarios</h5>
            <button id="btnAgregarUsuario" class="btn btn-primary" type="button">
                <i class="fas fa-plus me-2"></i>Agregar Usuario
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="usuariosTable" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['usuarios'] as $usuario) : ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo $usuario['nombre']; ?></td>
                                <td><?php echo $usuario['correo']; ?></td>
                                <td>
                                    <?php
                                    $rol = $usuario['rol'];
                                    $badge_class = ($rol == 'Administrador') ? 'bg-success' : (($rol == 'Empleado') ? 'bg-info' : 'bg-secondary');
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo $rol; ?></span>
                                </td>
                                <td>
                                    <?php
                                    $estado = $usuario['estado'] == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                                    echo $estado;
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary btnVer">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary btnEditar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if ($usuario['estado'] == 1) : ?>
                                        <button class="btn btn-sm btn-outline-danger btnInhabilitar" data-id="<?php echo $usuario['id']; ?>">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-outline-success btnHabilitar" data-id="<?php echo $usuario['id']; ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agregar/Editar Usuario -->
<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="usuarioForm">
                <div class="modal-body">
                    <input type="hidden" id="idUsuario" name="idUsuario">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave">
                        <small class="form-text text-muted">Dejar en blanco para no cambiar la contraseña.</small>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="Cliente">Cliente</option>
                            <option value="Empleado">Empleado</option>
                            <option value="Administrador">Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Enlazar el JS externo -->
<script src="<?php echo RUTA_PRINCIPAL; ?>Assets/admin/js/Pages/Usuarios.js"></script>

<?php include_once 'views/template/footer-admin.php'; ?>
