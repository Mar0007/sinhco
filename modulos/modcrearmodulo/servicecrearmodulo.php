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
		echo "<h2>No tiene permisos para ver este modulo.</h2>";
		return;
	}	
	$accion = $_GET["accion"];
	
	switch($accion)
	{
		case 1: // Consulta
				break;			
		case 2: // Insertar
				$idmodulo 	= $_POST["idmodulo"];
				$modulo   	= $_POST["titulo"];
				$contenido  = $_POST["contenido"];
				
				$mysqli->insert("modulos",
				[
					"idmodulo" => $idmodulo,
					"modulo" => $modulo,
					"tipo" => "0",
					"contenido" => $contenido
				]);
				if( CheckDBError($mysqli) ) return;
				
				echo "0";
					
				break;
		case 3: //Actualizar
				$idmodulo 	= $_POST["idmodulo"];
				$modulo   	= $_POST["titulo"];
				$contenido  = $_POST["contenido"];
				
				$mysqli->update("modulos",
				[
					"modulo" => $idmodulo,
					"contenido" => $contenido
				],
				[
					"idmodulo" => $idmodulo
				]);
				
				if( CheckDBError($mysqli) ) return;
				
				echo "0";
				
				break;
		case 4: //Eliminar
				break;
				
	}	
?>