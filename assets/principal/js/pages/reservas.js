document.addEventListener("DOMContentLoaded", function () {
  // --- LOGICA PARA LA PÁGINA DE RESERVA DETALLADA (CON CALENDARIO) ---
  const calendarEl = document.getElementById("calendar");

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

    // Cargar precios de las opciones
    function cargarPrecios() {
      if (habitacionSelect) {
        Array.from(habitacionSelect.options).forEach((opt) => {
          if (opt.value) {
            const precio = opt.getAttribute('data-precio') || opt.dataset.precio || 0;
            precios[opt.value] = parseFloat(precio);
          }
        });
      }
    }

    cargarPrecios();

    // Recargar precios cuando cambia el select
    if (habitacionSelect) {
      habitacionSelect.addEventListener('change', cargarPrecios);
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
      if (!totalReserva) return;

      // Validar que todos los campos estén completos
      if (!f_llegada.value || !f_salida.value || !habitacionSelect.value) {
        totalReserva.value = "$0";
        return;
      }

      try {
        const llegadaDate = new Date(f_llegada.value);
        const salidaDate = new Date(f_salida.value);

        // Validar que las fechas sean válidas
        if (isNaN(llegadaDate.getTime()) || isNaN(salidaDate.getTime())) {
          totalReserva.value = "$0";
          return;
        }

        // Validar que la fecha de salida sea posterior a la de llegada
        if (llegadaDate >= salidaDate) {
          totalReserva.value = "$0";
          return;
        }

        // Calcular número de noches
        const diffTime = salidaDate.getTime() - llegadaDate.getTime();
        const noches = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));

        // Obtener precio de la habitación
        const habitacionId = habitacionSelect.value;
        let precio = precios[habitacionId];

        // Si no está en el objeto precios, intentar obtenerlo del atributo data-precio
        if (!precio || precio === 0) {
          const selectedOption = habitacionSelect.options[habitacionSelect.selectedIndex];
          precio = parseFloat(selectedOption.getAttribute('data-precio') || 0);
        }

        // Validar que el precio sea válido
        if (!precio || precio <= 0) {
          totalReserva.value = "$0";
          return;
        }

        // Calcular total
        const total = noches * precio;
        totalReserva.value = `$${total.toLocaleString("es-CO")}`;
      } catch (error) {
        console.error('Error al calcular total:', error);
        totalReserva.value = "$0";
      }
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
        if (!habitacion_id) {
          successCallback([]);
          return;
        }
        const url = `${base_url}reserva/listar/,,${habitacion_id}`;
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
          if (data.status === "success" && data.redirect) {
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
        if (calendar) calendar.refetchEvents();
      }
      calcularTotal();
      verificarDisponibilidad();
    });
  }

  // --- LOGICA PARA EL MODAL DE VERIFICACIÓN ---
  const reservationModalEl = document.getElementById('reservationModal');
  if (reservationModalEl) {
    const modalHabitacionIdInput = document.getElementById('modalHabitacionId');
    const verificarBtn = document.getElementById('verificarDisponibilidadBtn');

    // Evento para abrir el modal y setear el ID de la habitación
    document.querySelectorAll('[data-bs-target="#reservationModal"]').forEach(trigger => {
      trigger.addEventListener('click', function () {
        const habitacionId = this.getAttribute('data-id');
        if (modalHabitacionIdInput) {
          modalHabitacionIdInput.value = habitacionId;
        }
      });
    });

    // Evento para el botón "Verificar" del modal
    if (verificarBtn) {
      verificarBtn.addEventListener('click', function() {
        const modalLlegada = document.getElementById('modalLlegada').value;
        const modalSalida = document.getElementById('modalSalida').value;
        const modalHabitacionId = modalHabitacionIdInput.value;

        if (!modalLlegada || !modalSalida) {
          alertaSW("Por favor, seleccione las fechas de llegada y salida.", "warning");
          return;
        }

        if (!modalHabitacionId) {
          alertaSW("No se ha especificado una habitación. Cierre este modal y seleccione una habitación.", "warning");
          return;
        }
        
        // Construir la URL y redirigir a la página de reservas para la verificación final y el llenado de datos
        const url = `${base_url}reserva/verify?f_llegada=${modalLlegada}&f_salida=${modalSalida}&habitacion=${modalHabitacionId}`;
        window.location.href = url;
      });
    }
  }
});