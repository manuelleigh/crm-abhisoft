<?php
  ?>
<?php
include_once "funciones.php";
$ok = agregarServicio($_POST["descripcion"], $_POST["precio"]);
if (!$ok) {
    echo "Error registrando.";
} else {
    header("Location: servicios.php");
}
