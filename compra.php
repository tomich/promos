<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<title></title>
		<script type="text/javascript">
			function init_load(timeoutPeriod){
				document.forms.form_compra.monto.focus();
				timedRefresh(timeoutPeriod);
			}
			function timedRefresh(timeoutPeriod) {
				setTimeout("location.reload(true);",timeoutPeriod);
			}
			 function isNumberKey(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode
				if ((charCode < 46 || charCode > 58) && charCode != 13 && charCode != 8) //numeros 0-9, punto, y enter y backspace
					return false;
				return true;
			}
			
			
			function validarForm() {
				var mon = document.forms["form_compra"]["monto"].value;
				var err = "";
				if ( mon == ""){
					alert("Debe completar el campo <monto> \n");
					return false;
				}

			}
</script>
	</head>
<?php

include_once "conectar.php";
include_once "funciones.php";

if (!isset($_GET['id']) || (empty($_GET['id']))) {
	if (isset($_POST['monto']) && !empty($_POST['monto']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['time']) && !empty($_POST['time'])) {
		//Aca proceso la compra.:P
		
		$monto = $_POST['monto'];
		
		$monto = str_replace(',','.',$monto);
		
		$pos = strrpos($monto,'.');
		$tot = strlen($monto);

		$monto = preg_replace('#[^0-9]#','',$monto);

		$left = $tot - $pos - 1;
		
		if (empty($monto))
			die('Debe Ingresar un monto &nbsp; <button id="volverBTN" type="button" title="Volver" onclick="history.go(-1)">');
		if ($pos === false || $left == 0)
			$monto .= '00';
		elseif ($left === 1)
			$monto .= '0';
		elseif ($left === 2)
			$foo;
		else
			die('Wow! Demasiadas cifras despues del punto o coma. <button id="volverBTN" type="button" title="Volver" onclick="history.go(-1)">');

		$sql2 = "UPDATE `alumnos` SET `total`= (`total` + " .$monto. "), `updated`= '".$_POST['time']. "', `puntos`= (`puntos` + " .intval($monto/1000). ") WHERE ( `id` = ".$_POST['id'].")";
		$sql2p = mysql_query($sql2);
		$affected = mysql_affected_rows();
		
		if (!$sql2p || $affected != 1) {
			die('El usuario ingresado no existe &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
		
		$sql = "INSERT INTO `monto` (`fecha`,`alumno`, `monto`,`puntos` ) VALUES ('".$_POST['time']."','".$_POST['id']."','".$monto."','".intval($monto/1000)."')";
		mysql_query($sql);
		$id_monto = mysql_insert_id();
			
		if ($id_monto <= 0) {
			die('Error al agregar la compra &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
		}
		else {
		//ACA HAY QUE HACER ALGO PARA QUE TIRE LOS PUNTOS!!!!!!!!!!!!
			die('Compra agregada exitosamente &nbsp; <button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">');
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
$puntos = $row['puntos'];



$fecha = fecha2();

?>

	<body onload="JavaScript:init_load(120000);" onsubmit="return validarForm()">
		<table class="DatosCompraBorra">
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
		
		<form method="post" action="compra.php" name="form_compra">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input type="hidden" name="time" value="<?php echo time();?>">
			
				<tr>
					<th colspan="2">
						Nueva Compra
					</th>
				</tr>
				<tr>
					<td>Fecha:</td>
					<td><input type="text" name="fecha" id="fecha" readonly="readonly" value="<? echo($fecha);?>" class=	"bloqueado"></td>
				</tr>
				<tr>
					<td>Monto:</td>
					<td>$<input type="text" name="monto" id="monto" onkeypress="return isNumberKey(event)"></td>
				</tr>
				<tr colspan=2>
					<td>
						<button id="guardarBTN" type="submit" title="Guardar">Guardar</button>
					</td>
					<td>
						<button id="refrescaBTN" type="button" title="Reiniciar Formulario" onclick="javascript:location.reload(true)">Reiniciar</button>
					</td>
					<td>
						<button id="cerrarBTN" type="button" title="Cerrar" onclick="javascript:window.close();">Cerrar</button>
					</td>
				</tr>		
			</table>			
		</form>
	</body>
</html>