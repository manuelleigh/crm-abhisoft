<?php
  ?>
<?php
include_once "encabezado.php";
include_once "funciones.php";
$departamentos = obtenerDepartamentos();
?>
<div class="row p-4">
    <div class="col-12">
        <h1>Agregar cliente</h1>
        <form action="guardar_cliente.php" method="post">
            <div class="form-group">
                <label for="dni">DNI</label>
                <input required type="text" class="form-control" name="dni" id="dni" placeholder="DNI">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input required type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
            </div>
            <div class="form-group">
                <label for="edad">Edad</label>
                <input required type="number" class="form-control" name="edad" id="edad" placeholder="Edad">
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input required type="text" class="form-control" name="correo" id="correo" placeholder="Correo">
            </div>
            <div class="form-group">
                <label for="departamento">Departamento</label>
                <select class="form-control" name="departamento" id="departamento">
                    <?php foreach ($departamentos as $departamento) { ?>
                        <option value="<?php echo $departamento ?>"><?php echo $departamento ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <button class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php include_once "pie.php" ?>
<script>
    // Lea si el dni es de 8 digitos ejecute una accion con fetch para no tener que recargar la pagina
    document.querySelector("#dni").addEventListener("blur", async () => {
        const dni = document.querySelector("#dni").value;
        if (dni.length === 8) {
            // const respuesta = await fetch(`verificar_dni.php?dni=${dni}`);
            // const { existe } = await respuesta.json();
            // if (existe) {
            //     alert("El DNI ya existe en la base de datos");
            // }
            // apis-token-9660.UmHcExv7ZPMtri7UOubK5dro3zqMUrH8
            // Consulta fetch a la API
            const respuesta = await fetch(`apiconsulta.php?dni=${dni}`);
            if (respuesta.ok) {
                const texto = await respuesta.json();
                const datapersona = texto.nombres + " " + texto.apellidoPaterno + " " + texto.apellidoMaterno;
                document.querySelector("#nombre").value = datapersona;
            } else {
                console.error('Error en la consulta:', respuesta.statusText);
            }
        }
    });
</script>