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
				
				$strSQL   = "INSERT INTO bloques(idbloque, bloque, tipo, contenido) VALUES (?, ?, 0, ?);";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sss',$idbloque,$bloque,$contenido);
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
				$idbloque 	= $_POST["idbloque"];
				$bloque   	= $_POST["titulo"];
				$contenido  = $_POST["contenido"];
				
				$strSQL   = "UPDATE bloques SET bloque = ?,contenido = ? WHERE idbloque = ?;";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sss',$bloque,$contenido,$idbloque);
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