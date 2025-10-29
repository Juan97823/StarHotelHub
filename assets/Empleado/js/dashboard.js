
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('.table tbody');

    if (tableBody) { // Solo ejecutar si la tabla existe en la página
        tableBody.addEventListener('click', function (e) {
            // Botón Check-In
            if (e.target.matches('.btn-checkin')) {
                e.preventDefault();
                const button = e.target;
                const idReserva = button.getAttribute('data-id');
                realizarCheckIn(idReserva, button);
            }

            // Botón Ver Reserva
            if (e.target.matches('.btn-view-reserva')) {
                e.preventDefault();
                const idReserva = e.target.getAttribute('data-id');
                // Redirigir a la página de reservas (la lógica de filtrado se puede añadir allí)
                window.location.href = RUTA_PRINCIPAL + 'empleado/reservas?reserva=' + idReserva;
            }
        });
    }

    function realizarCheckIn(idReserva, button) {
        // Mostrar confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se marcará la reserva como 'Activa' (Check-In).",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, realizar Check-In',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Llamada AJAX para actualizar el estado
                const url = `${RUTA_PRINCIPAL}empleado/actualizarEstadoReserva/${idReserva}/Activa`;
                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (res.status) {
                            Swal.fire('¡Check-In Realizado!', res.msg, 'success');
                            // Deshabilitar botón y cambiar texto
                            button.textContent = 'Hecho';
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-secondary', 'disabled');
                            // Opcionalmente, se puede recargar la sección de la tabla para reflejar el cambio
                        } else {
                            Swal.fire('Error', res.msg, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'No se pudo completar la operación.', 'error');
                    });
            }
        });
    }
});
