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
				$titulo   	= $_POST["titulo"];
				$estado   	= $_POST["estado"];
				$tags   	= $_POST["tags"];				
				$contenido  = $_POST["contenido"];
				$idusuario  = $_SESSION["idusuario"];
				
				$strSQL   = "INSERT INTO mod_articulos(fecha,titulo, estado, tags, contenido, idusuario) VALUES (NOW(),?, ?, ?, ?, ?);";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sisss',$titulo,$estado,$tags,$contenido,$idusuario);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";						
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
					
				break;
		case 3: //Actualizar
				$idarticulo	= $_POST["idarticulo"];
				$titulo   	= $_POST["titulo"];
				$estado   	= $_POST["estado"];
				$tags   	= $_POST["tags"];				
				$contenido  = $_POST["contenido"];
				
				if($idarticulo == ""){ 
				echo "Error!"; return;
				}
				
				$strSQL   = "UPDATE mod_articulos SET titulo = ?,estado = ?,tags = ?,contenido = ? WHERE idarticulo = ?;";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sisss',$titulo,$estado,$tags,$contenido,$idarticulo);
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