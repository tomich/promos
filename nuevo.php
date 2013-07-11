
<script type="text/javascript">
window.onload = function()
{
document.forms.fvalida.nombre.focus();
document.forms.fvalida.nombre.value = "";
document.forms.fvalida.apellido.value = "";
document.forms.fvalida.documento.value = "";

}
function validarForm() {
var nom=document.forms["fvalida"]["nombre"].value;
var ape=document.forms["fvalida"]["apellido"].value;
var doc=document.forms["fvalida"]["documento"].value;
var err = "";
if ( nom == ""){
	err = "Debe completar el campo <nombre> \n"
}
if ( ape == ""){
	err = err + "Debe completar el campo <apellido> \n"
}
if ( doc == ""){
	err = err + "Debe completar el campo <documento> \n"
}
if (err != "") {
	alert(err);
	return false;
}

}


</script>

<form action="ingreso_alumno.php" method="post" name="fvalida" onsubmit="return validarForm()">
	<table>
		<tr>
			<td>Nombre:</td>
			<td><input type="text" name="nombre"></td>
		</tr>
		<tr>
			<td>Apellido:</td>
			<td><input type="text" name="apellido"></td>
		</tr>
		<tr>
			<td>Nº de Documento:</td>
			<td><input type="text" name="documento"></td>
			<td><button id="guardarBTN" type="submit" title="Guardar">Guardar</button></td>
		</tr>	 
	</table>
</form>
