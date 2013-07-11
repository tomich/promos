<script type="text/javascript">
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<?php

function fecha($time = false) {
	if (!$time) {
		$time = time();
	}
	$vect = getdate($time);
	$vect_dia = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&#225;bado");
	$vect_mes = array('',"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return $vect_dia[$vect['wday']].", ".$vect['mday']." de ".$vect_mes[$vect['mon']]." de ".$vect['year'];
}

function siteUrl($url) {
	return BASE_URL . $url;
}

function fecha2($time = false) {
	if (!$time) {
		$time = time();
	}
	$val_fecha = date("d/m/y  H:i:s", $time);
	return $val_fecha;
}