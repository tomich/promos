<?php
include_once("funciones.php");
?>
<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css">
		<title></title>
	</head>
	
	<body>
		<div id="container">
			<div id="header">
			<div id="fecha">
			<?php echo fecha(); ?>
		</div>
		
	<h1>Promociones</h1>
	<div id="navigation">
		<ul>
			<li><a href="index.php?page=buscar">Busqueda</a></li>
			<li><a href="index.php?page=ranking">Ranking</a></li>
			<li><a href="index.php?page=nuevo">Nuevo Alumno</a></li>
			<li><a href="index.php?page=info">Info</a></li>
		</ul>
	</div>
	<div id="content">