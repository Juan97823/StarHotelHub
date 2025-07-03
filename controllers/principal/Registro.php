<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Registro';
        $data['subtitle'] = 'Regístrate en nuestra plataforma';
        $this->views->getView('principal/Registro', $data);
    }

    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (validarCampos(['nombre', 'correo', 'clave', 'confirmar'])) {
                $nombre = strClean($_POST['nombre']);
                $correo = strClean($_POST['correo']);
                $clave = strClean($_POST['clave']);
                $confirmar = strClean($_POST['confirmar']);

                if ($clave !== $confirmar) {
                    $res = ['tipo' => 'warning', 'msg' => 'LAS CONTRASEÑAS NO COINCIDEN'];
                } else {
                    // 🔍 VERIFICAR SI EL CORREO YA EXISTE
                    $verificar = $this->model->verificarCorreo($correo);
                    if (!empty($verificar)) {
                        $res = ['tipo' => 'warning', 'msg' => 'EL CORREO YA ESTÁ REGISTRADO'];
                    } else {
                        // Si no existe, se registra
                        $hash = password_hash($clave, PASSWORD_DEFAULT);
                        $rol = 2; // Rol de usuario normal
                        $data = $this->model->registrarse($nombre, $correo, $hash, $rol);

                        if ($data > 0) {
                            $res = ['tipo' => 'success', 'msg' => 'USUARIO REGISTRADO CON ÉXITO'];
                        } else {
                            $res = ['tipo' => 'error', 'msg' => 'ERROR AL REGISTRAR EL USUARIO'];
                        }
                    }
                }
            } else {
                $res = ['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'];
            }
        } else {
            $res = ['tipo' => 'error', 'msg' => 'PETICIÓN INVÁLIDA'];
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
