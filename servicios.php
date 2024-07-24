<?php
  ?>
<?php
include_once "encabezado.php";
include_once "funciones.php";
if (!isset($_GET["busqueda"]) || empty($_GET["busqueda"])) {
    $servicios = obtenerServicios();
} else {
    $servicios = buscarClientes($_GET["busqueda"]);
}
?>
<div class="row p-4">
    <div class="col-12">
        <h1>Servicios</h1>
        <a href="formulario_agregar_servicio.php" class="btn btn-success mb-2">Agregar</a>
        <form action="servicios.php">
            <div class="form-row align-items-center">
                <div class="col-6 my-1">
                    <input value="<?php echo isset($_GET["busqueda"]) && !empty($_GET["busqueda"]) ?  $_GET["busqueda"] : "" ?>" name="busqueda" class="form-control" type="text" placeholder="Buscar Servicio por nombre">
                </div>
                <div class="col-auto my-1">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>

                <tr>
                    <th>ID</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicios as $servicio) { ?>
                    <tr>
                        <td><?php echo $servicio->id ?></td>
                        <td><?php echo $servicio->descripcion ?></td>
                        <td>$<?php echo $servicio->precio ?></td>
                        <td>
                            <a class="btn btn-warning" href="formulario_editar_servicio.php?id=<?php echo $servicio->id ?>">Editar</a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="eliminar_servicio.php?id=<?php echo $servicio->id ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once "pie.php" ?>