<?php
  ?>
<?php
include_once "funciones.php";
$ok = eliminarServicio($_GET["id"]);
if (!$ok) {
    echo "Error eliminando";
} else {
    header("Location: servicios.php");
}
