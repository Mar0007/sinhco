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
				$IDSlider = $_POST['IDSlider'];																
				SliderCard($mysqli,$IDSlider);												
				break;
				
		case 2: //Insertar
				$bSuccess = false;
				$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$FileName = uniqid('Slider-', true) . $targetExt;
				
				$mysqli->action(function($mysqli) use ($FileName,&$bSuccess)
				{									
					//First upload image
					$ImageTitle = $_POST['img-title'];
					$TextAlign = $_POST['TextAlign'];
					$sourcePath = $_FILES['file']['tmp_name'];					
					$targetPath = "uploads/images/Slider/". $FileName;
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
						"ruta" => $targetPath,
						"categoria" => "Slider",
						"descripcion" => "",
						"alineacion" => $TextAlign
					]
					);
					if(CheckDBError($mysqli)) return false;
														
					$IDSlider 	= $_POST["IDSlider"];
					$InsertData = $_POST["DataAdd"];
					$Orden = 0;
											
					if($InsertData != "")
					{									 									
						//Update order first
						$mysqli->update("slider_img_mod", ["orden[+]" => 1],
						[
							"AND" => 
							[
								"idslider" => $IDSlider,
								"orden[>=]" => $Orden
							]
						]);                                                
						if( CheckDBError($mysqli) ) return false;
						
						
						$Values = Array();
						$InsertData = explode(",", $InsertData);
											
						foreach ($InsertData as $Item) 
						{						
							$TArray = Array();
							$TArray["idmodulo"] = $Item;
							$TArray["idimagen"] = $IDImagen;
							$TArray["idslider"] = $IDSlider;
							$TArray["orden"] = $Orden;
							array_push($Values,$TArray);
						}
											
						$mysqli->insert("slider_img_mod",$Values);
						if(CheckDBError($mysqli)) return false;															
					}
										
					//Return card
					SliderCard($mysqli,$IDSlider,$IDImagen);
					$bSuccess = true;					
				});
				
				//If rollback, then delete the uploaded file
				if(!$bSuccess)
					@unlink("../../uploads/images/".$FileName);
				
				break;			
										
		case 3: //Actualizar
				$bSuccess = false;
				$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$FileName = uniqid('Slider-', true) . $targetExt;				
								
				//Only bSuccess is passed by reference*
				$mysqli->action(function($mysqli) use ($FileName,&$bSuccess)
				{									
					$IDImagen = $_POST["IDImagen"];
					$ImageTitle = $_POST['img-title'];
					$TextAlign = $_POST['TextAlign'];
					
					//First upload image and update it on DB
					//If he uploaded a file
					if($_FILES['file']['error'] == UPLOAD_ERR_OK)
					{
						$sourcePath = $_FILES['file']['tmp_name'];					
						$targetPath = "uploads/images/Slider/". $FileName;
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
							"ruta" => $targetPath,
							"categoria" => "Slider",
							"descripcion" => "",
							"alineacion" => $TextAlign
						],
						[
							"idimagen" => $IDImagen
						]);
						
						if(CheckDBError($mysqli)) return false;
					}
					else 
					{
					//If didnt uploaded a file just update name
						$mysqli->update("imagenes",
						[
							"img" => $ImageTitle,
							"alineacion" => $TextAlign
						],
						[
							"idimagen" => $IDImagen							
						]);
						
						if(CheckDBError($mysqli)) return false;
					}
														
					$IDSlider 	= $_POST["IDSlider"];
					$InsertData = $_POST["DataAdd"];
					$DeleteData = $_POST["DataRemove"];
								
					if($DeleteData != "")
					{	
						$Cont = 0;
						$DeleteData = explode(",", $DeleteData);											
						foreach ($DeleteData as $Item) 
						{						
							$TArray["OR"]["AND #".$Cont]["idmodulo"] = $Item;
							$TArray["OR"]["AND #".$Cont++]["idslider"] = $IDSlider;							
						}			
						
						$mysqli->delete("slider_img_mod",$TArray);		
						if(CheckDBError($mysqli)) return false;				
					}																					
											
					if($InsertData != "")
					{									 																					
						$Orden = $mysqli->get("slider_img_mod","orden",
						[
							"AND" => 
							[
								"idslider" => $IDSlider,
								"idimagen" => $IDImagen							
							]
						]);						
						
						$Values = Array();
						$InsertData = explode(",", $InsertData);
											
						foreach ($InsertData as $Item) 
						{						
							$TArray = Array();
							$TArray["idmodulo"] = $Item;
							$TArray["idimagen"] = $IDImagen;
							$TArray["idslider"] = $IDSlider;
							$TArray["orden"] = $Orden;
							array_push($Values,$TArray);
						}
											
						$mysqli->insert("slider_img_mod",$Values);
						if(CheckDBError($mysqli)) return false;															
					}

					//At last if everyting is fine delete old image
					if(isset($OldImageName) && $OldImageName != "")
						@unlink("../../uploads/images/Slider/".$OldImageName);
										
					//Return card
					SliderCard($mysqli,$IDSlider,$IDImagen);
					$bSuccess = true;					
				});
				
				//If rollback, then delete the uploaded file
				if(!$bSuccess)
					@unlink("../../uploads/images/Slider/".$FileName);
				
				break;		
		case 4: //Eliminar
				
				$mysqli->action(function($mysqli)
				{
					$IDSlider = $_POST["IDSlider"];
					$IDImagen = $_POST["IDImagen"];
					
					/*$mysqli->delete("slider_img_mod",
					[
						"AND" =>
						[
							"idimagen" => $IDImagen,
							"idslider" => $IDSlider
						]
					]);
					
					if(CheckDBError($mysqli)) return false;
					*/
					
					$Orden = $mysqli->get("slider_img_mod","orden",
					[
						"AND" => 
						[
							"idslider" => $IDSlider,
							"idimagen" => $IDImagen							
						]
					]);
					
				
					//Update order first
					$mysqli->update("slider_img_mod", ["orden[-]" => 1],
					[
						"AND" => 
						[
							"idslider" => $IDSlider,
							"orden[>=]" => $Orden
						]
					]); 					
					
					$OldFilename = basename($mysqli->get("imagenes","ruta",["idimagen" => $IDImagen]));					
					if(CheckDBError($mysqli)) return false;
														
					$mysqli->delete("imagenes",["idimagen" => $IDImagen]);								
					
					@unlink('../../uploads/images/Slider/'.$OldFilename);								
					echo "0";					
				});
				break;
						
		case 5: //Consulta Modulos
				$IDSlider = $_POST["IDSlider"];
				$IDImagen  = $_POST["IDImage"];
				
				$strSQL = "SELECT idmodulo FROM modulos WHERE
						   tipo < 1 and idmodulo NOT IN ( SELECT idmodulo FROM slider_img_mod 
						   WHERE idslider = ".$mysqli->quote($IDSlider)."and idimagen = ".$mysqli->quote($IDImagen).")";

				$stmt = $mysqli->query($strSQL);
				if(CheckDBError($mysqli)) return;
																
				$JSON["Disponibles"] = ($stmt != null) ? $stmt->fetchAll() : false;
				$JSON["Asignados"] = $mysqli->select("slider_img_mod",["idmodulo"],
				[
					"AND" =>
					[
						"idslider" => $IDSlider,
						"idimagen" => $IDImagen
					]
				]);
				
				if(CheckDBError($mysqli)) return;
				
				echo json_encode($JSON);
				break;
		case 6: //Update order
			$mysqli->action(function($mysqli)
			{				
				$IDSlider = $_POST['IDSlider'];				
				$Orden = 0;
				
				foreach ($_POST['CImg'] as $IDItem) 
				{
					$mysqli->update("slider_img_mod",["orden" => $Orden++],
					[
						"AND" => 
						[
							"idslider" => $IDSlider,
							"idimagen" => $IDItem
						]
					]);
					
					if( CheckDBError($mysqli) ) return false;
				}
									
				echo "0";
			});										
    }
	
    
    
	function SliderCard($mysqli, $IDSlider, $IDImagen = null)
	{
		
		$strSQL = 				
		"SELECT i.idimagen,i.img,i.ruta,i.descripcion,i.alineacion,GROUP_CONCAT(idmodulo SEPARATOR ',') as modulos, orden
		FROM slider_img_mod s join imagenes i on s.idimagen = i.idimagen 
		WHERE idslider = " . $mysqli->quote($IDSlider) . ((is_null($IDImagen)) ? "" : " and s.idimagen = ".$mysqli->quote($IDImagen) )."
		GROUP BY idimagen
		ORDER BY orden;";
        
		$stmt = $mysqli->query($strSQL);								
		if(CheckDBError($mysqli) || !$stmt) return;												
		$stmt = $stmt->fetchAll();        
        
        foreach ($stmt as $row) 
        {
			$strModulos = "";
			foreach(explode(",",$row["modulos"]) as $ID)
				$strModulos .= '<div class="chip" style="margin-left:3px; margin-bottom: 3px;">'.$ID.'</div>';
			
			echo '
            <li id="IMG_'.$row["idimagen"].'" data-id="'.$row["idimagen"].'" class="dataproyectos col s12 m6 l8" style="opacity: 0">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light" onClick="ItemModal('.$row["idimagen"].')">
                        <img class="responsive-img" src="'.GetImageURL($row["ruta"],700,300).'">      
                        <span class="card-title">'.$row["img"].'</span>
                    </div>                                
                    <div class="card-content">
                        <p>'.$row["descripcion"].'</p>
						'.$strModulos.'
                    </div>
					<input class="textalign-data" type="hidden" value="'.( (empty($row["alineacion"])) ? "left" : $row["alineacion"]) .'">
                    <div class="card-action">
						<a style="cursor:pointer;" onclick="ItemModal('.$row["idimagen"].')">Editar</a>
                        <a style="cursor:pointer;" onclick="DeleteImage('.$row["idimagen"].')">Eliminar</a>
                    </div>
                </div>           
            </li>';			
        }    
    }    
?>