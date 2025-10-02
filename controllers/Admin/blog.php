<?php
class Blog extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Blog');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Solo administradores
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
            header('Location: ' . RUTA_PRINCIPAL . 'admin/login');
            exit;
        }
    }

    // Listado
    public function index()
    {
        $data['title'] = 'Entradas del Blog';
        $this->views->getView('admin/blog/index', $data);
    }

    // Nueva entrada
    public function crear()
    {
        $data['title'] = 'Nueva Entrada';
        $this->views->getView('admin/blog/crear', $data);
    }

    // Listar en JSON (DataTables)
    public function listarEntradas()
    {
        header('Content-Type: application/json; charset=utf-8');
        $data = $this->model->getEntradasAdmin();
        echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Cambiar estado
    public function estado($param)
    {
        header('Content-Type: application/json; charset=utf-8');

        $parts = explode(",", $param);
        $id = $parts[0] ?? null;
        $nuevoEstado = $parts[1] ?? null;

        if ($id && ($nuevoEstado == 0 || $nuevoEstado == 1)) {
            $result = $this->model->estado($nuevoEstado, $id);
            if ($result) {
                $mensaje = $nuevoEstado == 1
                    ? 'Entrada habilitada correctamente'
                    : 'Entrada inhabilitada correctamente';
                echo json_encode(['status' => 'success', 'mensaje' => $mensaje]);
            } else {
                echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo cambiar el estado en la base de datos.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'mensaje' => 'Parámetros no válidos.']);
        }
        exit;
    }

    // Guardar (crear o actualizar)
    public function Actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json; charset=utf-8');

            $esEdicion = !empty($_POST['id']);
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $id_categorias = $_POST['id_categorias'] ?? null;
            $id_usuario = $_SESSION['usuario']['id'];
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));
            $imagen = ($esEdicion && isset($_POST['imagen_actual'])) ? $_POST['imagen_actual'] : null;

            // Subida de imagen
            if (!empty($_FILES['imagen']['name'])) {
                $nombreImg = time() . "_" . basename($_FILES['imagen']['name']);
                $destino = 'uploads/blog/' . $nombreImg;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                    $imagen = $nombreImg;
                }
            }

            if ($esEdicion) {
                $id = $_POST['id'];
                $result = $this->model->actualizar($titulo, $descripcion, $imagen, $slug, $id_usuario, $id_categorias, $id);
            } else {
                $result = $this->model->insertar($titulo, $descripcion, $imagen, $slug, $id_usuario, $id_categorias);
            }

            echo json_encode(
                $result
                ? ['status' => 'success']
                : ['status' => 'error', 'mensaje' => 'Error al guardar en la base de datos.']
            );
            exit;
        }
    }



    // Editar
    public function editar($id)
    {
        $data['title'] = 'Editar Entrada';
        $data['entrada'] = $this->model->getEntrada($id);
        $this->views->getView('admin/blog/editar', $data);
    }
}
