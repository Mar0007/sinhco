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
				$nombre   	= $_POST["nombre"];
                $apellido  	= $_POST["apellido"];
				$email   	= $_POST["email"];
				$estado   	= (isset($_POST["estado"]));
				$imagen_usr		= $_FILES['user-img']['tmp_name'];
                $imagen_cover_usr		= $_FILES['user-cover-img']['tmp_name'];
            
				$getemail = $mysqli->get("usuarios","email",["idusuario"=> $idusuario]);
            
            if($getemail == $email){
                if($imagen_usr != "")
				{
					$target_dir = "../../uploads/avatars/";
					$imageFileType = pathinfo($_FILES['user-img']['name'],PATHINFO_EXTENSION);  										
					$target_file = $target_dir.$idusuario.".".$imageFileType;
					//echo "Imagen->".$target_file."<br>";
					if(!move_uploaded_file($imagen_usr,$target_file))
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
                if($imagen_cover_usr != "")
				{
					$target_dir = "../../uploads/covers/";
					$imageFileType = pathinfo($_FILES['user-cover-img']['name'],PATHINFO_EXTENSION);  										
					$target_file = $target_dir."Cover-".$idusuario.".".$imageFileType;
					//echo "Imagen->".$target_file."<br>";
					if(!move_uploaded_file($imagen_cover_usr,$target_file))
					{
						echo "<h5> Imagen no fue actualizada </h5>";
					}
					else
					{
						foreach(glob("../../uploads/covers/Cover-".GetStrWithRange($idusuario).".*") as $Img)
						{
							if($Img != $target_file)
								unlink($Img);
						}
					}
				}	
                $mysqli->update("usuarios",
						[
                            "nombre" => $nombre,
                            "apellido" => $apellido,
                            "email"  => $email,
                            "estado" => $estado,
                            
                          
                        ],[
							"AND" => 
							[
								"idusuario" => $idusuario
								
							]
						]);				
						
						if( CheckDBError($mysqli) ) return false;
				     echo "0";	         
            }
            else
                echo "1";
            
                           
            	break;		
		case 4: //Eliminar
				break;
        case 5: //Change Password
            
            $idusuario 	= $_POST["idusuario"];
            $currentpass = $_POST["currentpass"];
            $password = $_POST["newpass"];
            $llave = hash('sha512',rand());
            
            $LoginInfo = $mysqli->select("usuarios",["password","llave"],["idusuario"=> $idusuario]);
            if( CheckDBError($mysqli) ) return;
            
            if(hash('SHA512', $currentpass . $LoginInfo[0]["llave"]) == $LoginInfo[0]["password"])
            {
                $encrypass = hash('sha512',$password . $llave);
            
                $mysqli->update("usuarios",
                [
                   "password" => $encrypass,
                    "llave" => $llave
                ],[
                    "AND" =>
                    [
                        "idusuario" => $idusuario
                    ]
                ]);
                echo "0";
            }
            else{
                echo "1";
            }
            break;
        case 6:
            
            $idusuario = $_POST["idusuario"];
            $currentpass = $_POST["password"];
            
            $LoginInfo = $mysqli->select("usuarios",["password","llave"],["idusuario"=> $idusuario]);
            if( CheckDBError($mysqli) ) return;
            
            if(hash('SHA512', $currentpass . $LoginInfo[0]["llave"]) == $LoginInfo[0]["password"])
            {
                echo "0";
            }
            else{
                echo "1";
            }
            break;
				
	}
?>