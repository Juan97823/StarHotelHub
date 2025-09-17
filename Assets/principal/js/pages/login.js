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
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          console.log(res); // Depuración: Ver la respuesta en la consola
          alertaSW(res.msg, res.tipo);

          if (res.tipo === "success") {
            frm.reset();
            setTimeout(() => {
              if (res.rol == 1) {
                window.location = base_url + "admin/dashboard";
              } else if (res.rol == 2) {
                window.location = base_url + "empleado/dashboard";
              } else if (res.rol == 3) {
                window.location = base_url + "cliente/dashboard"; // cliente
              } else if (res.rol == 4) {
                window.location = base_url + "Login"; // fallback
                alertaSW("Usuario inactivo. Contacta al administrador.", "error");
              } else {
                alertaSW("Rol no reconocido. Contacta al administrador.", "error");
              }
            }, 1600);
          }
        }
      };
    }
  });
});
