<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<title></title>
		<script type="text/javascript">
			function init_load(timeoutPeriod){
				document.forms.form_compra.puntos.focus();
				timedRefresh(timeoutPeriod);
			}
			function timedRefresh(timeoutPeriod) {
				setTimeout("location.reload(true);",timeoutPeriod);
			}
			 function isNumberKey(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode
				//alert(charCode);
				if ((charCode < 47 || charCode > 58) && charCode != 13 && charCode != 8) //numeros 0-9, y enter y backspace
					return false;
				return true;
			}
			
			
			function validarForm() {
				var pun = parseInt(document.forms["form_compra"]["puntos"].value);
				var err = "";
				var maxpun = parseInt(document.forms["form_compra"]["maxpuntos"].value);
				if ( pun == ""){
					alert("Debe completar el campo <puntos> \n");
					return false;
				}
				if (pun > maxpun){
					alert("¡El alumno no tiene suficientes puntos!!")
					return false;
				}
				
			}
</script>
	</head>
<?php

include_once "conectar.php";
include_once "funciones.php";

if (!isset($_GET['id']) || (empty($_GET['id']))) {
	if (isset($_POST['puntos']) && !empty($_POST['puntos']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['time']) && !empty($_POST['time'])) {
		//Aca proceso el canje.:P
		
		$puntos = $_POST['puntos'];		

		$puntos = preg_replace('#[^0-9]#','',$puntos);
		if ($puntos > $_POST['maxpuntos']){
			die('¡El alumno no tiene suficientes puntos! &nbsp; <button id="volverBTN" type="button" title="Volver" onclick="history.go(-1)">');
		}
		
		if (empty($puntos))
			die('Debe Ingresar puntos a consumir &nbsp; <button id="volverBTN" type="button" title="Volver" onclick="history.go(-1)">');
		
		$sql2 = "UPDATE `alumnos` SET `puntos`= (`puntos` - " .$puntos. "), `updated`= '".$_POST['time']. "' WHERE ( `id` = ".$_POST['id'].")";
		$sql2p = mysql_query($sql2);
		$affected = mysql_affected_rows();
		
		if (!$sql2p || $affected != 1) {
			die('El usuario ingresado no existe &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
		
		$sql = "INSERT INTO `monto` (`fecha`,`alumno`,`puntos` ) VALUES ('".$_POST['time']."','".$_POST['id']."','".(-$puntos)."')";
		mysql_query($sql);
		$id_puntos = mysql_insert_id();
			
		if ($id_puntos <= 0) {
			die('Error al agregar el canje &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
		else {
		//ACA HAY QUE HACER ALGO PARA QUE TIRE LOS PUNTOS!!!!!!!!!!!!
			die('Canje agregado exitosamente &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
	}
	else {
		die('Esta página no puede ser accedida directamente. Intente hacerlo desde la opcion Busqueda &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
	}
}
else {
	$id = $_GET['id'];
}

if (!is_numeric($id)) { 
	die('Error en ID de alumno. Intente hacerlo desde la opcion Busqueda &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}

$sql = "SELECT nombre, apellido, documento, total, puntos FROM `alumnos` WHERE id = " .$id . " LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
if (!$row) {
	die('Error en ID de alumno. Intente hacerlo desde la opcion Busqueda &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}
$nombre = $row['nombre'];
$apellido = $row['apellido'];
$documento = $row['documento'];
$total = $row['total'];
$maxpuntos = $row['puntos'];
$fecha = fecha2();

?>

	<body onload="JavaScript:init_load(120000);" onsubmit="return validarForm()">
		<table class="DatosCompra">
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
				<td><? echo($maxpuntos);?></td>
			</tr>
		
		<form method="post" action="canje.php" name="form_compra">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input type="hidden" name="maxpuntos" value="<?php echo $maxpuntos;?>">
			<input type="hidden" name="time" value="<?php echo time();?>">
			
				<tr>
					<th colspan="2">
						Canje de puntos
					</th>
				</tr>
				<tr>
					<td>Fecha:</td>
					<td><input type="text" name="fecha" id="fecha" readonly="readonly" value="<? echo($fecha);?>" class="bloqueado"></td>
				</tr>
				<tr>
					<td>Puntos usados:</td>
					<td><input type="text" name="puntos" id="puntos" onkeypress="return isNumberKey(event)"></td>
				</tr>
				<tr colspan=2>
					<td>
						<button id="guardarBTN" type="submit" title="Guardar">Guardar</button>
					</td>
					<td>
						<button id="refrescaBTN" type="button" title="Reiniciar Formulario" onclick="javascript:location.reload(true)">Reiniciar</button>
					</td>
					<td>
						<button id="cerrarBTN" type="button" title="Cerrar" onclick="window.close();">
					</td>
				</tr>		
			</table>			
		</form>
	</body>
</html>