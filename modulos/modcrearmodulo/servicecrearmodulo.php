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
				
				$strSQL   = "INSERT INTO modulos(idmodulo, modulo, tipo, contenido) VALUES (?, ?, 0, ?);";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sss',$idmodulo,$modulo,$contenido);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
					}
					else
						echo "0";						
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
					
				break;
		case 3: //Actualizar
				$idmodulo 	= $_POST["idmodulo"];
				$modulo   	= $_POST["titulo"];
				$contenido  = $_POST["contenido"];
				
				$strSQL   = "UPDATE modulos SET modulo = ?,contenido = ? WHERE idmodulo = ?;";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sss',$modulo,$contenido,$idmodulo);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
					}
					else
						echo "0";						
				}
				else
					echo "Error en la consulta: " . $mysqli->error;							
				break;
		case 4: //Eliminar
				break;
				
	}	
?>