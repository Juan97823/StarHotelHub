<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">User Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo RUTA_ADMIN . 'dashboard'; ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i>All Users</h5>
            <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add User</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="usuariosTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
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
                                    $badge_class = '';
                                    if ($rol == 'Administrador') { $badge_class = 'bg-success'; }
                                    elseif ($rol == 'Empleado') { $badge_class = 'bg-info'; }
                                    else { $badge_class = 'bg-secondary'; }
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo $rol; ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>