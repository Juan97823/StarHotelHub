<?php
class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Login';
        $data['subtitle'] = 'Inicio de sesión';
        $this->views->getView('principal/login', $data);
    }

    public function validar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = isset($_POST['correo']) ? strClean($_POST['correo']) : '';
            $clave  = isset($_POST['clave']) ? strClean($_POST['clave']) : '';

            if ($correo === '' || $clave === '') {
                $res = ['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'];
            } else {
                $usuario = $this->model->getUsuarioCorreo($correo);

                if (!empty($usuario)) {
                    // Validar estado
                    if (isset($usuario['estado']) && $usuario['estado'] == 0) {
                        $res = ['tipo' => 'warning', 'msg' => 'USUARIO INACTIVO. CONTACTE SOPORTE'];
                    } elseif (password_verify($clave, $usuario['clave'])) {
                        // Crear sesión
                        $_SESSION['id_usuario'] = $usuario['id'];
                        $_SESSION['nombre']     = $usuario['nombre'];
                        $_SESSION['correo']     = $usuario['correo'];
                        $_SESSION['rol']        = $usuario['rol'];

                        // Redirección según rol
                        $redirect = match ($usuario['rol']) {
                            'Administrador'   => 'admin/dashboard',
                            'Recepcionista'  => 'recepcionista/inicio',
                            'Cajero'         => 'caja/inicio',
                            default          => 'cliente/inicio',
                        };

                        $res = [
                            'tipo' => 'success',
                            'msg' => 'BIENVENIDO ' . $usuario['nombre'],
                            'redirect' => $redirect
                        ];
                    } else {
                        $res = ['tipo' => 'error', 'msg' => 'CONTRASEÑA INCORRECTA'];
                    }
                } else {
                    $res = ['tipo' => 'error', 'msg' => 'EL CORREO NO ESTÁ REGISTRADO'];
                }
            }
        } else {
            $res = ['tipo' => 'error', 'msg' => 'PETICIÓN INVÁLIDA'];
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
