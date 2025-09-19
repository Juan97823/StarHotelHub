const f_llegada = document.querySelector("#f_llegada");
const f_salida = document.querySelector("#f_salida");
const habitacion = document.querySelector("#habitacion");
const frm = document.querySelector("#formulario");

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");

    // Inicializar calendario
    const calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth"
        },
        initialView: "dayGridMonth",
        locale: "es",
        navLinks: true,
        businessHours: true,
        editable: false,
        selectable: true,
        events: fetchEvents() // carga inicial
    });

    calendar.render();

    // Actualizar calendario al cambiar fechas o habitación
    [f_llegada, f_salida, habitacion].forEach((input) => {
        input.addEventListener("change", () => {
            calendar.removeAllEvents();
            calendar.addEventSource(fetchEvents());
        });
    });

    // Función para obtener eventos
    function fetchEvents() {
        const llegada = f_llegada.value || "";
        const salida = f_salida.value || "";
        const hab = habitacion.value || "";
        return base_url + "reserva/listar/" + llegada + "/" + salida + "/" + hab;
    }

    // VALIDAR CAMPOS AL ENVIAR FORMULARIO
    frm.addEventListener("submit", function (e) {
        e.preventDefault();
        if (
            frm.nombre.value == "" ||
            frm.correo.value == "" ||
            frm.f_llegada.value == "" ||
            frm.f_salida.value == "" ||
            frm.habitacion.value == ""
        ) {
            alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
        } else {
            this.submit();
        }
    });
});
