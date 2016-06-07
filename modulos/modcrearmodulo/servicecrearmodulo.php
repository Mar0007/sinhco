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
				$desc  		= $_POST["descripcion"];
				
				if($mysqli->has("modulos",["idmodulo" => $idmodulo]))
				{					
					echo "104";
					return;
				}
				
				$mysqli->insert("modulos",
				[
					"idmodulo" => $idmodulo,
					"modulo" => $modulo,
					"tipo" => "0",
					"contenido" => $contenido,
					"descripcion" => $desc
				]);
				if( CheckDBError($mysqli) ) return;
				
				echo "0";
					
				break;
		case 3: //Actualizar
				$InitID 	= $_POST["idinit"];
				$idmodulo 	= $_POST["idmodulo"];
				$modulo   	= $_POST["titulo"];
				$contenido  = $_POST["contenido"];
				$desc  		= $_POST["descripcion"];
				
				if($InitID != $idmodulo && $mysqli->has("modulos",["idmodulo" => $idmodulo]))
				{					
					echo "104";
					return;
				}
				
				
				$mysqli->update("modulos",
				[
					"idmodulo" => $idmodulo,
					"modulo" => $modulo,
					"contenido" => $contenido,
					"descripcion" => $desc
				],
				[
					"idmodulo" => $InitID
				]);
				
				if( CheckDBError($mysqli) ) return;
				
				echo "0";
				
				break;
		case 4: //Eliminar
				break;
				
	}	
?>