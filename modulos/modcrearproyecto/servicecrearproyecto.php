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
				$IDProyecto = $_POST['IDProyecto'];																
				ProyectCard($mysqli,$IDProyecto);												
				break;		
		case 2: // Insertar				
            $nombre      	= $_POST["nombre"];
            $lugar   	    = $_POST["lugar"];
            $fechaproyecto  = $_POST["fechaproyecto"];
			$descripcion    = $_POST["descripcion"];
            $idusuario      = $_SESSION['idusuario'];
            
            $stmt = $mysqli->insert("proyectos",
                [
                    "nombre"    => $nombre,
                    "lugar"     => $lugar,
                    "fecha"     => $fechaproyecto,
                    "contenido" => $descripcion,
                    "idusuario" => $idusuario
                ]);
                
                     
            if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
				break;
		case 3: //Actualizar 
            $bSuccess = false;
            
            $mysqli->action(function($mysqli) use ($bSuccess)
				{				
					                    
                    $idproyecto = $_POST['idproyecto'];				
					$newnombre = $_POST['nombre-proyecto'];
                    $newlugar = $_POST['lugar-proyecto'];
                    $newcontenido = $_POST['contenido-proyecto'];
                    $newfecha = $_POST['fecha-proyecto'];
                    $imagen		= $_FILES['imagen-proyecto']['tmp_name'];
								
				if($_FILES['imagen-proyecto']['error'] == UPLOAD_ERR_OK)
				{
					$target_dir = "../../uploads/images/";
					$imageFileType = pathinfo($_FILES['imagen-proyecto']['name'],PATHINFO_EXTENSION);  										
					$target_file = $target_dir."Proyecto-".$idproyecto.".".$imageFileType;
					//echo "Imagen->".$target_file."<br>";
					if(!move_uploaded_file($imagen,$target_file))
					{
						echo "<h5> Imagen no fue actualizada </h5>";
					}
					else
					{
						foreach(glob("../../uploads/images/Proyecto-".$idproyecto.".*") as $Img)
						{
							if($Img != $target_file)
								unlink($Img);
						}
					}
                    $mysqli->update("proyectos",
						[
                            "nombre" => $newnombre,
                            "lugar"  => $newlugar,
                            "fecha" => $newfecha,
                            "contenido" => $newcontenido
                        ],[
							"AND" => 
							[
								"idproyecto" => $idproyecto
								
							]
						]);
				}	else
				
					$mysqli->update("proyectos",
						[
                            "nombre" => $newnombre,
                            "lugar"  => $newlugar,
                            "fecha" => $newfecha,
                            "contenido" => $newcontenido
                        ],[
							"AND" => 
							[
								"idproyecto" => $idproyecto
								
							]
						]);
						
						if( CheckDBError($mysqli) ) return false;
				        echo "0";      
                });                             
				break;
								
		case 4: //Eliminar	
            $IDProyecto = $_POST["idproyecto"];
            
            //Busca todas las imagenes de ese proyecto
					
					$a = $mysqli->select("proyectos_img",
					[
						"idimagen"
					], 
					[
						"idproyecto"=>$IDProyecto
					]);
					
					

					//Borra dentro de la base imagenes y la carpeta, cada imagen que encontro 
					foreach ($a as $key) {
						$Targetimage = $key;
						$OldFilename = basename($mysqli->get("imagenes","ruta",["idimagen" => $Targetimage]));	
						@unlink('../../uploads/images/Proyectos/'.$OldFilename);
						@unlink('../../uploads/images/Proyectos/Proyecto-'.$IDProyecto.'.jpg');
						

						$mysqli->delete("imagenes",
						[
							"AND" =>
						[
							"idimagen" => $Targetimage					
						]
						]);
						if( CheckDBError($mysqli) ) return false;	
					}
					
					
					//Borra todas las imagenes que tengan el mismo idproyecto
					$mysqli->delete("proyectos_img",
					[
						"AND" =>
					[
						"idproyecto" => $IDProyecto					
					]
					]);	
					
					
					//Borra el producto con el mismo idproyecto
					$mysqli->delete("proyectos",
					[
						"AND" =>
					[
						"idproyecto" => $IDProyecto					
					]
					]);		
						
					@unlink('../../uploads/images/Proyectos/Proyecto-'.$IDProyecto.'.jpg');
				
				echo "0" ;
			
												
				break;
        case 10: //Insertar Imagen
            $bSuccess = false;
			$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$FileName = uniqid('Proyecto-', true) . $targetExt;
		   
            $mysqli->action(function($mysqli) use ($FileName,&$bSuccess)
			{									
				//First upload image
				$sourcePath = $_FILES['file']['tmp_name'];					
				$targetPath = "uploads/images/Proyectos/". $FileName;
				$ImageTitle = $_POST['img-title'];
                $IMGDescripcion = $_POST['img-descripcion'];
				move_uploaded_file($sourcePath,"../../" . $targetPath);
				
				if(!file_exists("../../" . $targetPath))
				{
					echo "Error when moving file.";
					print_r($_FILES["file"]);
					return false;
				}
				
								
				$IDImagen = $mysqli->insert("imagenes",
				[
					"img"  => $ImageTitle,
					"ruta" => GetURL($targetPath),
					"categoria" => "Proyectos",
					"descripcion" => $IMGDescripcion
				]
				);
				if(CheckDBError($mysqli)) return false;
													
				$idproyecto 	= $_POST["idproyecto"];
						
				$mysqli->insert("proyectos_img",
				[
					"idimagen" => $IDImagen,
					"idproyecto" => $idproyecto
				]);
				
				if(CheckDBError($mysqli)) return false;															
									
				//Return card
				ProyectCard($mysqli,$idproyecto,$IDImagen);
				$bSuccess = true;					
			});
				
			//If rollback, then delete the uploaded file
			if(!$bSuccess)
				@unlink("../../uploads/images/Proyectos/".$FileName);
			
			break;	
			   
            
            
		case 11: //Eliminar Imagen
			$mysqli->action(function($mysqli)
				{
					$IDProyecto = $_POST["idproyecto"];
					$IDImagen = $_POST["IDImagen"];	
						
					$OldFilename = basename($mysqli->get("imagenes","ruta",["idimagen" => $IDImagen]));					
					if(CheckDBError($mysqli)) return false;
														
					$mysqli->delete("imagenes",["idimagen" => $IDImagen]);								
					
					@unlink('../../uploads/images/Proyectos/'.$OldFilename);								
					
					echo "0";					
				});	
            
				break;
		case 12: //Actualizar Imagen
				$bSuccess = false;
				$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$FileName = uniqid('Proyecto-', true) . $targetExt;				
								
				//Only bSuccess is passed by reference*
				$mysqli->action(function($mysqli) use ($FileName,&$bSuccess)
				{									
					$IDImagen = $_POST["IDImagen"];
					$ImageTitle = $_POST['img-title'];
                    $IMGDescripcion = $_POST['img-descripcion'];
					
					//First upload image and update it on DB
					//If he uploaded a file
					if($_FILES['file']['error'] == UPLOAD_ERR_OK)
					{
						$sourcePath = $_FILES['file']['tmp_name'];					
						$targetPath = "uploads/images/Proyectos/". $FileName;
						$ImageTitle = $_POST['img-title'];
                        $IMGDescripcion = $_POST['img-descripcion'];
                        
						move_uploaded_file($sourcePath,"../../" . $targetPath);
						
						if(!file_exists("../../" . $targetPath))
						{
							echo "Error when moving file.";
							return false;
						}
						
						//Get filename for deletion. -> See end of case for actual deletion.
						$OldImageName = basename($mysqli->get("imagenes","ruta",["idimagen" => $IDImagen]));										
						
						$mysqli->update("imagenes",
						[
							"img"  => $ImageTitle,
							"ruta" => GetURL($targetPath),
							"categoria" => "Proyecto",
							"descripcion" => $IMGDescripcion
						],
						[
							"idimagen" => $IDImagen
						]);
						
						if(CheckDBError($mysqli)) return false;
					}
					else 
					//If didnt uploaded a file just update name
						$mysqli->update("imagenes",["img" => $ImageTitle, "descripcion" => $IMGDescripcion],["idimagen" => $IDImagen]);
														
					$idproyecto = $_POST["idproyecto"];
					$mysqli->update("proyectos_img",
						[
							"idproyecto"  => $idproyecto,
							
						],
						[
							"idimagen" => $IDImagen
						]);
								
				

					//At last if everyting is fine delete old image
					if(isset($OldImageName) && $OldImageName != "")
						@unlink("../../uploads/images/Proyectos/".$OldImageName);
										
					//Return card
					ProyectCard($mysqli,$idproyecto,$IDImagen);
					$bSuccess = true;						
				});
				
				//If rollback, then delete the uploaded file
				if(!$bSuccess)
					@unlink("../../uploads/images/Proyectos/".$FileName);
				
				break;	
        case 13: //Add IMG
            $mysqli->action(function($mysqli)
				{									
					$IDImagen = $_POST["IDImagen"];
					$IDProyecto = $_POST["IDProyecto"];	                    
					//$IDImgInit  = ((isset($_POST['IDImgInit'])) ? $_POST['IDImgInit'] : $IDImagen);
					
															
					
						$mysqli->insert("proyectos_img",[
                            "idproyecto" => $IDProyecto,
                            "idimagen" => $IDImagen
                        ]);
						if(CheckDBError($mysqli)) return false;													
					
					
					
					ProyectCard($mysqli,$IDProyecto, $IDImagen);												
						
				});
				break;
		
    
	}
function ProyectCard($mysqli, $IDProyecto, $IDImagen = null)
	{
		
		$strSQL = 				
		"SELECT i.idimagen,i.img,i.ruta, i.descripcion
		FROM proyectos_img s join imagenes i on s.idimagen = i.idimagen 
		WHERE idproyecto = " . $mysqli->quote($IDProyecto) . ((is_null($IDImagen)) ? "" : " and s.idimagen = ".$mysqli->quote($IDImagen) )."
		GROUP BY idimagen ORDER BY idimagen DESC;";
																		
		$stmt = $mysqli->query($strSQL);								
		if(CheckDBError($mysqli) || !$stmt) return;												
		$stmt = $stmt->fetchAll();
		
        if(empty($stmt))
        {
            echo "none";
            return;
        }	
		
        foreach ($stmt as $row) 
		{
			echo "
        <li id=\"IMG_".$row["idimagen"]."\" class=\"dataproyectos col s12 m6 l8\">
							<div class=\"card hoverable\">
                                <div class=\"card-image waves-effect waves-block waves-light\">
                                    <img class=\"responsive-img\" src=\"".$row["ruta"]."\">      
                                    <span class=\"card-title\">".$row["img"]."</span>
                                </div>                                
                                <div class=\"card-content\">                                    
                                   <p class=\"\">".$row["descripcion"]."</p>
                                </div>
                                <div class=\"card-action\">
                                <a style=\"cursor:pointer;\" onclick=\"ItemModal(".$row["idimagen"].")\">Editar</a>
                                  <a style=\"cursor:pointer;\" onclick=\"DeleteImage(".$row["idimagen"].")\">eliminar</a>
                                </div>
                            </div>           
						</li>
           ";		
					
				
		}
		
	}
?>