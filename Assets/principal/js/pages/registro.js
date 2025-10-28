const frm = document.querySelector("#formulario");
const terminos = document.querySelector("#chb2");

document.addEventListener("DOMContentLoaded", function () {
  frm.addEventListener("submit", function (e) {
    e.preventDefault();

    if (
      frm.nombre.value == "" ||
      frm.correo.value == "" ||
      frm.clave.value == "" ||
      frm.confirmar.value == ""
    ) {
      alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
    } else if (!terminos.checked) {
      alertaSW("ACEPTA LOS TÉRMINOS Y CONDICIONES", "warning");
    } else if (frm.clave.value !== frm.confirmar.value) {
      alertaSW("LAS CONTRASEÑAS NO COINCIDEN", "warning");
    } else {
      const http = new XMLHttpRequest();
      const url = base_url + "registro/crear";
      http.open("POST", url, true);

      http.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) {
            try {
              const res = JSON.parse(this.responseText);
              alertaSW(res.msg, res.tipo);

              if (res.tipo === "success") {
                frm.reset();
                //MANDAR A OTRA RUTA
                setTimeout(() => {
                  window.location = base_url + "dashboard";
                }, 1600); // Espera 1.6s para que el usuario vea la alerta
              }
            } catch (e) {
              console.error("Error al parsear JSON:", e);
              alertaSW("Error al procesar la respuesta", "error");
            }
          } else {
            console.error("Error HTTP:", this.status, this.responseText);
            alertaSW("Error en la petición: " + this.status, "error");
          }
        }
      };

      http.onerror = function () {
        console.error("Error en la petición AJAX");
        alertaSW("Error de conexión", "error");
      };

      http.send(new FormData(frm));
    }
  });
});
