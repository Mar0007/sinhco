<?php
	require_once("../../config.php");
	require_once("../../funciones.php");	
	inicio_sesion();
	
	if(!login_check($mysqli))
	{
		echo "<h2>Acceso denegado</h2>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<h2>No tiene permisos para ver este Modulo.</h2>";
		return;
	}	
	$accion = $_GET["accion"];
	
	switch($accion)
	{
		case 1: // Consulta
				break;			
		case 2: // Insertar
				$idbloque 	= $_POST["idbloque"];
				$bloque   	= $_POST["titulo"];
				$contenido  = $_POST["contenido"];
				
				
				$mysqli->insert("bloques",
				[
					"idbloque" => $idbloque,
					"bloque" => $bloque,
					"tipo" => "0",
					"contenido" => $contenido
				]);
				
				if( CheckDBError($mysqli) ) return;
				
				echo "0";
				break;
		case 3: //Actualizar
				$idbloque 	= $_POST["idbloque"];
				$bloque   	= $_POST["titulo"];
				$contenido  = $_POST["contenido"];
				
				$mysqli->update("bloques",
				[
					"bloque" => $bloque,
					"contenido" => $contenido					
				],
				[
					"idbloque" => $idbloque
				]);
				if( CheckDBError($mysqli) ) return;
				
				echo "0";
				break;
		case 4: //Eliminar
				break;
				
	}	
?>