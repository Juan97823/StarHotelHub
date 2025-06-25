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
      alertaSW("TODO LOS CAMPOS SON REQUERIDOS", "warning");
    } else if (!terminos.checked) {
      alertaSW("ACEPTA LOS TERMINOS Y CONDICIONES", "warning");
    } else {
      const http = new XMLHttpRequest();
      const url = base_url + "registro/crear";

      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
        {
        }
      };
    }
  });
});
