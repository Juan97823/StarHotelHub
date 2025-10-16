<?php require_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $data['title']; ?></h1>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="blogForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descripcion">Descripción</label>
                            <div id="editor" style="height: 300px;"></div>
                            <input type="hidden" name="descripcion" id="descripcion">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="imagen">Imagen Destacada</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*"
                            required>
                    </div>
                    <div class="form-group">
                        <img id="imagen-preview" src="" alt="Vista previa de la imagen" class="img-thumbnail"
                            style="display: none; max-height: 200px;">
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

        // Vista previa de la imagen
        const inputImagen = document.getElementById('imagen');
        const imagenPreview = document.getElementById('imagen-preview');
        inputImagen.addEventListener('change', function (e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    imagenPreview.src = event.target.result;
                    imagenPreview.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Enviar formulario
        const form = document.getElementById('blogForm');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Asegurarse de que la descripción no esté vacía
            if (quill.getLength() <= 1) {
                Swal.fire('Error', 'La descripción no puede estar vacía.', 'error');
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
                    console.error('Error en la solicitud:', err);
                    Swal.fire('Error', 'No se pudo comunicar con el servidor.', 'error');
                });
        });
    });
</script>