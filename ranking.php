<?php 
include_once("conectar.php");
include_once("funciones.php");
include_once("barra.php");

if (isset($_POST['top']) && (!empty($_POST['top']))) {
	$top = $_POST['top'];
	switch ($_POST['top']) {
		case "5":
			$top = "LIMIT 0,5";
			break;
		case "10":
			$top = "LIMIT 0,10";
			break;
		case "20":
			$top = "LIMIT 0,20";
			break;
		case "50":
			$top = "LIMIT 0,50";
			break;
		case "todos":
			$top = "";
			break;
		default:
			$top = "LIMIT 0,5";
	}
}
else {
	$top="LIMIT 0,5";
}
$sql = "SELECT id, nombre, apellido, documento, total, puntos FROM `alumnos` ORDER BY total DESC " . $top ;
$result = mysql_query($sql);
?>

<body onLoad="document.formulario.top.focus()">
	<form action="index.php?page=ranking" method="post" name="formulario">
	Mostrar 
		<select name="top">
			<option value="5">5</option>
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="50">50</option>
			<option value="todos">Todos</option>
		</select>
		<button id="buscarBTN" type="submit" title="Buscar">Buscar</button>
	</form>


	<div id="resultado">
		<table class="result" width="100%" cellspacing=0 cellpadding=3 border=0 ID="tablarank">
				<tr>
					<th width="11%">Apellido</th>
					<th width="11%">Nombre</th>
					<th width="11%">Documento</th>
					<th width="7%">Total Gastado</th>	
					<th width="6%">Puntos Disponibles</th>
					<th width="3%" colspan=3>Acciones</th>
				</tr>
<?php 

$n=1;
$par="par";
while ($row = mysql_fetch_assoc($result)) {
$n++;
if($n % 2) {
    $par="par";
} else {
    $par="impar";
}
 ?>
 
		<tr class="<?php echo $par; ?>">
			<td width="11%"><?php echo $row['apellido']; ?></td>
			<td width="11%"><?php echo $row['nombre']; ?></td>
			<td width="11%"><?php echo $row['documento']; ?></td>
			<td width="7%">$<?php echo ($row['total']/100); ?></td>
			<td width="6%"><?php echo ($row['puntos']); ?></td>			
			<td width="1%"><button id="sumarBTN" type="button" title="Sumar Puntos" onClick="PopupCenter('compra.php?id=<?php echo $row['id']; ?>','comprapop',400,300)">Sumar Puntos</button></td>
			<td width="1%"><button id="canjeBTN" type="button" title="Canjear Puntos" onClick="PopupCenter('canje.php?id=<?php echo $row['id']; ?>','canjepop',400,300)">Canjear Puntos</button></td>
			<td width="1%"><button id="historialBTN" type="button" title="Ver Historial" onClick="PopupCenter('historial.php?id=<?php echo $row['id']; ?>','historypop',400,300)">Historial</button></td>
		</tr> 
<?php
}
?>					
				
		</table>
	</div>
<? include_once("footer.php");?>