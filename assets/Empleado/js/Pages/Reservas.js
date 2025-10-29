let tblReservas;
let myModal;

document.addEventListener("DOMContentLoaded", function () {
  if (document.getElementById("reservaModal")) {
    tblReservas = $("#tableReservas").DataTable({
      ajax: {
        url: base_url + "empleado/listar",
        dataSrc: "data",
      },
      columns: [
        { data: 0 }, // ID
        { data: 1 }, // Habitación
        { data: 2 }, // Cliente
        { data: 3 }, // Fecha ingreso
        { data: 4 }, // Fecha salida
        { data: 5 }, // Monto
        { data: 6 }, // Estado
        { data: 7 }, // Acciones
      ],
      language: {
        url: base_url + "assets/admin/js/i18n/es-ES.json",
      },
      responsive: true,
      dom: "Bfrtilp",
      buttons: ["copy", "csv", "excel", "pdf", "print"],
    });

    myModal = new bootstrap.Modal(document.getElementById("reservaModal"));

    document
      .getElementById("habitacion")
      .addEventListener("change", () => {
        calcularMonto();
        verificarDisponibilidad();
      });
    document
      .getElementById("fecha_ingreso")
      .addEventListener("change", () => {
        calcularMonto();
        verificarDisponibilidad();
      });
    document
      .getElementById("fecha_salida")
      .addEventListener("change", () => {
        calcularMonto();
        verificarDisponibilidad();
      });

    document
      .getElementById("reservaForm")
      .addEventListener("submit", guardarReserva);
  }
});

function calcularMonto() {
  const habitacionSelect = document.getElementById("habitacion");
  const fechaIngresoInput = document.getElementById("fecha_ingreso");
  const fechaSalidaInput = document.getElementById("fecha_salida");
  const montoInput = document.getElementById("monto");

  if (!habitacionSelect.value || !fechaIngresoInput.value || !fechaSalidaInput.value) {
    montoInput.value = "0.00";
    return;
  }

  const selectedOption = habitacionSelect.options[habitacionSelect.selectedIndex];
  if (!selectedOption) {
    montoInput.value = "0.00";
    return;
  }

  const precioPorNoche = parseFloat(selectedOption.getAttribute("data-precio") || 0);

  if (!precioPorNoche || precioPorNoche <= 0) {
    montoInput.value = "0.00";
    return;
  }

  const fechaIngreso = new Date(fechaIngresoInput.value);
  const fechaSalida = new Date(fechaSalidaInput.value);

  if (isNaN(fechaIngreso.getTime()) || isNaN(fechaSalida.getTime())) {
    montoInput.value = "0.00";
    return;
  }

  if (fechaSalida <= fechaIngreso) {
    montoInput.value = "0.00";
    return;
  }

  const diffTime = Math.abs(fechaSalida - fechaIngreso);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  const montoTotal = diffDays * precioPorNoche;
  montoInput.value = montoTotal.toFixed(2);
}

function verificarDisponibilidad() {
  const habitacionSelect = document.getElementById("habitacion");
  const fechaIngresoInput = document.getElementById("fecha_ingreso");
  const fechaSalidaInput = document.getElementById("fecha_salida");
  const disponibilidadDiv = document.getElementById("disponibilidad-mensaje") || crearMensajeDisponibilidad();

  if (!habitacionSelect.value || !fechaIngresoInput.value || !fechaSalidaInput.value) {
    disponibilidadDiv.innerHTML = "";
    return;
  }

  const fechaIngreso = new Date(fechaIngresoInput.value);
  const fechaSalida = new Date(fechaSalidaInput.value);

  if (fechaSalida <= fechaIngreso) {
    disponibilidadDiv.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Fechas inválidas</span>';
    return;
  }

  const formData = new FormData();
  formData.append("habitacion", habitacionSelect.value);
  formData.append("fecha_ingreso", fechaIngresoInput.value);
  formData.append("fecha_salida", fechaSalidaInput.value);
  formData.append("id_reserva", document.getElementById("idReserva").value || 0);

  fetch(base_url + "empleado/reservas/verificar", {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.disponible) {
        disponibilidadDiv.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Habitación disponible</span>';
      } else {
        disponibilidadDiv.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> No disponible en esas fechas</span>';
      }
    })
    .catch(() => {
      disponibilidadDiv.innerHTML = '<span class="text-warning"><i class="fas fa-exclamation-circle"></i> Error al verificar</span>';
    });
}

function crearMensajeDisponibilidad() {
  const div = document.createElement("div");
  div.id = "disponibilidad-mensaje";
  div.className = "mt-2 small";
  const montoDiv = document.getElementById("monto").parentElement;
  montoDiv.parentElement.insertBefore(div, montoDiv.nextSibling);
  return div;
}

function btnNuevaReserva() {
  document.getElementById("reservaForm").reset();
  document.getElementById("idReserva").value = "";
  document.getElementById("reservaModalLabel").textContent = "Nueva Reserva";
  document.getElementById("monto").value = "0.00";
  document.getElementById("disponibilidad-mensaje").innerHTML = "";
  myModal.show();
}

function btnEditarReserva(id) {
  document.getElementById("reservaModalLabel").textContent = "Editar Reserva";
  const url = base_url + "empleado/reservas/obtener/" + id;
  fetch(url, { method: "GET" })
    .then((response) => response.json())
    .then((res) => {
      document.getElementById("idReserva").value = res.id;
      document.getElementById("habitacion").value = res.id_habitacion;
      document.getElementById("cliente").value = res.id_usuario;
      document.getElementById("fecha_ingreso").value = res.fecha_ingreso;
      document.getElementById("fecha_salida").value = res.fecha_salida;
      document.getElementById("monto").value = res.monto;

      document.getElementById("habitacion").dispatchEvent(new Event("change"));
      document.getElementById("fecha_ingreso").dispatchEvent(new Event("change"));
      document.getElementById("fecha_salida").dispatchEvent(new Event("change"));

      myModal.show();
    })
    .catch(() => {
      Swal.fire(
        "¡Error!",
        "No se pudieron cargar los datos de la reserva.",
        "error"
      );
    });
}

function guardarReserva(event) {
  event.preventDefault();
  const url = base_url + "empleado/reservas/guardar";
  const form = document.getElementById("reservaForm");
  const data = new FormData(form);

  fetch(url, {
    method: "POST",
    body: data,
  })
    .then((response) => response.json())
    .then((res) => {
      if (res.msg == "ok") {
        const idReserva = document.getElementById("idReserva").value;
        const mensaje = idReserva
          ? "Reserva actualizada con éxito"
          : "Reserva creada con éxito";
        Swal.fire("¡Éxito!", mensaje, "success");
        myModal.hide();
        tblReservas.ajax.reload();
      } else {
        Swal.fire("¡Error!", res.msg, "error");
      }
    })
    .catch(() => {
      Swal.fire(
        "¡Error de Conexión!",
        "No se pudo comunicar con el servidor.",
        "error"
      );
    });
}

function btnCancelarReserva(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡La reserva se cancelará!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí, ¡cancelar!",
    cancelButtonText: "No, mantener",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "empleado/reservas/eliminar?id=" + id;
      fetch(url, { method: "GET" })
        .then((response) => response.json())
        .then((res) => {
          if (res.msg == "ok") {
            Swal.fire(
              "¡Cancelada!",
              "La reserva ha sido cancelada.",
              "success"
            );
            tblReservas.ajax.reload();
          } else {
            Swal.fire("¡Error!", res.msg, "error");
          }
        })
        .catch(() => {
          Swal.fire("¡Error!", "Error de conexión", "error");
        });
    }
  });
}

function btnCheckOutReserva(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡Se completará la reserva (Check-Out)!",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#ffc107",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, ¡completar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "empleado/reservas/checkout?id=" + id;
      fetch(url, { method: "GET" })
        .then((response) => response.json())
        .then((res) => {
          if (res.msg == "ok") {
            Swal.fire(
              "¡Completada!",
              "La reserva ha sido completada (Check-Out).",
              "success"
            );
            tblReservas.ajax.reload();
          } else {
            Swal.fire("¡Error!", res.msg, "error");
          }
        })
        .catch(() => {
          Swal.fire("¡Error!", "Error de conexión", "error");
        });
    }
  });
}

function btnActivarReserva(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡La reserva se activará (Check-In)!",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, ¡activar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "empleado/reservas/activar?id=" + id;
      fetch(url, { method: "GET" })
        .then((response) => response.json())
        .then((res) => {
          if (res.msg === "ok") {
            Swal.fire(
              "¡Activada!",
              "La reserva ha sido activada (Check-In).",
              "success"
            );
            tblReservas.ajax.reload();
          } else {
            Swal.fire("¡Error!", res.msg || "Error al activar", "error");
          }
        })
        .catch(() => {
          Swal.fire("¡Error!", "Error de conexión", "error");
        });
    }
  });
}
