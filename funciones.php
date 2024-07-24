<?php
  ?>
<?php

date_default_timezone_set("America/Mexico_City");

function obtenerDepartamentos()
{
    return [
        "Piura",
        "Lima",
        "Chiclayo",
        "Trujillo",
        "Tumbes",
        "Arequipa",
    ];
}
function obtenerBD()
{
    $password = "";
    $user = "root";
    $dbName = "crm";
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}

function agregarCliente($nombre, $edad, $departamento, $dni, $correo)
{
    $bd = obtenerBD();
    $fechaRegistro = date("Y-m-d");
    $sentencia = $bd->prepare("INSERT INTO clientes(nombre, edad, departamento, fecha_registro, dni, correo) VALUES (?, ?, ? ,?, ?, ?)");
    return $sentencia->execute([$nombre, $edad, $departamento, $fechaRegistro, $dni, $correo]);
}

function agregarServicio($descripcion, $precio)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("INSERT INTO servicios(descripcion, precio) VALUES (?, ?)");
    return $sentencia->execute([$descripcion, $precio]);
}

function obtenerClientes()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT id, nombre, edad, departamento, fecha_registro, dni, correo FROM clientes");
    return $sentencia->fetchAll();
}

function obtenerServicios()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT id, descripcion, precio FROM servicios");
    return $sentencia->fetchAll();
}

function buscarClientes($nombre)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT id, nombre, edad, departamento, fecha_registro, dni, correo FROM clientes WHERE nombre LIKE ?");
    $sentencia->execute(["%$nombre%"]);
    return $sentencia->fetchAll();
}


function eliminarCliente($id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("DELETE FROM clientes WHERE id = ?");
    return $sentencia->execute([$id]);
}
function eliminarServicio($id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("DELETE FROM servicios WHERE id = ?");
    return $sentencia->execute([$id]);
}

function obtenerClientePorId($id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT id, nombre, edad, departamento, fecha_registro, dni, correo, idservicio FROM clientes WHERE id = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetchObject();
}
function obtenerServicioPorId($id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT id, descripcion, precio FROM servicios WHERE id = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetchObject();
}
function actualizarCliente($nombre, $edad, $departamento, $dni, $correo, $id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("UPDATE clientes SET nombre = ?, edad = ?, departamento = ?, dni = ?, correo = ? WHERE id = ?");
    return $sentencia->execute([$nombre, $edad, $departamento, $dni, $correo, $id]);
}
function actualizarServicio($descripcion, $precio, $id)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("UPDATE servicios SET descripcion = ?, precio = ? WHERE id = ?");
    return $sentencia->execute([$descripcion, $precio, $id]);
}

function agregarVenta($idCliente, $id_servicio, $monto, $fecha)
{
    $bd = obtenerBD();
    try {
        $bd->beginTransaction();

        $sentencia = $bd->prepare("INSERT INTO ventas_clientes(id_cliente, monto, fecha) VALUES (?, ?, ?)");
        $resultado1 = $sentencia->execute([$idCliente, $monto, $fecha]);
        $sentencia2 = $bd->prepare("UPDATE clientes SET idservicio = ? WHERE id = ?");
        $resultado2 = $sentencia2->execute([$id_servicio, $idCliente]);

        if ($resultado1 && $resultado2) {
            $bd->commit();
            return true;
        } else {
            $bd->rollBack();
            return false;
        }
    } catch (Exception $e) {
        $bd->rollBack();
        throw $e;
    }
}

function totalAcumuladoVentasPorCliente($idCliente)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ?");
    $sentencia->execute([$idCliente]);
    return $sentencia->fetchObject()->total;
}

function totalAcumuladoVentasPorClienteEnUltimoMes($idCliente)
{
    $inicio = date("Y-m-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ? AND fecha >= ?");
    $sentencia->execute([$idCliente, $inicio]);
    return $sentencia->fetchObject()->total;
}
function totalAcumuladoVentasPorClienteEnUltimoAnio($idCliente)
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ? AND fecha >= ?");
    $sentencia->execute([$idCliente, $inicio]);
    return $sentencia->fetchObject()->total;
}
function totalAcumuladoVentasPorClienteAntesDeUltimoAnio($idCliente)
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes WHERE id_cliente = ? AND fecha < ?");
    $sentencia->execute([$idCliente, $inicio]);
    return $sentencia->fetchObject()->total;
}

function obtenerNumeroTotalClientes()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT COUNT(*) AS conteo FROM clientes");
    return $sentencia->fetchObject()->conteo;
}
function obtenerNumeroTotalClientesUltimos30Dias()
{
    $hace30Dias = date("Y-m-d", strtotime("-30 day"));
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
    $sentencia->execute([$hace30Dias]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerNumeroTotalClientesUltimoAnio()
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro >= ?");
    $sentencia->execute([$inicio]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerNumeroTotalClientesAniosAnteriores()
{
    $inicio = date("Y-01-01");
    $bd = obtenerBD();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM clientes WHERE fecha_registro < ?");
    $sentencia->execute([$inicio]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerTotalDeVentas()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT COALESCE(SUM(monto), 0) AS total FROM ventas_clientes");
    return $sentencia->fetchObject()->total;
}

function obtenerClientesPorDepartamento()
{
    $bd = obtenerBD();
    $sentencia = $bd->query("SELECT departamento, COUNT(*) AS conteo FROM clientes GROUP BY departamento");
    return $sentencia->fetchAll();
}

function obtenerConteoClientesPorRangoDeEdad($inicio, $fin)
{
    $bd = obtenerBD();
    $sentencia = $bd->prepare("select count(*) AS conteo from clientes WHERE edad >= ? AND edad <= ?;");
    $sentencia->execute([$inicio, $fin]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerVentasAnioActualOrganizadasPorMes()
{
    $bd = obtenerBD();
    $anio = date("Y");
    $sentencia = $bd->prepare("select MONTH(fecha) AS mes, COUNT(*) AS total from ventas_clientes WHERE YEAR(fecha) = ? GROUP BY MONTH(fecha);");
    $sentencia->execute([$anio]);
    return $sentencia->fetchAll();
}

function obtenerReporteClientesEdades()
{
    $rangos = [
        [1, 10],
        [11, 20],
        [20, 40],
        [40, 80],
    ];
    $resultados = [];
    foreach ($rangos as $rango) {
        $inicio = $rango[0];
        $fin = $rango[1];
        $conteo = obtenerConteoClientesPorRangoDeEdad($inicio, $fin);
        $dato = new stdClass;
        $dato->etiqueta = $inicio . " - " . $fin;
        $dato->valor = $conteo;
        array_push($resultados, $dato);
    }
    return $resultados;
}
