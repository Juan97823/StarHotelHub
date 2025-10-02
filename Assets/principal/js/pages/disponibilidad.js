const f_llegada = document.querySelector("#f_llegada");
const f_salida = document.querySelector("#f_salida");
const habitacion = document.querySelector("#habitacion");
const frm = document.querySelector("#formulario");

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");

    const calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth" },
        initialView: "dayGridMonth",
        locale: "es",
        navLinks: true,
        businessHours: true,
        editable: false,
        selectable: true,
        events: async function(info, successCallback, failureCallback) {
            try {
                const llegada = f_llegada.value || "";
                const salida = f_salida.value || "";
                const hab = habitacion.value || "";
                const response = await fetch(`${base_url}reserva/listar/${llegada}/${salida}/${hab}`);
                const data = await response.json();

                // Mapeamos los eventos para FullCalendar
                const eventos = data.map(ev => ({
                    id: ev.id,
                    title: ev.title,
                    start: ev.start,
                    end: ev.end,
                    color: ev.color
                }));

                successCallback(eventos);
            } catch (error) {
                console.error("Error al cargar eventos:", error);
                failureCallback(error);
            }
        }
    });

    calendar.render();

    // Actualizar calendario al cambiar fechas o habitación
    [f_llegada, f_salida, habitacion].forEach(input => {
        input.addEventListener("change", () => {
            calendar.refetchEvents(); // recarga los eventos correctamente
        });
    });

    // VALIDAR CAMPOS AL ENVIAR FORMULARIO
    frm.addEventListener("submit", function (e) {
        e.preventDefault();
        if (
            frm.nombre.value.trim() === "" ||
            frm.correo.value.trim() === "" ||
            frm.f_llegada.value.trim() === "" ||
            frm.f_salida.value.trim() === "" ||
            frm.habitacion.value.trim() === ""
        ) {
            alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
        } else {
            this.submit();
        }
    });
});
