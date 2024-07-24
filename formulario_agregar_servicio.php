<?php
  ?>
<?php
include_once "encabezado.php";
include_once "funciones.php";
?>
<div class="row p-4">
    <div class="col-12">
        <h1>Agregar Servicio</h1>
        <form action="guardar_servicio.php" method="post" class="pt-2">
            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input required type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion">
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input required type="number" class="form-control" name="precio" id="precio" placeholder="Precio">
            </div>            
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php include_once "pie.php" ?>