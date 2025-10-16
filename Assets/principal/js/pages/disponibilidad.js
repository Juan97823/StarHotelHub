document.addEventListener("DOMContentLoaded", function () {
    const f_llegada_disponibilidad = document.querySelector("#f_llegada_disponibilidad");
    const f_salida_disponibilidad = document.querySelector("#f_salida_disponibilidad");
    const habitacion_disponibilidad = document.querySelector("#habitacion_disponibilidad");
    const btnVerificar = document.querySelector("#btnVerificar");

    if (btnVerificar) {
        btnVerificar.addEventListener("click", function () {
            if (f_llegada_disponibilidad.value === '' || f_salida_disponibilidad.value === '' || habitacion_disponibilidad.value === '') {
                alertaSW("Todos los campos son requeridos", "warning");
            } else {
                const url = `${base_url}reserva/verify?f_llegada=${f_llegada_disponibilidad.value}&f_salida=${f_salida_disponibilidad.value}&habitacion=${habitacion_disponibilidad.value}`;
                window.location.href = url;
            }
        });
    }

    // --- LOGICA PARA LA PÁGINA DE RESERVA DETALLADA (CON CALENDARIO) ---
    const calendarEl = document.getElementById("calendar");

    if (calendarEl) {
        const f_llegada_reserva = document.querySelector("#f_llegada");
        const f_salida_reserva = document.querySelector("#f_salida");
        const habitacion_reserva = document.querySelector("#habitacion");
        const frm_reserva = document.querySelector("#formulario");

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
                    const llegada = f_llegada_reserva?.value || "";
                    const salida = f_salida_reserva?.value || "";
                    const hab = habitacion_reserva?.value || "";
                    const response = await fetch(`${base_url}reserva/listar/${llegada}/${salida}/${hab}`);
                    const data = await response.json();

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

        [f_llegada_reserva, f_salida_reserva, habitacion_reserva].forEach(input => {
            input?.addEventListener("change", () => {
                calendar.refetchEvents();
            });
        });

        frm_reserva?.addEventListener("submit", function (e) {
            e.preventDefault();
            if (
                !frm_reserva.nombre?.value.trim() ||
                !frm_reserva.correo?.value.trim() ||
                !frm_reserva.f_llegada?.value.trim() ||
                !frm_reserva.f_salida?.value.trim() ||
                !frm_reserva.habitacion?.value.trim()
            ) {
                alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
            } else {
                this.submit();
            }
        });
    }
});
