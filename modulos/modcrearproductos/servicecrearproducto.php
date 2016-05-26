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
				$IDproducto = $_POST['IDproducto'];																
				ProyectCard($mysqli,$IDproducto);												
				break;		
		case 2: // Insertar		
		   	$bSuccess = false;
			$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$FileName = uniqid('Producto-', true) . $targetExt;
		   
            $mysqli->action(function($mysqli) use ($FileName,&$bSuccess)
			{									
				//First upload image
				$sourcePath = $_FILES['file']['tmp_name'];					
				$targetPath = "uploads/images/productos/". $FileName;
				$ImageTitle = $_POST['img-title'];
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
					"categoria" => "Productos",
					"descripcion" => ""
				]
				);
				if(CheckDBError($mysqli)) return false;
													
				$idproducto 	= $_POST["idproducto"];
						
				$mysqli->insert("productos_img",
				[
					"idimagen" => $IDImagen,
					"idproducto" => $idproducto
				]);
				
				if(CheckDBError($mysqli)) return false;															
									
				//Return card
				ProyectCard($mysqli,$idproducto,$IDImagen);
				$bSuccess = true;					
			});
				
			//If rollback, then delete the uploaded file
			if(!$bSuccess)
				@unlink("../../uploads/images/productos/".$FileName);
			
			break;	
			
				
			
		case 3: //Actualizar 
            $mysqli->action(function($mysqli)
				{				
					$idproducto = $_POST['idproducto'];				
					$newnombre = $_POST['nombre-producto'];
                    $newdescripcion = $_POST['descripcion-producto'];
                    $newcategoria = $_POST['categoria-producto'];
                    $newproveedor = $_POST['proveedor-producto'];
                    $imagen		= $_FILES['imagen-producto']['tmp_name'];
					
				if($imagen != "")
				{
					$target_dir = "../../uploads/images/productos/";
					$imageFileType = pathinfo($_FILES['imagen-producto']['name'],PATHINFO_EXTENSION);  										
					$target_file = $target_dir.$idproducto.".".$imageFileType;
					
					if(!move_uploaded_file($imagen,$target_file))
					{
						echo "<h5> Imagen no fue actualizada </h5>";
					}
					else
					{
						foreach(glob("../../uploads/images/productos/".$idproducto.".*") as $Img)
						{
							if($Img != $target_file)
								unlink($Img);
						}
					}
				}					
				
					
					$mysqli->update("productos",
						[
                            "nombre" => $newnombre,
                            "descripcion"  => $newdescripcion,
                            "idcategoria" => $newcategoria,
                            "idproveedor" => $newproveedor
                          
                        ],[
							"AND" => 
							[
								"idproducto" => $idproducto
								
							]
						]);
						
						if( CheckDBError($mysqli) ) return false;
				     echo "0"; 
                });
            
            break;
								
		case 4: //Eliminar	
            $IDproducto = $_POST["idproducto"];
			
            $mysqli->delete("productos",
            [
				"AND" =>
            [
				"idproducto" => $IDproducto					
			]
			]);			
                
           if( CheckDBError($mysqli) ) return false;
           echo "0" ;
												
				break;
        case 11: //Eliminar Imagen
		
				$mysqli->action(function($mysqli)
				{
					$idproducto = $_POST["idproducto"];
					$IDImagen = $_POST["IDImagen"];	
						
					$OldFilename = basename($mysqli->get("imagenes","ruta",["idimagen" => $IDImagen]));					
					if(CheckDBError($mysqli)) return false;
														
					$mysqli->delete("imagenes",["idimagen" => $IDImagen]);								
					
					@unlink('../../uploads/images/productos/'.$OldFilename);								
					
					echo "0";					
				});
				break;
				
		case 14: //Actualizar Cards
				$bSuccess = false;
				$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$FileName = uniqid('Productos-', true) . $targetExt;				
								
				//Only bSuccess is passed by reference*
				$mysqli->action(function($mysqli) use ($FileName,&$bSuccess)
				{									
					$IDImagen = $_POST["IDImagen"];
					$ImageTitle = $_POST['img-title'];
					
					//First upload image and update it on DB
					//If he uploaded a file
					if($_FILES['file']['error'] == UPLOAD_ERR_OK)
					{
						$sourcePath = $_FILES['file']['tmp_name'];					
						$targetPath = "uploads/images/productos/". $FileName;
						$ImageTitle = $_POST['img-title'];
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
							"categoria" => "Producto",
							"descripcion" => ""
						],
						[
							"idimagen" => $IDImagen
						]);
						
						if(CheckDBError($mysqli)) return false;
					}
					else 
					//If didnt uploaded a file just update name
						$mysqli->update("imagenes",["img" => $ImageTitle],["idimagen" => $IDImagen]);
														
					$idproducto = $_POST["idproducto"];
					$mysqli->update("productos_img",
						[
							"idproducto"  => $idproducto,
							
						],
						[
							"idimagen" => $IDImagen
						]);
								
				

					//At last if everyting is fine delete old image
					if(isset($OldImageName) && $OldImageName != "")
						@unlink("../../uploads/images/productos/".$OldImageName);
										
					//Return card
					ProyectCard($mysqli,$idproducto,$IDImagen);
					$bSuccess = true;						
				});
				
				//If rollback, then delete the uploaded file
				if(!$bSuccess)
					@unlink("../../uploads/images/productos/".$FileName);
				
				break;	
		
    
	}
	
	
function ProyectCard($mysqli, $IDproducto, $IDImagen = null)
	{
		
		$strSQL = 				
		"SELECT i.idimagen,i.img,i.ruta, i.descripcion
		FROM productos_img s join imagenes i on s.idimagen = i.idimagen 
		WHERE idproducto = " . $mysqli->quote($IDproducto) . ((is_null($IDImagen)) ? "" : " and s.idimagen = ".$mysqli->quote($IDImagen) )."
		GROUP BY idimagen ORDER BY idimagen DESC;";
																		
		$stmt = $mysqli->query($strSQL);								
		if(CheckDBError($mysqli) || !$stmt) return;												
		$stmt = $stmt->fetchAll();
		
		foreach ($stmt as $row) 
		{
			echo "
        <li id=\"IMG_".$row["idimagen"]."\" data-id=".$row["idimagen"]." class=\"dataproductos col s12 m6 l8\">
							<div class=\"card hoverable\">
                                <div class=\"card-image waves-effect waves-block waves-light\" >
                                    <img class=\"responsive-img\" src=\"".$row["ruta"]."\">      
                                    <span class=\"card-title\">".$row["img"]."</span>
                                </div>                                
                                <div class=\"card-content\">                                    
                                   <p class=\"\">".$row["descripcion"]."</p>
                                </div>
                                <div class=\"card-action\">
									<a style=\"cursor:pointer;\" onclick=\"ItemModal(".$row["idimagen"].")\">Editar</a>
                                  	<a style=\"cursor:pointer;\" onclick=\"DeleteImage2(".$row["idimagen"].")\">eliminar</a>
                                </div>
                            </div>           
						</li>
           ";		
					
				
		}
		
	}
?>