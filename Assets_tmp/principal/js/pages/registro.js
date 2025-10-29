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
                setTimeout(() => {
                  window.location = base_url + "registro/exito";
                }, 1200);
              } else {
                recargarToken();
              }
            } catch (e) {
              alertaSW("Error al procesar la respuesta", "error");
              recargarToken();
            }
          } else if (this.status == 403) {
            try {
              const res = JSON.parse(this.responseText);
              alertaSW(res.msg || "Token inválido", "error");
            } catch (e) {
              alertaSW("Token inválido", "error");
            }
            recargarToken();
          } else if (this.status == 400) {
            try {
              const res = JSON.parse(this.responseText);
              alertaSW(res.msg || "Solicitud inválida", "error");
            } catch (e) {
              alertaSW("Solicitud inválida", "error");
            }
            recargarToken();
          } else {
            alertaSW("Error en el servidor. Intenta de nuevo.", "error");
            recargarToken();
          }
        }
      };

      http.onerror = function () {
        alertaSW("Error de conexión. Intenta de nuevo.", "error");
      };

      http.send(new FormData(frm));
    }
  });
});
