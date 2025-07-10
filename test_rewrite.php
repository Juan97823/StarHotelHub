<?php
echo "<h2>🔍 Verificando mod_rewrite y .htaccess...</h2>";

if (in_array('mod_rewrite', apache_get_modules())) {
    echo "✅ <strong>mod_rewrite está habilitado en Apache.</strong><br>";
} else {
    echo "❌ <strong>mod_rewrite NO está habilitado.</strong><br>";
}

echo "<hr>";

if (isset($_GET['rewrite_test'])) {
    echo "✅ <strong>La reescritura de URLs SÍ está funcionando.</strong><br>";
} else {
    echo "❌ <strong>La reescritura de URLs NO está funcionando.</strong><br>";
    echo "🔁 <a href='test_rewrite.php/rewrite_test=1'>Haz clic aquí para probar la reescritura</a><br>";
}
?>
