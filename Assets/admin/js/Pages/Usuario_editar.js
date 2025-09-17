function actualizarUsuario(event) {
    event.preventDefault();
    const frm = document.getElementById('frmActualizar');
    const formData = new FormData(frm);
    const url = base_url + "admin/usuarios/actualizar";

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(res => {
        if (res.msg == 'Usuario actualizado con éxito.') {
            Swal.fire(
                '¡Actualizado!',
                res.msg,
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = base_url + 'admin/usuarios';
                }
            });
        } else {
            Swal.fire('Error', res.msg, 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        Swal.fire('Error de Conexión', 'No se pudo conectar con el servidor.', 'error');
    });
}