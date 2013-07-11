<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<title></title>
	</head>

<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
include_once ("conectar.php");
include_once ("barra.php");

if (empty($_POST)) {
	header("Location: index.php");
	exit;
}
elseif (!isset($_POST['apellido']) || empty($_POST['apellido']) || strlen($_POST['apellido']) > 32) {
	die('Error en el Apellido. <button id="volverBTN" type="button" title="Volver" onclick="window.location=\'index.php?page=nuevo\'">');
}
elseif (!isset($_POST['nombre']) || empty($_POST['nombre']) || strlen($_POST['nombre']) > 32) {
	die('Error en el Nombre. <button id="volverBTN" type="button" title="Volver" onclick="window.location=\'index.php?page=nuevo\'">');
}
elseif (!isset($_POST['documento']) || empty($_POST['documento']) || strlen($_POST['documento']) > 32 || strlen($_POST['documento']) < 5 || !(is_numeric(($_POST['documento']))))  {
	die('Error en el DNI. <button id="volverBTN" type="button" title="Volver" onclick="window.location=\'index.php?page=nuevo\'">');
}


$sql = "INSERT INTO `alumnos` (`nombre`,`apellido`, `documento`) VALUES ('".$_POST['nombre']."','".$_POST['apellido']."','".$_POST['documento']."')";

mysql_query($sql);

$id = mysql_insert_id();

if ($id > 0) {
	echo ('Alumno/a '.$_POST['nombre'].' '.$_POST['apellido'].', Documento Nº '.$_POST['documento'].' agregado/a correctamente. <button id="volverBTN" type="button" title="Volver" onclick="window.location=\'index.php?page=nuevo\'">');
	//success
}
else {
	echo('Error al agregar alumno. <button id="volverBTN" type="button" title="Volver" onclick="window.location=\'index.php?page=nuevo\'">');
}
include_once ("footer.php");
