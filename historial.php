<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<title></title>
	</head>

<?php 
include_once("conectar.php");
include_once("funciones.php");
if (!isset($_GET['id']) || (empty($_GET['id']))) {
	die('No ha especificado un alumno &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}
else {
	if (isset($_GET['limit']) && (!empty($_GET['limit']))) {
	$ultimos = $_GET['limit'];
	}
	else {
	$ultimos = "10";
	}
	switch ($ultimos) {
	case "10":
			$limit = "LIMIT 0,10";
			break;
		case "20":
			$limit = "LIMIT 0,20";
			break;
		case "50":
			$limit = "LIMIT 0,50";
			break;
		case "todos":
			$limit = "";
			break;
		default:
			$limit = "LIMIT 0,10";
	}
}
$id_alumno = $_GET['id'];
$sql="SELECT fecha, monto, puntos FROM `monto` WHERE alumno =". $id_alumno ." ORDER BY fecha DESC " . $limit ;
$result = mysql_query($sql);
if (!$result) {
die('Error: Alumno no encontrado &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}
else {
$sql2 = "SELECT nombre, apellido, documento, total, puntos FROM `alumnos` WHERE id = " .$id_alumno . " LIMIT 1";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($result2);
$nombre = $row2['nombre'];
$apellido = $row2['apellido'];
$documento = $row2['documento'];
$total = $row2['total'];
$puntos = $row2['puntos'];
if (!$row2) {
	die('Error en ID de alumno. Intente hacerlo desde la opcion Busqueda &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}
}

 ?>

	<body onLoad="document.formulario.limit.focus()">
		<table class="DatosCompraBorra" align="center">
			<tr>
				<th colspan="2" align="center">Alumno</th>
			</tr>
			<tr class="par">
				<td>Nombre:</td>
				<td><? echo($nombre);?></td>
			</tr>
			<tr class="impar">
				<td>Apellido:</td>
				<td><? echo($apellido);?></td>
			</tr>
			<tr class="par">
				<td>Documento:</td>
				<td><? echo($documento);?></td>	
			</tr>
			<tr class="impar">
				<td>Total Gastado:</td>
				<td>$<? echo($total/100);?></td>
			</tr>
			<tr class="par">
				<td>Puntos disponibles:</td>
				<td><? echo($puntos);?></td>
			</tr>
		</table>
	
	
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get" name="formulario">
			Mostrar ultimas  
			<input type='hidden' name='id' value='<?php echo $_GET['id']; ?>' />
			<select name="limit">
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="todos">Todas</option>
			</select>
			Operaciones
			<button id="buscarBTN" type="submit" title="Ver">Ver</button>
			<button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">Cerrar</button>
		</form>


			<div id="resultado">
			<table class="result" width="100%" cellspacing=0 cellpadding=3 border=0 ID="tabla1">
				<tr class="cabeceraTabla">
					<th width="30%">Fecha</th>
					<th width="11%">Monto</th>
					<th width="11%">Puntos</th>					
				</tr>
<?php 


while ($row = mysql_fetch_assoc($result)) {
?>  
		<tr class="contenidoTabla">
		<td width="30%"><?php echo fecha2($row['fecha']); ?></td>
		<td width="11%">$<?php echo ($row['monto']/100); ?></td>
		<td width="11%"><?php echo ($row['puntos']); ?></td>
		</tr> 
<?php
}
?>					
				
			</table>
			</div>
	</body>
</html>