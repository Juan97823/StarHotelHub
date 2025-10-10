document.addEventListener("DOMContentLoaded", function () {
  // --- LOGICA PARA LA PÁGINA DE RESERVA DETALLADA (CON CALENDARIO) ---
  const calendarEl = document.getElementById("calendar");

  // Solo ejecutar el script si el calendario existe en la página.
  if (calendarEl) {
    const f_llegada = document.querySelector("#f_llegada");
    const f_salida = document.querySelector("#f_salida");
    const habitacionSelect = document.querySelector("#habitacion");
    const frm = document.querySelector("#formulario");
    const totalReserva = document.getElementById("totalReserva");
    const disponibilidadMensaje = document.getElementById("disponibilidad-mensaje");
    const btnSubmit = frm.querySelector('button[type="submit"]');
    let isSubmitting = false;
    const precios = {};

    if (habitacionSelect) {
      Array.from(habitacionSelect.options).forEach((opt) => {
        if (opt.value) precios[opt.value] = parseFloat(opt.dataset.precio || 0);
      });
    }

    async function verificarDisponibilidad() {
      if (!f_llegada.value || !f_salida.value || !habitacionSelect.value) {
        if (disponibilidadMensaje) disponibilidadMensaje.innerHTML = '';
        if (btnSubmit) btnSubmit.disabled = true;
        return;
      }
      const formData = new FormData();
      formData.append('f_llegada', f_llegada.value);
      formData.append('f_salida', f_salida.value);
      formData.append('habitacion', habitacionSelect.value);
      try {
        const response = await fetch(`${base_url}reserva/verificar`, { method: 'POST', body: formData });
        const data = await response.json();
        if (data.disponible) {
          disponibilidadMensaje.innerHTML = '<span class="text-success">¡Habitación Disponible!</span>';
          btnSubmit.disabled = false;
        } else {
          disponibilidadMensaje.innerHTML = '<span class="text-danger">No Disponible para estas fechas</span>';
          btnSubmit.disabled = true;
        }
      } catch (error) {
        disponibilidadMensaje.innerHTML = '<span class="text-danger">Error de conexión</span>';
        btnSubmit.disabled = true;
      }
    }

    function calcularTotal() {
      if (!f_llegada.value || !f_salida.value || !habitacionSelect.value) {
        totalReserva.value = "$0";
        return;
      }
      const llegadaDate = new Date(f_llegada.value);
      const salidaDate = new Date(f_salida.value);
      if (llegadaDate >= salidaDate) {
        totalReserva.value = "$0";
        return;
      }
      const diffTime = salidaDate - llegadaDate;
      const noches = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      const precio = precios[habitacionSelect.value] || 0;
      const total = noches * precio;
      totalReserva.value = `$${total.toLocaleString("es-CO")}`;
    }

    function manejarCambioDeFecha() {
      if (f_llegada.value && f_salida.value) {
        const llegadaDate = new Date(f_llegada.value);
        const salidaDate = new Date(f_salida.value);
        if (salidaDate <= llegadaDate) {
          alertaSW("La fecha de salida debe ser posterior a la llegada", "warning");
          f_salida.value = "";
        }
      }
      calcularTotal();
      verificarDisponibilidad();
      if (calendar) calendar.refetchEvents();
    }

    if (f_llegada && f_salida && habitacionSelect) {
      [f_llegada, f_salida, habitacionSelect].forEach((input) => {
        input.addEventListener("change", manejarCambioDeFecha);
      });
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: { left: "prev,next today", center: "title", right: "dayGridMonth" },
      initialView: "dayGridMonth",
      locale: "es",
      selectable: true,
      select: function (info) {
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        if (info.start < hoy) {
          calendar.unselect();
          return;
        }
        f_llegada.value = info.startStr;
        f_salida.value = info.endStr;
        f_llegada.dispatchEvent(new Event('change'));
        f_salida.dispatchEvent(new Event('change'));
      },
      events: function (fetchInfo, successCallback, failureCallback) {
        const habitacion_id = habitacionSelect ? habitacionSelect.value : '';
        if (!habitacion_id || !f_llegada.value || !f_salida.value) {
          successCallback([]);
          return;
        }
        const url = `${base_url}reserva/listar/${f_llegada.value},${f_salida.value},${habitacion_id}`;
        fetch(url).then(response => response.json()).then(data => successCallback(data)).catch(error => failureCallback(error));
      },
      dayCellDidMount: function (info) {
        const cellDate = info.date;
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (cellDate < today) info.el.classList.add("disabled-date");
      },
    });

    calendar.render();

    if (frm) {
      frm.addEventListener("submit", async function (e) {
        e.preventDefault();
        if (isSubmitting) return;
        isSubmitting = true;
        const btnTextOriginal = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = 'Procesando...';
        try {
          const response = await fetch(frm.action, { method: "POST", body: new FormData(frm) });
          const data = await response.json();
          if (data.status === "success") {
            window.location.href = data.redirect;
          } else {
            alertaSW(data.msg || "Error al registrar la reserva", "error");
            isSubmitting = false;
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = btnTextOriginal;
          }
        } catch (error) {
          alertaSW("Error de conexión con el servidor.", "error");
          isSubmitting = false;
          btnSubmit.disabled = false;
          btnSubmit.innerHTML = btnTextOriginal;
        }
      });
    }

    window.addEventListener("load", () => {
      if (habitacionSelect && habitacionSelect.value) {
        if(calendar) calendar.refetchEvents();
      }
      calcularTotal();
      verificarDisponibilidad();
    });
  }

  // --- LOGICA PARA EL MODAL DE RESERVA (EN PAGINAS DE LISTADO Y DETALLE) ---
  const reservationModalEl = document.getElementById('reservationModal');

  if (reservationModalEl) {
      const modalHabitacionId = document.getElementById('modalHabitacionId');
      const modalTriggers = document.querySelectorAll('[data-bs-target="#reservationModal"]');

      modalTriggers.forEach(trigger => {
          trigger.addEventListener('click', function() {
              const habitacionId = this.getAttribute('data-id');
              modalHabitacionId.value = habitacionId;
          });
      });

      const verificarBtn = document.getElementById('verificarDisponibilidadBtn');
      if (verificarBtn) {
          verificarBtn.addEventListener('click', function () {
              const habitacionId = modalHabitacionId.value;
              const fechaLlegada = document.getElementById('modalLlegada').value;
              const fechaSalida = document.getElementById('modalSalida').value;

              if (!fechaLlegada || !fechaSalida) {
                  Swal.fire('Error', 'Por favor, selecciona ambas fechas.', 'error');
                  return;
              }

              const url = `${base_url}reserva/verify?f_llegada=${fechaLlegada}&f_salida=${fechaSalida}&habitacion=${habitacionId}`;
              window.location.href = url;
          });
      }
  }
});
