<?php

//error_reporting(0);
require_once 'funciones.php';

require_once "conectar.php";

include_once "barra.php";

if (empty($_GET) || !isset($_GET['page'])) {
	include_once 'inicio.php';
}
else {
	$page = $_GET['page'];
	$page_array = array( "nuevo", "buscar" , "ranking", "info" );

	if (!$page || $page == 'index'){
		include_once 'inicio.php';
	}
	elseif (in_array($page, $page_array)) {
		include $page . '.php';
	}
	else{
		//No encontrado?
		echo '<p>Error 404: Página no encontrada</p>';
	}
}
include_once "footer.php";

?>
