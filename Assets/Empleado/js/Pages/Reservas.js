let tblReservas;
let myModal;

document.addEventListener("DOMContentLoaded", function () {
  if (document.getElementById("reservaModal")) {
    tblReservas = $("#tableReservas").DataTable({
      ajax: {
        url: base_url + "empleado/listar", //  ruta correcta
        dataSrc: "data", // ✅ el JSON contiene la clave "data"
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
      .addEventListener("change", calcularMonto);
    document
      .getElementById("fecha_ingreso")
      .addEventListener("change", calcularMonto);
    document
      .getElementById("fecha_salida")
      .addEventListener("change", calcularMonto);

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
  const selectedOption =
    habitacionSelect.options[habitacionSelect.selectedIndex];

  if (!selectedOption || !selectedOption.hasAttribute("data-precio")) {
    montoInput.value = "0.00";
    return;
  }

  const precioPorNoche = parseFloat(selectedOption.getAttribute("data-precio"));
  const fechaIngreso = new Date(fechaIngresoInput.value);
  const fechaSalida = new Date(fechaSalidaInput.value);

  if (
    precioPorNoche > 0 &&
    fechaIngreso instanceof Date &&
    !isNaN(fechaIngreso) &&
    fechaSalida instanceof Date &&
    !isNaN(fechaSalida) &&
    fechaSalida > fechaIngreso
  ) {
    const diffTime = Math.abs(fechaSalida - fechaIngreso);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    const montoTotal = diffDays * precioPorNoche;
    montoInput.value = montoTotal.toFixed(2);
  } else {
    montoInput.value = "0.00";
  }
}

function btnNuevaReserva() {
  document.getElementById("reservaForm").reset();
  document.getElementById("idReserva").value = "";
  document.getElementById("reservaModalLabel").textContent = "Nueva Reserva";
  document.getElementById("monto").value = "0.00";
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
      myModal.show();
    })
    .catch((err) => {
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
    .catch((err) => {
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
      const url = base_url + "empleado/reservas/eliminar/" + id;
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
        });
    }
  });
}

function btnConfirmarReserva(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡Se confirmará la reserva!",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, ¡confirmar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "empleado/reservas/confirmar/" + id;
      fetch(url, { method: "GET" })
        .then((response) => response.json())
        .then((res) => {
          if (res.msg == "ok") {
            Swal.fire(
              "¡Confirmada!",
              "La reserva ha sido confirmada.",
              "success"
            );
            tblReservas.ajax.reload();
          } else {
            Swal.fire("¡Error!", res.msg, "error");
          }
        });
    }
  });
}

function btnActivarReserva(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡La reserva se reactivará como pendiente!",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, ¡reactivar!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "empleado/reservas/activar/" + id;
      fetch(url, { method: "GET" })
        .then((response) => response.json())
        .then((res) => {
          if (res.msg == "ok") {
            Swal.fire(
              "¡Reactivada!",
              "La reserva ha sido reactivada.",
              "success"
            );
            tblReservas.ajax.reload();
          } else {
            Swal.fire("¡Error!", res.msg, "error");
          }
        });
    }
  });
}
