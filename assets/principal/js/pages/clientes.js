document.addEventListener('DOMContentLoaded', function() {
    const M_RUTA = base_url; // Usa la ruta base global

    // Delegación de eventos para los botones de cancelar
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.btn-cancelar')) {
            e.preventDefault();
            const botonCancelar = e.target.closest('.btn-cancelar');
            const idReserva = botonCancelar.dataset.id;
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelarReserva(idReserva);
                }
            });
        }
    });

    async function cancelarReserva(id) {
        try {
            const url = `${M_RUTA}cliente/cancelar/${id}`;
            const response = await fetch(url, { method: 'POST' });
            const res = await response.json();

            if (res.estado) {
                Swal.fire(
                    '¡Cancelada!',
                    res.msg,
                    'success'
                ).then(() => {
                    window.location.reload(); // Recargar la página para ver los cambios
                });
            } else {
                Swal.fire(
                    'Error',
                    res.msg,
                    'error'
                );
            }
        } catch (error) {
            console.error('Error al cancelar:', error);
            Swal.fire(
                'Error de Conexión',
                'No se pudo comunicar con el servidor.',
                'error'
            );
        }
    }
});
