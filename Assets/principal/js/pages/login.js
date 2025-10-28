const frm = document.querySelector("#formulario");

document.addEventListener("DOMContentLoaded", function () {
  if (!frm) return;

  frm.addEventListener("submit", function (e) {
    e.preventDefault();

    const usuario = frm.usuario.value.trim();
    const clave = frm.clave.value.trim();
    const terminos = document.getElementById("terminos");

    if (usuario === "" || clave === "") {
      alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
    } else if (terminos && !terminos.checked) {
      alertaSW("DEBES ACEPTAR LOS TÉRMINOS Y CONDICIONES", "warning");
    } else {
      const http = new XMLHttpRequest();
      const url = base_url + "login/verify";
      http.open("POST", url, true);
      http.send(new FormData(frm));

      http.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) {
            try {
              const res = JSON.parse(this.responseText);
              alertaSW(res.msg, res.tipo);

              if (res.tipo === "success") {
                frm.reset();
                setTimeout(() => {
                  if (res.rol == 1) {
                    window.location = base_url + "admin/dashboard";
                  } else if (res.rol == 2) {
                    window.location = base_url + "empleado/dashboard";
                  } else if (res.rol == 3) {
                    window.location = base_url + "cliente/dashboard";
                  } else if (res.rol == 4) {
                    window.location = base_url + "Login";
                    alertaSW("Usuario inactivo. Contacta al administrador.", "error");
                  } else {
                    alertaSW("Rol no reconocido. Contacta al administrador.", "error");
                  }
                }, 1600);
              } else {
                recargarToken();
              }
            } catch (e) {
              alertaSW("Error al procesar la respuesta del servidor", "error");
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
    }
  });
});

function recargarToken() {
  const csrfInput = document.querySelector('input[name="csrf_token"]');
  if (csrfInput) {
    fetch(base_url + "api/csrf-token")
      .then(response => response.json())
      .then(data => {
        if (data.token) {
          csrfInput.value = data.token;
        }
      })
      .catch(() => {
        location.reload();
      });
  }
}
