document.addEventListener("DOMContentLoaded", function () {
  const f_llegada = document.querySelector("#f_llegada");
  const f_salida = document.querySelector("#f_salida");
  const habitacion = document.querySelector("#habitacion");
  const calendarEl = document.getElementById("calendar");
  const frm = document.querySelector("#formulario");
  const totalReserva = document.getElementById("totalReserva");

  const precios = {};
  if (habitacion) {
    Array.from(habitacion.options).forEach((opt) => {
      if (opt.value) precios[opt.value] = parseFloat(opt.dataset.precio || 0);
    });
  }

  function calcularTotal() {
    if (!f_llegada.value || !f_salida.value || !habitacion.value) {
      if (totalReserva) totalReserva.value = "$0";
      return;
    }
    const llegadaDate = new Date(f_llegada.value);
    const salidaDate = new Date(f_salida.value);
    let noches = (salidaDate - llegadaDate) / (1000 * 60 * 60 * 24);
    if (noches < 0) noches = 0;
    const precio = precios[habitacion.value] || 0;
    const total = precio * noches;
    if (totalReserva) totalReserva.value = "$" + total.toLocaleString();
  }

  if(f_llegada && f_salida && habitacion) {
    [f_llegada, f_salida, habitacion].forEach((input) =>
      input.addEventListener("change", calcularTotal)
    );
  }

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
    events: async function (info, successCallback, failureCallback) {
      try {
        const response = await fetch(`${base_url}reserva/listar`);
        const data = await response.json();
        const eventos = data.map((ev) => ({
          id: ev.id,
          title: ev.title,
          start: ev.start,
          end: ev.end,
          color: ev.color,
        }));
        successCallback(eventos);
      } catch (error) {
        console.error("Error al cargar eventos:", error);
        failureCallback(error);
      }
    },
    dayCellDidMount: function (info) {
      const cellDate = info.date;
      const today = new Date();
      today.setHours(0, 0, 0, 0);

      // Disable past dates
      if (cellDate < today) {
        info.el.classList.add("disabled-date");
      }
    },
  });

  calendar.render();

  if(f_llegada && f_salida && habitacion) {
    [f_llegada, f_salida, habitacion].forEach((input) => {
      input.addEventListener("change", () => {
        if (f_llegada.value && f_salida.value) {
          const llegadaDate = new Date(f_llegada.value);
          const salidaDate = new Date(f_salida.value);
          if (salidaDate <= llegadaDate) {
            alertaSW(
              "La fecha de salida debe ser posterior a la llegada",
              "warning"
            );
            f_salida.value = "";
            return;
          }
        }
        calendar.refetchEvents();
      });
    });
  }

  if (frm) {
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
  }
});
