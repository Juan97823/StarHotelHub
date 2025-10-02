(function ($) {
    let table;

    $(document).ready(function () {

        // 1. INICIALIZACIÓN DE DATATABLE
        table = $("#usuariosTable").DataTable({
            language: {
                url: base_url + "assets/admin/js/es-ES.json"
            },
            responsive: true,
            ajax: {
                url: `${base_url}admin/usuarios/listar`,
                dataSrc: 'data'
            },
            columns: [
                { 'data': 'id' },
                { 'data': 'nombre' },
                { 'data': 'correo' }, // <-- ESTANDARIZADO
                { 'data': 'rol' },
                { 'data': 'estado' },
                { 'data': 'acciones', orderable: false, searchable: false }
            ],
            columnDefs: [
                { "targets": 0, "visible": false }
            ]
        });

        const modalElement = document.getElementById("usuarioModal");
        const modal = new bootstrap.Modal(modalElement);

        // 2. MANEJO DE EVENTOS CON DELEGACIÓN
        $("#usuariosTable tbody").on("click", "button", function () {
            const action = $(this).data("action");
            const id = $(this).data("id");

            if (action === "edit") {
                openEditModal(id);
            } else if (action === "toggle-state") {
                handleStateChange(id, this);
            }
        });

        // 3. ABRIR MODAL PARA AGREGAR USUARIO
        $("#btnAgregarUsuario").on("click", function () {
            $("#usuarioForm")[0].reset();
            $("#modalLabel").text("Agregar Usuario");
            $("#idUsuario").val('');
            $("#clave").attr('required', 'true');
            modal.show();
        });

        // 4. GUARDAR (SUBMIT DEL FORMULARIO DE AGREGAR/EDITAR)
        $("#usuarioForm").on("submit", function (e) {
            e.preventDefault();
            const id = $("#idUsuario").val();
            const url = id ? `${base_url}admin/usuarios/editar/${id}` : `${base_url}admin/usuarios/registrar`;

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.tipo === 'success') {
                        modal.hide();
                        Swal.fire('Éxito', response.msg, 'success');
                        table.ajax.reload();
                    } else {
                        Swal.fire('Error', response.msg, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo conectar al servidor 1.', 'error');
                }
            });
        });

        // ----- FUNCIONES AUXILIARES -----

        function openEditModal(id) {
            // Usar .fail() para un mejor manejo de errores de red/servidor
            $.getJSON(`${base_url}admin/usuarios/obtener/${id}`)
                .done(function (data) {
                    if (data.tipo === 'error') {
                        Swal.fire('Error', data.msg, 'error');
                        return;
                    }
                    $("#modalLabel").text("Editar Usuario");
                    $("#idUsuario").val(data.id);
                    $("#nombre").val(data.nombre);
                    $("#correo").val(data.correo); // <-- ESTANDARIZADO
                    $("#rol").val(data.rol);
                    $("#clave").removeAttr('required');
                    modal.show();
                })
                .fail(function () {
                    Swal.fire('Error', 'No se pudo obtener la información del usuario.', 'error');
                });
        }

        function handleStateChange(id, btn) {
            const isDisabling = $(btn).hasClass("btn-danger");
            const newState = isDisabling ? 0 : 1;

            const confirmText = isDisabling ? "inhabilitar" : "habilitar";
            Swal.fire({
                title: `¿Estás seguro?`,
                text: `Se va a ${confirmText} el usuario.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: `Sí, ${confirmText}`,
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    const originalHtml = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                    $.getJSON(`${base_url}admin/usuarios/cambiarEstado/${id}/${newState}`)
                        .done(function (data) {
                            if (data.tipo === 'success') {
                                Swal.fire("Éxito", data.msg, "success");
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire("Error", data.msg, "error");
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            let errorMsg = `
                             Estado: ${textStatus}
                                Error: ${errorThrown}
                                Respuesta del servidor: ${jqXHR.responseText}
                                            `;
                            Swal.fire("Error", errorMsg, "error");


                        })
                        .always(function () {
                            btn.innerHTML = originalHtml;
                            btn.disabled = false;
                        });
                }
            });
        }
    });
})(jQuery);