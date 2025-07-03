const frmLogin = document.querySelector("#formularioLogin");

document.addEventListener("DOMContentLoaded", function () {
  if (!frmLogin) return;

  frmLogin.addEventListener("submit", function (e) {
    e.preventDefault();

    const correo = frmLogin.correo.value.trim();
    const clave = frmLogin.clave.value.trim(); // <- actualizado aquí

    if (correo === "" || clave === "") {
      alertaSW("TODOS LOS CAMPOS SON REQUERIDOS", "warning");
      return;
    }

    const http = new XMLHttpRequest();
    const url = base_url + "login/validar";
    http.open("POST", url, true);
    http.send(new FormData(frmLogin));

    http.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        try {
          const res = JSON.parse(this.responseText);
          alertaSW(res.msg, res.tipo);

          if (res.tipo === "success") {
            setTimeout(() => {
              window.location.href = base_url + "dashboard";
            }, 1500);
          }
        } catch (error) {
          console.error("Error al procesar la respuesta:", error);
        }
      }
    };
  });
});
