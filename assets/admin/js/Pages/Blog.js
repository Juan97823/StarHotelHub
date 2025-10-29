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
                data: "estado",
                render: function (data) {
                    return data == 1
                        ? '<span class="badge bg-success">Habilitado</span>'
                        : '<span class="badge bg-danger">Inhabilitado</span>';
                }
            },
            {
                data: "id",
                render: function (data, type, row) {
                    let btnEditar = `<a href="blog/editar/${row.id}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>`;

                    let btnEstado = row.estado == 1
                        ? `<button class="btn btn-warning btn-sm" onclick="handleStateChange(${row.id}, this)">
                            <i class="fas fa-ban"></i>
                        </button>`
                        : `<button class="btn btn-success btn-sm" onclick="handleStateChange(${row.id}, this)">
                            <i class="fas fa-check"></i>
                        </button>`;

                    return `${btnEditar} ${btnEstado}`;
                }
            }
        ],
        language: {
            url: `${RUTA_PRINCIPAL}assets/admin/js/i18n/es-ES.json`
        }

    });
});

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
function handleStateChange(id, btn) {
    const row = $(btn).closest("tr");
    const estadoActual = row.find("td:eq(3)").text().trim();
    const nuevoEstado = estadoActual === "Habilitado" ? 0 : 1;

    // Guardar contenido original del botón
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch(`${RUTA_PRINCIPAL}admin/blog/estado/${id},${nuevoEstado}`, { method: "GET" })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                // Actualizar badge en la tabla
                let badgeHtml = nuevoEstado === 1
                    ? '<span class="badge bg-success">Habilitado</span>'
                    : '<span class="badge bg-danger">Inhabilitado</span>';
                row.find("td:eq(3)").html(badgeHtml);

                // Cambiar el botón según nuevo estado
                btn.className = nuevoEstado === 1
                    ? "btn btn-warning btn-sm"
                    : "btn btn-success btn-sm";
                btn.innerHTML = nuevoEstado === 1
                    ? '<i class="fas fa-ban"></i>'
                    : '<i class="fas fa-check"></i>';
            } else {
                btn.innerHTML = originalHtml;
                Swal.fire("Error", data.mensaje, "error");
            }
        })
        .catch((err) => {
            console.error("Error:", err);
            Swal.fire("Error", "No se pudo cambiar el estado", "error");
            btn.innerHTML = originalHtml;
        });
}

