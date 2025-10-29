document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector("#formulario");
    const fLlegada = document.querySelector("#f_llegada");
    const fSalida = document.querySelector("#f_salida");
    const habitacion = document.querySelector("#habitacion");
    const btnComprobar = formulario?.querySelector("button[type='submit']");

    if (!formulario || !fLlegada || !fSalida || !habitacion) return;

    // Establecer fecha mínima de llegada como hoy
    const hoy = new Date();
    const fechaHoy = hoy.toISOString().split('T')[0];
    fLlegada.setAttribute('min', fechaHoy);

    // Validar cambios en las fechas
    function validarFechas() {
        if (!fLlegada.value || !fSalida.value) return;

        const llegada = new Date(fLlegada.value);
        const salida = new Date(fSalida.value);

        // Validar que salida sea posterior a llegada
        if (salida <= llegada) {
            fSalida.value = '';
            alertaSW("La fecha de salida debe ser posterior a la llegada", "warning");
            return false;
        }

        // Actualizar fecha mínima de salida
        const mañana = new Date(llegada);
        mañana.setDate(mañana.getDate() + 1);
        const fechaMañana = mañana.toISOString().split('T')[0];
        fSalida.setAttribute('min', fechaMañana);

        return true;
    }

    // Validar disponibilidad
    async function verificarDisponibilidad() {
        if (!fLlegada.value || !fSalida.value || !habitacion.value) {
            return;
        }

        if (!validarFechas()) {
            return;
        }

        try {
            const formData = new FormData();
            formData.append('f_llegada', fLlegada.value);
            formData.append('f_salida', fSalida.value);
            formData.append('habitacion', habitacion.value);

            const response = await fetch(base_url + 'reserva/verificar', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.disponible) {
                btnComprobar.disabled = false;
                btnComprobar.style.opacity = '1';
                btnComprobar.style.cursor = 'pointer';
            } else {
                btnComprobar.disabled = true;
                btnComprobar.style.opacity = '0.5';
                btnComprobar.style.cursor = 'not-allowed';
                alertaSW("Habitación no disponible para estas fechas", "error");
            }
        } catch (error) {
            console.error('Error al verificar disponibilidad:', error);
            btnComprobar.disabled = true;
            alertaSW("Error al verificar disponibilidad", "error");
        }
    }

    // Eventos
    fLlegada.addEventListener('change', function () {
        validarFechas();
        verificarDisponibilidad();
    });

    fSalida.addEventListener('change', function () {
        validarFechas();
        verificarDisponibilidad();
    });

    habitacion.addEventListener('change', function () {
        verificarDisponibilidad();
    });

    // Validar al enviar el formulario
    formulario.addEventListener('submit', function (e) {
        if (!fLlegada.value || !fSalida.value || !habitacion.value) {
            e.preventDefault();
            alertaSW("Todos los campos son requeridos", "warning");
            return;
        }

        if (!validarFechas()) {
            e.preventDefault();
            return;
        }

        if (btnComprobar.disabled) {
            e.preventDefault();
            alertaSW("Habitación no disponible para estas fechas", "error");
            return;
        }
    });

    // Verificar disponibilidad inicial
    verificarDisponibilidad();
});

