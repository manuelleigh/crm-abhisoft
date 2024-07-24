<?php
  ?>
<?php
include_once "funciones.php";
$ok = actualizarCliente($_POST["nombre"], $_POST["edad"], $_POST["departamento"], $_POST["dni"], $_POST["correo"], $_POST["id"]);
if (!$ok) {
    echo "Error actualizando.";
} else {
    header("Location: clientes.php");
}
