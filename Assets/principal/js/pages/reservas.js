const frm = document.querySelector("#formulario");
const calendarEl = document.getElementById("calendar");
let calendar;

document.addEventListener("DOMContentLoaded", function () {
  frm.addEventListener("submit", function (e) {
    e.preventDefault();

    const f_llegada = document.querySelector("#f_llegada").value;
    const f_salida = document.querySelector("#f_salida").value;
    const habitacion = document.querySelector("#habitacion").value;

    if (f_llegada === "" || f_salida === "" || habitacion === "") {
      alertaSW("Todos los campos son obligatorios", "warning");
      return;
    }

    const url = base_url + 'reserva/listar/' + f_llegada + '/' + f_salida + '/' + habitacion;

    // Si ya existe un calendario, lo destruimos
    if (calendar) {
      calendar.destroy();
    }

    calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
      },
      locale: "es",
      navLinks: true,
      businessHours: true,
      editable: false,
      selectable: false,
      events: url
    });

    calendar.render();
  });
});
