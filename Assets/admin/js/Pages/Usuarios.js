document.addEventListener("DOMContentLoaded", function () {
    const tabla = document.getElementById("usuariosTable");

    // Botón agregar
    const btnAgregar = document.getElementById("btnAgregarUsuario");
    if (btnAgregar) {
        btnAgregar.addEventListener("click", () => {
            alert("Abrir modal de registro de usuario");
            // aquí puedes abrir modal o redirigir a formulario
        });
    }

    // Delegación de eventos para botones de acción
    if (tabla) {
        tabla.addEventListener("click", function (e) {
            const btn = e.target.closest("button");
            if (!btn) return;

            const id = btn.dataset.id;

            if (btn.classList.contains("btnVer")) {
                console.log("Ver usuario", id);
                // AJAX para obtener detalle de usuario
            }

            if (btn.classList.contains("btnEditar")) {
                console.log("Editar usuario", id);
                // AJAX para traer datos al formulario de edición
            }

            if (btn.classList.contains("btnInhabilitar")) {
                if (confirm("¿Seguro que quieres inhabilitar este usuario?")) {
                    fetch(RUTA_PRINCIPAL + "usuarios/inhabilitar/" + id, {
                        method: "POST"
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            alert(data.msg);
                            if (data.tipo === "success") {
                                location.reload();
                            }
                        })
                        .catch((err) => console.error("Error:", err));
                }
            }
        });
    }
});
