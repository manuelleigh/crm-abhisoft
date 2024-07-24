<?php
  ?>
<?php
include_once "funciones.php";
$ok = agregarCliente($_POST["nombre"], $_POST["edad"], $_POST["departamento"], $_POST["dni"], $_POST["correo"]);
if (!$ok) {
    echo "Error registrando.";
} else {
    header("Location: clientes.php");
}
