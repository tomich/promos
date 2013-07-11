<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<title></title>
		<script type="text/javascript">
			function validarBorrado() {
				var check = document.forms["form_borra"]["check"].checked;
				var dniok = document.forms["form_borra"]["realdni"].value;
				var dni = document.forms["form_borra"]["documento"].value;
				var erralert = "";
				if (!check){
					erralert= erralert + "Debe aceptar la casilla de borrado \n";
				}
				if (dni != dniok){
					erralert= erralert + "El documento ingresado es incorrecto. \n";
				}
				if (erralert != ""){
					alert(erralert);
					return false;
				}
				
			}
		</script>
		
	</head>

<?php 
include_once("conectar.php");

if (!isset($_GET['id']) || (empty($_GET['id']))) {
	if (isset($_POST['check']) && !empty($_POST['check']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['documento']) && !empty($_POST['documento'])) {
		//Aca proceso el borrado.:P
		if ($_POST['check'] == "z32jkllmrtzsdf"){
		$sql = "DELETE FROM `alumnos` WHERE ( `id` = ".$_POST['id']." AND `documento` = ".$_POST['documento'].")";
		$sqlp = mysql_query($sql);
		$affected = mysql_affected_rows();
			if (!$sqlp || $affected != 1) {
				die('El usuario ingresado no existe o ingresó incorrectamente el documento &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
			}
			else {
			//borrado
				die('El alumno fue borrado &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
			}
		}
		else {
			die('Verifique el formulario. Comience el proceso de nuevo. &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
	}
	else{
		die('No ha especificado un alumno &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
	}
}
else {
	$id=$_GET['id'];
}
/////////////////////////
if (!is_numeric($id)) { 
	die('Error en ID de alumno. Intente hacerlo desde la opcion Busqueda &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}

$sql = "SELECT nombre, apellido, documento, total, puntos FROM `alumnos` WHERE id = " .$id . " LIMIT 1";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
if (!$row) {
	die('Error en ID de alumno. Intente hacerlo desde la opcion Busqueda &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}
if (isset($_POST['check']) && !empty($_POST['check']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['documento']) && !empty($_POST['documento'])) {
		//Aca proceso el borrado.:P
	if ($_POST['check'] == "z32jkllmrtzsdf"){
	$sql = "DELETE FROM `alumnos` WHERE ( `id` = ".$_POST['id']." AND `documento` = ".$_POST['documento'].")";
	$sqlp = mysql_query($sql);
	$affected = mysql_affected_rows();
		if (!$sqlp || $affected != 1) {
			die('El usuario ingresado no existe o ingresó incorrectamente el documento &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
		else {
		//borrado
			die('El alumno fue borrado &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
	}
	else {
		die('Verifique el formulario. Comience el proceso de nuevo. &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
	}
}
$nombre = $row['nombre'];
$apellido = $row['apellido'];
$documento = $row['documento'];
$total = $row['total'];
$puntos = $row['puntos'];
//////////////////

$result = mysql_query($sql);
if (!$result) {
die('Error: Alumno no encontrado &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
}

 ?>
	<body onsubmit="return validarBorrado()">
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
	
	
	<form  method="post" action="borrar.php" name="form_borra">
		<input type="hidden" name="id" value="<?php echo $id;?>">
		<input type="hidden" name="realdni" value="<?php echo $documento;?>">
		
		
		
			<tr><th colspan=2>¿Realmente Desea Borrar al Alumno?</th></tr>
			<tr>
				<td colspan=3>Todos los datos de este alumno serán borrados permanentemente. Se perderán todos los puntos acumulados</td>
			</tr>
			<tr>
			<td> </td>
			</tr>
			<tr>
				<td>Documento:</td>
				<td><input type="text" name="documento" id="documento"></td>
			</tr>
			<tr>
				<td align="right"><input type="checkbox" name="check" id="check" value="z32jkllmrtzsdf"></td>
				<td align="left">Estoy de acuerdo, borrar.</td>
			</tr>
			<tr>
				<td><input type="submit" value="Borrar"></td>
				<td><button type="button" title="Cancelar" onclick="javascript:window.close();">Cancelar</button></td>
				<td><button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">Cerrar</button></td>
		</table>
	</form>

	</body>
</html>