document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formReportes");
    const resultado = document.getElementById("resultado");

    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const params = new URLSearchParams(new FormData(this));
        fetch(`${RUTA_PRINCIPAL}admin/reportes/getData?${params}`)
            .then(res => {
                if (!res.ok) throw new Error("Error HTTP " + res.status);
                return res.json();
            })
            .then(data => {
                let html = `
                    <h4>Resultado del Reporte: ${data.tipoReporte}</h4>
                    <p>Desde <strong>${data.fechaInicio}</strong> hasta <strong>${data.fechaFin}</strong></p>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Detalle</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                if (data.datos.length > 0) {
                    data.datos.forEach((row, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.detalle ?? "-"}</td>
                                <td>${row.fecha ?? "-"}</td>
                            </tr>`;
                    });
                } else {
                    html += `<tr><td colspan="3" class="text-center">No hay resultados en este rango</td></tr>`;
                }

                html += `
                        </tbody>
                    </table>
                `;

                resultado.innerHTML = html;
            })
            .catch(err => {
                console.error("Error en fetch:", err);
                resultado.innerHTML = `<div class="alert alert-danger">Ocurrió un error al generar el reporte.</div>`;
            });
    });
});
