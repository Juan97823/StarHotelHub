// Variable para almacenar la instancia de la DataTable
let tblBlog;

document.addEventListener("DOMContentLoaded", function () {
    // Asegurarse de que la RUTA_PRINCIPAL está definida (la definimos en el header-admin.php)
    if (typeof RUTA_PRINCIPAL === 'undefined') {
        console.error("La variable RUTA_PRINCIPAL no está definida. Revisa el header-admin.php");
        return;
    }

    tblBlog = $('#tblBlog').DataTable({
        ajax: {
            // Usar la variable RUTA_PRINCIPAL para construir la URL del AJAX
            url: `${RUTA_PRINCIPAL}admin/blog/listarEntradas`,
            dataSrc: "data" // Especificar que los datos vienen en la propiedad "data" del JSON
        },
        columns: [
            { data: "id" },
            { data: "titulo" },
            { data: "fecha" },
            {
                data: "imagen",
                render: function (data) {
                    // Si no hay imagen, mostrar una por defecto
                    if (!data || data === "undefined" || data === "") {
                        return `<img src="${RUTA_PRINCIPAL}uploads/blog/default.png" 
                            class="img-thumbnail" width="100">`;
                    }
                    return `<img src="${RUTA_PRINCIPAL}uploads/blog/${data}" 
                        class="img-thumbnail" width="100">`;
                }
            },
            {
                data: "estado",
                render: function (data) {
                    return data == 1
                        ? '<span class="badge bg-success">Habilitado</span>'
                        : '<span class="badge bg-danger">Inhabilitado</span>';
                }
            },
            {
                data: null,
                orderable: false, // No permitir ordenar por esta columna
                render: function (data, type, row) {
                    // Botón para cambiar el estado
                    let btnEstado = row.estado == 1
                        ? `<button class="btn btn-warning btn-sm" onclick="cambiarEstado(${row.id}, 0, this)">
                       <i class="fas fa-ban"></i>
                   </button>`
                        : `<button class="btn btn-success btn-sm" onclick="cambiarEstado(${row.id}, 1, this)">
                       <i class="fas fa-check"></i>
                   </button>`;

                    // Botón para editar
                    let btnEditar = `<a href="${RUTA_PRINCIPAL}admin/blog/editar/${row.id}" class="btn btn-info btn-sm">
                               <i class="fas fa-edit"></i>
                             </a>`;

                    return `<div class="d-flex justify-content-center">${btnEstado} ${btnEditar}</div>`;
                }
            }
        ],
        language: {
            url: `${RUTA_PRINCIPAL}assets/admin/js/i18n/es-ES.json`
        }

    });
    function mostrarPreview(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewImg');

        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.classList.add('d-none');
        }
    }

    /**
     * Validación antes de enviar el formulario
     */
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.querySelector("form");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            const titulo = document.getElementById("titulo").value.trim();
            const contenido = document.getElementById("contenido").value.trim(); {
                e.preventDefault(); // detener envío

                Swal.fire({
                    icon: 'warning',
                    title: 'Formulario incompleto',
                    text: 'Por favor revisa que todos los campos obligatorios estén correctos.',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    });
});
//  Vista previa dinámica de nueva imagen
function mostrarPreview(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImg');

    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        preview.classList.add('d-none');
    }
}

//  Confirmación antes de enviar el formulario
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formBlog");
    if (!form) return;

    // Bootstrap validación + SweetAlert
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizará la entrada del blog.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

/**
 * Cambia el estado de una entrada del blog (habilitado/inhabilitado) mediante AJAX.
 * @param {number} id - El ID de la entrada.
 * @param {number} nuevoEstado - El nuevo estado (0 para inhabilitado, 1 para habilitado).
 * @param {HTMLElement} boton - El botón que activó la función.
 */
function cambiarEstado(id, nuevoEstado, boton) {
    // Deshabilitar el botón para evitar clics múltiples
    boton.disabled = true;

    fetch(`${RUTA_PRINCIPAL}admin/blog/estado/${id}/${nuevoEstado}`, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(res => {
            if (!res.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return res.json();
        })
        .then(data => {
            if (data.status === "success") {
                // Recargar la tabla para mostrar el nuevo estado, sin resetear la paginación
                tblBlog.ajax.reload(null, false);
                // Opcional: Mostrar una notificación de éxito con SweetAlert2
                Swal.fire('¡Éxito!', data.mensaje, 'success');
            } else {
                // Mostrar una alerta de error si la operación falló
                Swal.fire('Error', data.mensaje, 'error');
            }
        })
        .catch(err => {
            console.error("Error en la petición fetch:", err);
            Swal.fire('Error de Conexión', 'No se pudo comunicar con el servidor.', 'error');
        })
        .finally(() => {
            // Volver a habilitar el botón después de que la operación termine
            if (boton) {
                boton.disabled = false;
            }
        });
}
