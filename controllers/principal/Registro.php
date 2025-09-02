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
            if (validarCampos(['nombre', 'correo', 'clave', 'confirmar', 'chb2'])) {
                $nombre = strClean($_POST['nombre']);
                $correo = strClean($_POST['correo']);
                $clave = strClean($_POST['clave']);
                $confirmar = strClean($_POST['confirmar']);
                $hash = password_hash($clave, PASSWORD_DEFAULT);
                $rol = 3; // Usuario normal
                if ($clave == $confirmar) {
                    // VERIFICAR CORREO
                    $verificarCorreo = $this->model->validarUnique('correo', $correo, 0);
                    if (empty($verificarCorreo)) {
                        $data = $this->model->registrarse($nombre, $correo, $hash, $rol);
                        if ($data > 0) {
                            $res = ['tipo' => 'success', 'msg' => 'USUARIO REGISTRADO EXITOSAMENTE'];
                        } else {
                            $res = ['tipo' => 'warning', 'msg' => 'ERROR AL REGISTRAR EL USUARIO'];
                        }
                    } else {

                        $res = ['tipo' => 'warning', 'msg' => 'EL CORREO YA ESTÁ REGISTRADO'];
                    }
                } else {
                    $res = ['tipo' => 'warning', 'msg' => 'EL USUARIO YA ESTÁ REGISTRADO'];
                }
            } else {
                $res = ['tipo' => 'warning', 'msg' => 'LAS CONTRASEÑAS NO COINCIDEN'];
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
}
 