document.addEventListener("DOMContentLoaded", function () {
  const f_llegada = document.querySelector("#f_llegada");
  const f_salida = document.querySelector("#f_salida");
  const habitacion = document.querySelector("#habitacion");
  const calendarEl = document.getElementById("calendar");
  const frm = document.querySelector("#formulario");
  const totalReserva = document.getElementById("totalReserva");
  const disponibilidadLabel = document.getElementById("disponibilidad");

  const precios = {};
  if (habitacion) {
    Array.from(habitacion.options).forEach((opt) => {
      if (opt.value) precios[opt.value] = parseFloat(opt.dataset.precio || 0);
    });
  }

  // --- FUNCION DE CÁLCULO DEL TOTAL ---
  function calcularTotal() {
    if (!f_llegada.value || !f_salida.value || !habitacion.value) {
      totalReserva.value = "$0";
      return;
    }

    const llegadaDate = new Date(f_llegada.value);
    const salidaDate = new Date(f_salida.value);
    const diffTime = salidaDate - llegadaDate;
    const noches = diffTime / (1000 * 60 * 60 * 24);
    const precio = precios[habitacion.value] || 0;

    if (noches <= 0) {
      totalReserva.value = "$0";
      return;
    }

    const total = noches * precio;
    totalReserva.value = `$${total.toLocaleString("es-CO")}`;
  }

  // --- FUNCION DE DISPONIBILIDAD ---
  async function verificarDisponibilidad() {
    if (!f_llegada.value || !f_salida.value || !habitacion.value) return;

    const formData = new FormData();
    formData.append("f_llegada", f_llegada.value);
    formData.append("f_salida", f_salida.value);
    formData.append("habitacion", habitacion.value);

    try {
      const response = await fetch(`${base_url}reserva/verificar`, {
        method: "POST",
        body: formData,
      });
      const data = await response.json();

      if (data.disponible) {
        disponibilidadLabel.textContent = "✅ Disponible";
        disponibilidadLabel.style.color = "green";
      } else {
        disponibilidadLabel.textContent = "❌ No disponible";
        disponibilidadLabel.style.color = "red";
      }
    } catch (error) {
      console.error("Error al verificar disponibilidad:", error);
    }
  }

  // --- EVENTOS DE CAMBIO ---
  if (f_llegada && f_salida && habitacion) {
    [f_llegada, f_salida, habitacion].forEach((input) => {
      input.addEventListener("change", () => {
        calcularTotal();
        verificarDisponibilidad();

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

  // --- FULLCALENDAR ---
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
      if (cellDate < today) info.el.classList.add("disabled-date");
    },
  });

  calendar.render();

  // --- SUBMIT FORMULARIO ---
  if (frm) {
    frm.addEventListener("submit", async function (e) {
      e.preventDefault();

      if (
        frm.nombre.value.trim() === "" ||
        frm.correo.value.trim() === "" ||
        frm.f_llegada.value.trim() === "" ||
        frm.f_salida.value.trim() === "" ||
        frm.habitacion.value.trim() === ""
      ) {
        alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
        return;
      }

      const formData = new FormData(frm);

      try {
        const response = await fetch(`${base_url}reserva/guardarPublica`, {
          method: "POST",
          body: formData,
        });

        const data = await response.json();

        if (data.status === "success") {
  alertaSW(data.msg, "success");

  setTimeout(() => {
    // Redirige correctamente al controlador de pago
    window.location.href = `${base_url}pago?id=${data.id_reserva}`;
  }, 1500);

        } else {
          alertaSW(data.msg || "Error al registrar la reserva", "error");
        }
      } catch (error) {
        console.error("Error al registrar la reserva:", error);
        alertaSW("Error en el servidor. Intenta nuevamente.", "error");
      }
    });
  }

  // --- Calcular total al cargar la página ---
  window.addEventListener("load", calcularTotal);
});
