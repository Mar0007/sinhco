<?php
	global $mysqli;
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1)
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}		
?>

<h1 class="blue-text text-darken-1"><i class="material-icons medium left">home</i>Inicio</h1>
