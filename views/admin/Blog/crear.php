<?php require_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $data['title']; ?></h1>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="blogForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descripcion">Contenido</label>
                            <div id="editor" style="height: 300px;"></div>
                            <input type="hidden" name="descripcion" id="descripcion">
                        </div>
                    </div>
                </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Crear Entrada</button>
        </div>
        </form>
    </div>
</div>
</div>

<?php require_once 'views/template/footer-admin.php'; ?>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar Quill
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Sincronizar Quill con el campo oculto
        quill.on('text-change', function () {
            document.getElementById('descripcion').value = quill.root.innerHTML;
        });

        // Enviar formulario
        const form = document.getElementById('blogForm');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validar que la descripción no esté vacía
            if (quill.getLength() <= 1) {
                Swal.fire('Error', 'El contenido no puede estar vacío.', 'error');
                return;
            }

            const url = base_url + 'admin/blog/actualizar';
            const formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        Swal.fire('¡Éxito!', 'Entrada creada correctamente.', 'success').then(() => {
                            window.location.href = base_url + 'admin/blog';
                        });
                    } else {
                        Swal.fire('Error', res.mensaje || 'No se pudo crear la entrada.', 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'No se pudo comunicar con el servidor.', 'error');
                });
        });
    });
</script>