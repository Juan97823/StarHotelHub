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

        // Restringir acceso solo a administradores
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
            header('Location: ' . RUTA_PRINCIPAL . 'admin/login');
            exit;
        }
    }

    // Listado de entradas
    public function index()
    {
        $data['title'] = 'Entradas del Blog';
        $data['entradas'] = $this->model->getEntradasAdmin();
        $this->views->getView('admin/blog/index', $data);
    }

    // Formulario nueva entrada
    public function crear()
    {
        $data['title'] = 'Nueva Entrada';
        $this->views->getView('admin/blog/crear', $data);
    }
    // Listar entradas en formato JSON (para DataTables)
    public function listarEntradas()
    {
        $data = $this->model->getEntradasAdmin();

        // Ajusta el formato según DataTables (usa "data")
        echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);
        die();
    }


    // Guardar nueva entrada
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo']);
            $contenido = trim($_POST['contenido']);
            $id_usuario = $_SESSION['usuario']['id'];

            // Generar slug simple
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));

            // Manejo de categorías (ajusta según tu formulario)
            $categorias = isset($_POST['categorias']) ? trim($_POST['categorias']) : '';

            $imagen = null;
            if (!empty($_FILES['imagen']['name'])) {
                $nombreImg = time() . "_" . basename($_FILES['imagen']['name']);
                $destino = 'uploads/blog/' . $nombreImg;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                    $imagen = $nombreImg;
                }
            }

            $this->model->insertar($titulo, $contenido, $imagen, $slug, $categorias, $id_usuario);
        }

        header('Location: ' . RUTA_ADMIN . 'blog');
        exit;
    }

    // Editar entrada
    public function editar($id)
    {
        $data['title'] = 'Editar Entrada';
        $data['entrada'] = $this->model->getEntrada($id);
        $this->views->getView('admin/blog/editar', $data);
    }

    // Actualizar entrada
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $titulo = trim($_POST['titulo']);
            $contenido = trim($_POST['contenido']);
            $imagen = $_POST['imagen_actual'];
            $id_usuario = $_SESSION['usuario']['id'];

            // Generar slug simple
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));

            // Manejo de categorías (ajusta según tu formulario)
            $categorias = isset($_POST['categorias']) ? trim($_POST['categorias']) : '';

            if (!empty($_FILES['imagen']['name'])) {
                $nombreImg = time() . "_" . basename($_FILES['imagen']['name']);
                $destino = 'uploads/blog/' . $nombreImg;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                    $imagen = $nombreImg;
                }
            }

            $this->model->actualizar($titulo, $contenido, $imagen, $slug, $categorias, $id_usuario, $id);
        }

        header('Location: ' . RUTA_ADMIN . 'blog');
        exit;
    }

    // Eliminar entrada (cambia estado a inactiva)
    // Eliminar entrada (AJAX)
    public function eliminar($id)
    {
        $result = $this->model->estado(0, $id);

        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        die();
    }

}
