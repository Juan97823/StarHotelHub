document.addEventListener("DOMContentLoaded", function () {
  const frmLogin = document.querySelector("#formularioLogin");
  if (!frmLogin) return;

  frmLogin.addEventListener("submit", function (e) {
    e.preventDefault();

    const correo = frmLogin.correo.value.trim();
    const clave = frmLogin.clave.value.trim();

    if (correo === "" || clave === "") {
      alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
      return;
    }

    if (typeof base_url === "undefined") {
      console.error("base_url no está definido.");
      alertaSW("Error interno de configuración", "error");
      return;
    }

    const http = new XMLHttpRequest();
    const url = base_url + "login/validar";
    http.open("POST", url, true);
    http.send(new FormData(frmLogin));

    http.onreadystatechange = function () {
      if (this.readyState === 4) {
        if (this.status === 200) {
          try {
            const res = JSON.parse(this.responseText);

            alertaSW(res.msg || "Procesado", res.tipo || "info");

            if (res.tipo === "success") {
              setTimeout(() => {
                const destino = res.redirect ? base_url + res.redirect : base_url + "dashboard";
                window.location.href = destino;
              }, 1500);
            }
          } catch (error) {
            console.error("Error al procesar la respuesta JSON:", error);
            alertaSW("Respuesta inesperada del servidor", "error");
          }
        } else {
          console.error("Error de red o del servidor:", this.status);
          alertaSW("No se pudo procesar el login", "error");
        }
      }
    };

    http.onerror = function () {
      alertaSW("Error de conexión con el servidor", "error");
    };
  });
});
