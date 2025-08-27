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
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);

          alertaSW(res.msg, res.tipo);

          if (res.tipo === "success") {
            frm.reset();
            //MANDAR A OTRA RUTA
            setTimeout(() => {
              window.location = base_url + "dashboard";
            }, 1600); // Espera 1.6s para que el usuario vea la alerta
          }
        }
      };
    }
  });
});
