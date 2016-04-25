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
	//1 = Consulta; 2 = Insertar; 3 = Actualizar; 4 = Eliminar;
	$accion = $_GET["accion"];

	switch($accion)
	{
		case 1: // Consulta	
				break;		
		case 2: // Insertar
				break;
		case 3: //Actualizar
				$idusuario 	= $_POST["idusuario"];
				$usuario   	= $_POST["nombre"];
				$email   	= $_POST["email"];
				//$nacimiento = $_POST["nacimiento"];
				//$admin   	= (isset($_POST["admin"])) ? true : false;
				$estado   	= (isset($_POST["estado"])) ? true : false;
				$password   = $_POST["password"];
				$imagen		= $_FILES['imagen']['tmp_name'];
				
				//echo "Imagen->".$imagen."<br>";
				
				if($imagen != "")
				{
					$target_dir = "../../uploads/avatars/";
					$imageFileType = pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);  										
					$target_file = $target_dir.$idusuario.".".$imageFileType;
					//echo "Imagen->".$target_file."<br>";
					if(!move_uploaded_file($imagen,$target_file))
					{
						echo "<h5> Imagen no fue actualizada </h5>";
					}
					else
					{
						foreach(glob("../../uploads/avatars/".GetStrWithRange($idusuario).".*") as $Img)
						{
							if($Img != $target_file)
								unlink($Img);
						}
					}
				}												
				
				if($password != "")
				{
					//Encriptacion
					$llave = hash('sha512',rand());
					//$passw = hash('sha512',$password);
					$password = hash('sha512',$password . $llave);
					$strSQL   = "UPDATE usuarios 
								 SET nombre = ?, email = ?, estado = ?, password = ?, llave = ? 
								 WHERE idusuario = ?";
				}
				else
					$strSQL   = "UPDATE usuarios 
								 SET nombre = ?, email = ?, estado = ? 
								 WHERE idusuario = ?";
									
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					if($password != "")
						$stmt->bind_param('ssisss',$usuario,$email,$estado,$password,$llave,$idusuario);
					else
						$stmt->bind_param('ssis',$usuario,$email,$estado,$idusuario);
						
					$stmt->execute();
					
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
					}
					else
					{
						echo "0";
					}										
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
						
				break;		
		case 4: //Eliminar
				break;
				
	}
?>