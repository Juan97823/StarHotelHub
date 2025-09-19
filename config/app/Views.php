<?php
class Views
{
    public function getView($vista, $data = "")
    {
        // Construir la ruta de una manera más robusta
        $path = RUTA_RAIZ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $vista . '.php';

        // Reemplazar cualquier separador de barra o contrabarra por el separador correcto del sistema
        $archivo_vista = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);

        if (file_exists($archivo_vista)) {
            require $archivo_vista;
        } else {
            // Manejar el error, por ejemplo, mostrando una página 404
            echo "Error: La vista no existe en la ruta: " . $archivo_vista;
        }
    }
}
?>