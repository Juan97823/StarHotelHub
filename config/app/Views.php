<?php
class Views{
    public function getView($vista, $data="") {
        $archivo_vista = RUTA_RAIZ . '/views/' . $vista . '.php';
        if (file_exists($archivo_vista)) {
            require $archivo_vista;
        } else {
            // Manejar el error, por ejemplo, mostrando una página 404
            echo "Error: La vista no existe en la ruta: " . $archivo_vista;
        }
    }
}
?>