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
		case 1: //Consulta	
		case 2: //Insertar		
		case 3: //Actualizar
		case 4: //Eliminar Album
				$IDAlbum = $_POST["IDAlbum"];
				$strSQL = "DELETE FROM mod_galeria_albumes WHERE idalbum = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('i',$IDAlbum);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;
		case 5: //Modificar Album
				$IDAlbum = $_POST["IDAlbum"];
				$Titulo = $_POST["Titulo"];
				$strSQL = "UPDATE mod_galeria_albumes SET descripcion = ? WHERE idalbum = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('si',$Titulo,$IDAlbum);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;
		case 6: //Eliminar Imagen
				$IDAlbum = $_POST["IDAlbum"];
				$IDImagen = $_POST["IDImagen"];
				$strSQL = "DELETE FROM mod_galeria_albumesdetalle WHERE idalbum = ? and idimagen = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ii',$IDAlbum,$IDImagen);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;
		case 7: //Modificar Imagen
				$IDAlbum = $_POST["IDAlbum"];
				$IDImagen = $_POST["IDImagen"];
				$Titulo = $_POST["Titulo"];
				$strSQL = "UPDATE mod_galeria_albumesdetalle SET descripcion = ? WHERE idalbum = ? and idimagen = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sii',$Titulo,$IDAlbum,$IDImagen);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;				
								
				
	}	
?>