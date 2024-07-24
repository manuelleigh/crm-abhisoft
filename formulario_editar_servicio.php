<?php
  ?>
<?php
include_once "encabezado.php";
include_once "funciones.php";
$servicio = obtenerServicioPorId($_GET["id"]);
?>
<div class="row p-4">
    <div class="col-12">
        <h1>Editar Servicio</h1>
        <form action="actualizar_servicio.php" method="post">
            <input type="hidden" name="id" value="<?php echo $servicio->id ?>">
            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input value="<?php echo $servicio->descripcion ?>" required type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion">
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input value="<?php echo $servicio->precio ?>" required type="number" class="form-control" name="precio" id="precio" placeholder="Precio">
            </div>
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php include_once "pie.php" ?>