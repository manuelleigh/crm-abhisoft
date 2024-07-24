<?php
  ?>
<?php include_once "encabezado.php";
include_once "funciones.php";
$clientes = obtenerClientes();
$servicios = obtenerServicios();

?>
<div class="row p-4">
    <div class="col-12">
        <h1>Registrar venta</h1>
        <form action="guardar_venta.php" method="post">
            <div class="form-group">
                <label for="id_cliente">Cliente</label>
                <select required name="id_cliente" id="id_cliente" class="form-control">
                    <?php foreach ($clientes as $cliente) { ?>
                        <option value="<?php echo $cliente->id ?>"><?php echo $cliente->nombre ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_servicio">Servicio</label>
                <select required name="id_servicio" id="id_servicio" class="form-control">
                    <?php foreach ($servicios as $servicio) { ?>
                        <option value="<?php echo $servicio->id ?>" data-monto="<?php echo $servicio->precio ?>">
                            <?php echo $servicio->descripcion ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="monto">Monto</label>
                <input readonly required type="number" class="form-control" placeholder="Monto" name="monto" id="monto">
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input required type="date" value="<?php echo date("Y-m-d") ?>" class="form-control" placeholder="Fecha" name="fecha" id="fecha">
            </div>
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const selectServicio = document.getElementById('id_servicio');
        const inputMonto = document.getElementById('monto');

        selectServicio.addEventListener('change', function() {
            const selectedOption = selectServicio.options[selectServicio.selectedIndex];
            const monto = selectedOption.getAttribute('data-monto');
            inputMonto.value = monto;
        });

        // Inicializar el monto al cargar la página con el primer valor del select
        const firstOption = selectServicio.options[selectServicio.selectedIndex];
        inputMonto.value = firstOption.getAttribute('data-monto');
    });
</script>
<?php include_once "pie.php"; ?>