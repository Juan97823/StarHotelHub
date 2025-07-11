<?php
//LIMPIAR CARACTERES ESPECIALES PARA PREVENIR INYECCION SQL
function strClean($cadena)
{
  $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $cadena);
  $string = trim($string);
  $string = stripslashes($string);
  $string = str_ireplace('<script>', '', $string);
  $string = str_ireplace('</script>', '', $string);
  $string = str_ireplace('<script type=>', '', $string);
  $string = str_ireplace('<script src>', '', $string);
  $string = str_ireplace('SELECT * FROM', '', $string);
  $string = str_ireplace('DELETE FROM', '', $string);
  $string = str_ireplace('INSERT INTO', '', $string);
  $string = str_ireplace('SELECT COUNT(*) FROM', '', $string);
  $string = str_ireplace('DROP TABLE', '', $string);
  $string = str_ireplace("OR '1'='1", '', $string);
  $string = str_ireplace('OR ´1´=´1', '', $string);
  $string = str_ireplace('IS NULL', '', $string);
  $string = str_ireplace('LIKE "', '', $string);
  $string = str_ireplace("LIKE '", '', $string);
  $string = str_ireplace('LIKE ´', '', $string);
  $string = str_ireplace('OR "a"="a', '', $string);
  $string = str_ireplace("OR 'a'='a", '', $string);
  $string = str_ireplace('OR ´a´=´a', '', $string);
  $string = str_ireplace('--', '', $string);
  $string = str_ireplace('^', '', $string);
  $string = str_ireplace('[', '', $string);
  $string = str_ireplace(']', '', $string);
  $string = str_ireplace('==', '', $string);
  return $string;
}
// CREAR SLUG
function slugify($text, string $divider = '-')
{
  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, $divider);

  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}
// LIMITAR CADENA
function limitar_cadena($cadena, $limite, $sufijo)
{
  // Si la longitud es mayor que el límite...
  if (strlen($cadena) > $limite) {
    // Entonces corta la cadena y ponle el sufijo
    return substr($cadena, 0, $limite) . $sufijo;
  }

  // Si no, entonces devuelve la cadena normal
  return $cadena;
}
//PERSONALIZAR FECHA
function fechaPerzo($fecha)
{
  $datos = explode('-', $fecha);
  $anio = $datos[0];
  $me = ltrim($datos[1], "0");
  $dia = $datos[2];
  $mes = array(
    "",
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  );
  return $dia . " de " . $mes[$me] . " de " . $anio;
}
// VALIDAR CAMPOS REQUERIDOS
function validarCampos($campos)
{
  foreach ($campos as $campo) {
    if (empty($_POST[$campo])) {
      return false;
    }
  }
  return true;
}
// CREAR SESIONES
function crearSesion($datos)
{
  $_SESSION['id_usuario'] = $datos['id'];             // Coincide con columna `id`
  $_SESSION['usuario'] = $datos['correo'];            // Coincide con columna `correo`
  $_SESSION['nombre'] = $datos['nombre'];             // Coincide con columna `nombre`
  $_SESSION['rol'] = $datos['rol'];                   // Coincide con columna `rol`

}
//REDIRECT
function redirect($ruta)
{
  header('Location: ' . $ruta);
}
// AGREGAR PRODUCTOS AL CARRITO
function addToCart($carrito, $id, $nombre, $precio, $token, $cant = 1)
{
  if (!isset($_SESSION[$carrito])) {
    $_SESSION[$carrito] = [];
  }

  $cart = $_SESSION[$carrito];

  $product = [
    'id' => $id,
    'name' => $nombre,
    'price' => $precio,
    'token' => $token,
    'quantity' => $cant
  ];

  // Verificar si el producto ya está en el carrito y actualizar la cantidad si es necesario
  $found = false;
  foreach ($cart as &$item) {
    if ($item['id'] === $id && $item['token'] === $token) {
      $item['quantity']++;
      $found = true;
      break;
    }
  }

  // Si no se encontró el producto en el carrito, agrégalo
  if (!$found) {
    $cart[] = $product;
  }

  $_SESSION[$carrito] = $cart;

  // Preparar una respuesta JSON
  $response = [
    'status' => 'success',
    'message' => 'Producto agregado.'
  ];

  return $response;
}
// ELIMINAR PRODUCTO DEL CARRITO
function removeFromCart($carrito, $id, $token)
{
  if (!isset($_SESSION[$carrito])) {
    $_SESSION[$carrito] = [];
  }

  $cart = $_SESSION[$carrito];

  // Buscar el índice del producto en el carrito
  $productIndex = null;
  foreach ($cart as $index => $product) {
    if ($product['id'] === $id && $product['token'] === $token) {
      $productIndex = $index;
      break;
    }
  }

  if ($productIndex !== null) {
    // Eliminar el producto del carrito
    unset($cart[$productIndex]);
    $_SESSION[$carrito] = array_values($cart); // Reindexar el array
  }

  // Preparar una respuesta JSON
  $response = [
    'status' => 'success',
    'message' => 'Producto eliminado.'
  ];

  return $response;
}
//VACIAR PRODUCTOS DEL CARRITO
function clearCart($carrito)
{
  unset($_SESSION[$carrito]); // Eliminar el carrito de la sesión

  // Preparar una respuesta JSON
  $response = [
    'status' => 'success',
    'message' => 'Carrito limpiado'
  ];

  return $response;
}
//MOSTRAR EL TOTAL GENERAL
function getTotalPrice($carrito)
{
  if (!isset($_SESSION[$carrito])) {
    return 0; // Devolver 0 si el carrito no existe en la sesión
  }

  $cart = $_SESSION[$carrito];
  $totalPrice = 0;

  if (!empty($cart)) {
    foreach ($cart as $product) {
      $totalPrice += $product['price'] * $product['quantity'];
    }
  }

  return $totalPrice;
}
// CANTIDAD EDITABLE EN EL CARRITO
function updateCantidad($carrito, $id, $cantidad, $token)
{
  if (!isset($_SESSION[$carrito])) {
    // Manejar el caso en que el carrito no exista
    $response = [
      'status' => 'error',
      'message' => 'El carrito no existe.'
    ];
    return $response;
  }

  $cart = $_SESSION[$carrito];

  foreach ($cart as &$product) {
    if ($product['id'] === $id && $product['token'] === $token) {
      $product['quantity'] = $cantidad;
      break;
    }
  }

  $_SESSION[$carrito] = $cart;

  $response = [
    'status' => 'success',
    'message' => 'Cantidad actualizada.'
  ];

  return $response;
}
// PRECIO EDITABLE DEL CARRITO
function updatePrice($carrito, $id, $new_price, $token)
{
  if (!isset($_SESSION[$carrito])) {
    // Manejar el caso en que el carrito no exista
    $response = [
      'status' => 'error',
      'message' => 'El carrito no existe.'
    ];
    return $response;
  }

  $cart = $_SESSION[$carrito];

  foreach ($cart as &$product) {
    if ($product['id'] === $id && $product['token'] === $token) {
      $product['price'] = $new_price;
      break;
    }
  }

  $_SESSION[$carrito] = $cart;

  $response = [
    'status' => 'success',
    'message' => 'Precio actualizado.'
  ];

  return $response;
}
// GENERAR SERIE
function generate_numbers($start, $count, $digits)
{
  $result = array();
  for ($n = $start; $n < $start + $count; $n++) {
    $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
  }
  return $result;
}
// CAPTURAR EL NOMBRE DEL DÍA
function get_nombre_dia($fecha)
{
  $fechats = strtotime($fecha); // pasamos a timestamp

  // devuelve número 0 (domingo) a 6 (sábado)
  switch (date('w', $fechats)) {
    case 0:
      return "Domingo";
    case 1:
      return "Lunes";
    case 2:
      return "Martes";
    case 3:
      return "Miércoles";
    case 4:
      return "Jueves";
    case 5:
      return "Viernes";
    case 6:
      return "Sábado";
  }
}

//BUSCAR VALOR EN UN ARRAY
function verificar($valor, $datos = [])
{
  $existe = array_search($valor, $datos, true);
  return is_numeric($existe);
}
//VERIFICAR ROL
function verificarRol($rolRequerido)
{
  session_start();
  if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== $rolRequerido) {
    header('Location: ' . RUTA_PRINCIPAL . 'login');
    exit;
  }
}
