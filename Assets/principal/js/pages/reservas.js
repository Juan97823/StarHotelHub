const f_llegada = document.querySelector("#f_llegada");
const f_salida = document.querySelector("#f_salida");
const habitacion = document.querySelector("#habitacion");

document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");

  const calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth",
    },
    initialView: "dayGridMonth",
    locale: "es",
    navLinks: true,
    businessHours: true,
    editable: false,
    selectable: true,
    events: fetchEvents(), // carga inicial
  });

  calendar.render();

  // Actualizar calendario cuando cambie alguna fecha o habitación
  [f_llegada, f_salida, habitacion].forEach((input) => {
    input.addEventListener("change", () => {
      calendar.removeAllEvents();
      calendar.addEventSource(fetchEvents());
    });
  });

  function fetchEvents() {
    return base_url + "reserva/listar/" + f_llegada.value + "/" + f_salida.value + "/" + habitacion.value;
  }
});
