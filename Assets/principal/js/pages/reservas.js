document.addEventListener("DOMContentLoaded", function () {
  const f_llegada = document.querySelector("#f_llegada");
  const f_salida = document.querySelector("#f_salida");
  const habitacion = document.querySelector("#habitacion");
  const calendarEl = document.getElementById("calendar");

  let calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
    },
    locale: "es",
    events: function (info, successCallback, failureCallback) {
      const llegada = f_llegada.value;
      const salida = f_salida.value;
      const habit = habitacion.value;

      if (llegada && salida && habit) {
        fetch(`${base_url}reserva/listar/${llegada}/${salida}/${habit}`)
          .then(res => res.json())
          .then(data => successCallback(data))
          .catch(err => failureCallback(err));
      } else {
        successCallback([]);
      }
    }
  });

  calendar.render();

  [f_llegada, f_salida, habitacion].forEach(input => {
    input.addEventListener("change", () => {
      calendar.refetchEvents();
    });
  });
});
