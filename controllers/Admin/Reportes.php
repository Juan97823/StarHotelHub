<?php
require_once 'helpers/seguridad.php';

class Reportes extends Controller
{
    public function __construct()
    {
        parent::__construct();          // Inicializa views y model
        //verificarRol(1);                // Solo admins
        $this->cargarModel('Reportes'); // Cargar ReportesModel.php
    }

    public function index()
    {
        $data['title'] = 'Reportes Administrativos';
        $this->views->getView('admin/Reportes', $data);
    }

    public function getData()
    {
        $tipoReporte = $_GET['tipo_reporte'] ?? null;
        $fechaInicio = $_GET['fecha_inicio'] ?? null;
        $fechaFin = $_GET['fecha_fin'] ?? null;

        $datos = [];
        if ($tipoReporte && $fechaInicio && $fechaFin) {
            $datos = $this->model->obtenerDatos($tipoReporte, $fechaInicio, $fechaFin);
        }

        header('Content-Type: application/json');
        echo json_encode([
            'tipoReporte' => $tipoReporte,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'datos' => $datos
        ], JSON_NUMERIC_CHECK);
        die();
    }
}
