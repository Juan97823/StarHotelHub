document.addEventListener("DOMContentLoaded", function () {
    // 1. Inicialización de DataTables
    const table = new DataTable("#usuariosTable", {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        responsive: true,
        columnDefs: [
            { "targets": 0, "visible": false } // Ocultar columna ID
        ]
    });

    // 2. Referencias a elementos del DOM
    const btnAgregar = document.getElementById("btnAgregarUsuario");
    const modalElement = document.getElementById("usuarioModal");
    const modal = new bootstrap.Modal(modalElement);
    const modalLabel = document.getElementById("modalLabel");
    const form = document.getElementById("usuarioForm");
    const idField = document.getElementById("idUsuario");
    const claveField = document.getElementById("clave");

    // 3. Abrir modal para agregar usuario
    if (btnAgregar) {
        btnAgregar.addEventListener("click", () => {
            modalLabel.textContent = "Agregar Usuario";
            form.reset();
            idField.value = '';
            claveField.setAttribute('required', 'true');
            modal.show();
        });
    }

    // 4. Manejo del envío del formulario (Agregar/Editar)
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const url = idField.value ? `${base_url}admin/usuarios/editar/${idField.value}` : `${base_url}admin/usuarios/registrar`;
        const formData = new FormData(form);

        fetch(url, { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.tipo === "success") {
                modal.hide();
                Swal.fire('Éxito', data.msg, 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', data.msg, 'error');
            }
        });
    });

    // 5. Delegación de eventos para botones de acción
    document.getElementById("usuariosTable").addEventListener("click", function(e) {
        const btn = e.target.closest("button.btn");
        if (!btn) return;

        const rowNode = btn.closest("tr");
        if (!rowNode || !table.row(rowNode).any()) return;
        
        const row = table.row(rowNode);
        const id = row.data()[0]; // Obtener ID de la data de la fila (columna oculta)

        // Acción para HABILITAR o INHABILITAR
        if (btn.classList.contains("btnInhabilitar") || btn.classList.contains("btnHabilitar")) {
            const esInhabilitar = btn.classList.contains("btnInhabilitar");
            const nuevoEstado = esInhabilitar ? 0 : 1;
            const textoConfirmacion = esInhabilitar ? "El usuario será desactivado." : "El usuario será activado.";
            const botonConfirmacion = esInhabilitar ? "Sí, inhabilitar" : "Sí, habilitar";

            Swal.fire({ title: '¿Estás seguro?', text: textoConfirmacion, icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: botonConfirmacion, cancelButtonText: 'Cancelar' })
            .then(result => {
                if (result.isConfirmed) {
                    fetch(`${base_url}admin/usuarios/cambiarEstado/${id}/${nuevoEstado}`, { method: "GET" })
                    .then(res => res.json())
                    .then(data => {
                        if (data.tipo === "success") {
                            // **SOLUCIÓN DEFINITIVA con API de DataTables**
                            const currentData = row.data(); // Obtener datos actuales de la fila
                            
                            // Modificar la celda de estado (índice 4)
                            currentData[4] = nuevoEstado === 1 
                                ? '<span class="badge bg-success">Activo</span>' 
                                : '<span class="badge bg-danger">Inactivo</span>';

                            // Reconstruir los botones de acción (índice 5)
                            const viewButton = `<button class="btn btn-sm btn-outline-primary btnVer"><i class="fas fa-eye"></i></button>`;
                            const editButton = `<button class="btn btn-sm btn-outline-secondary btnEditar"><i class="fas fa-edit"></i></button>`;
                            const toggleButton = nuevoEstado === 1 
                                ? `<button class="btn btn-sm btn-outline-danger btnInhabilitar" data-id="${id}"><i class="fas fa-ban"></i></button>`
                                : `<button class="btn btn-sm btn-outline-success btnHabilitar" data-id="${id}"><i class="fas fa-check"></i></button>`;
                            currentData[5] = `${viewButton} ${editButton} ${toggleButton}`;
                            
                            // Aplicar los nuevos datos a la fila y redibujar
                            row.data(currentData).draw(false);

                            Swal.fire('Actualizado', data.msg, 'success');
                        } else {
                            Swal.fire('Error', data.msg, 'error');
                        }
                    });
                }
            });
        }

        // Acción para EDITAR
        if (btn.classList.contains("btnEditar")) {
            fetch(`${base_url}admin/usuarios/obtener/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        modalLabel.textContent = "Editar Usuario";
                        idField.value = data.id;
                        document.getElementById('nombre').value = data.nombre;
                        document.getElementById('email').value = data.correo;
                        document.getElementById('rol').value = data.rol;
                        claveField.removeAttribute('required');
                        modal.show();
                    } else {
                        Swal.fire('Error', 'No se encontraron datos', 'error');
                    }
                });
        }
    });
});
