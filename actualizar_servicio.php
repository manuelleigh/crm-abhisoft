<?php
  ?>
<?php
include_once "funciones.php";
$ok = actualizarServicio($_POST["descripcion"], $_POST["precio"], $_POST["id"]);
if (!$ok) {
    echo "Error actualizando.";
} else {
    header("Location: servicios.php");
}
