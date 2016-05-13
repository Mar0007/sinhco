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
				SliderRowHTML($mysqli,$IDSlider);								
				break;		
				
		case 2: //Aplicar cambios a tabla.
				$mysqli->action(function($mysqli)
				{									
					$IDImagen = $_POST["IDImagen"];
					$IDSlider = $_POST["IDSlider"];
					$InsertData = $_POST["DataAdd"];
					$DeleteData = $_POST["DataRemove"];
					$Orden 		= $_POST["Orden"];
					$IDImgInit  = ((isset($_POST['IDImgInit'])) ? $_POST['IDImgInit'] : $IDImagen);
					
					if($DeleteData != "")
					{																				
						//$Values = array();
						$Cont = 0;
						$DeleteData = explode(",", $DeleteData);											
						foreach ($DeleteData as $Item) 
						{						
							//$TArray["OR"] = Array();
							$TArray["OR"]["AND #".$Cont]["idmodulo"] = $Item;
							$TArray["OR"]["AND #".$Cont++]["idslider"] = $IDSlider;							
							//$TArray["idimagen"] = $IDImagen;						
							//$TArray["orden"] = $Orden;
							//array_push($Values,$TArray);
						}			
						
						$mysqli->delete("slider_img_mod",$TArray);		
						if(CheckDBError($mysqli)) return false;				
					}										
					
					if($InsertData != "")
					{									 									
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
					
					if($IDImagen != $IDImgInit)
					{
						$mysqli->update("slider_img_mod",
						[
							"idimagen" => $IDImagen
						],
						[
							"AND" =>
							[
								"idslider" => $IDSlider,
								"idimagen" => $IDImgInit
							]
						]
						);
						
						if(CheckDBError($mysqli)) return false;
					}
					
					//Return row 
					SliderRowHTML($mysqli,$IDSlider,$IDImagen);					
				});
				break;			
				
		case 3: //Actualizar
				break;				
				
		case 4: //Eliminar
				$IDImagen = $_POST["IDImagen"];
				$IDSlider = $_POST["IDSlider"];
				
				$mysqli->delete("slider_img_mod",
				[
					"AND" =>
					[
						"idimagen" => $IDImagen,
						"idslider" => $IDSlider
					]
				]);
				
				if(CheckDBError($mysqli)) return;

				echo "0";
				break;
				
		case 5: //Update Order				
				//Renumber database Order.				
				$mysqli->action(function($mysqli)
				{				
					$IDSlider = $_POST['IDSlider'];				
					$Orden = 0;
					
					foreach ($_POST['Row'] as $IDItem) 
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
				break;
				
		case 6: //Insert Slider
				$Slider = $_POST['Titulo'];																
				
				$last_id = $mysqli->insert("slider",["slider" => $Slider]);
				if( CheckDBError($mysqli) ) return;								
				echo "<option value=\"".$last_id."\">$Slider</option>";
										
				break;		
		case 7: //Delete Slider
				$IDSlider = $_POST["IDSlider"];
				if($IDSlider == 0)
				{
					echo "No se puede eliminar el slider principal.";
					return;
				}
				
				$mysqli->delete("slider",["idslider" => $IDSlider]);
				if( CheckDBError($mysqli) ) return;
				echo "0";

				break;				
		case 8: // Consulta Modulos
				$IDSlider = $_POST["IDSlider"];
				$IDImagen  = $_POST["IDImage"];
				
				$strSQL = "SELECT idmodulo FROM modulos WHERE idmodulo 
						   NOT IN ( SELECT idmodulo FROM slider_img_mod 
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
				
				//echo $resultado;
				//echo print_r($JSON);
				echo json_encode($JSON);
				break;
		case 9: //Get Images
				$IDSlider = $_POST['IDSlider'];
				$IDEdit   = $_POST['IDEdit'];	
												
				$strSQL = "
				SELECT idimagen,img,ruta 
				FROM imagenes 
				WHERE idimagen NOT IN (SELECT idimagen FROM slider_img_mod 
					WHERE IDSlider = ". $mysqli->quote($IDSlider) . 
					(($IDEdit == -1) ? "" : " and idimagen != " . $mysqli->quote($IDEdit) ).")";	

				$stmt = $mysqli->query($strSQL);
				if(CheckDBError($mysqli)) return;
				
				if($stmt != null)				
				{
					$stmt = $stmt->fetchAll();													
					foreach ($stmt as $row) 
					{
						echo "<a id=\"IMG_".$row["idimagen"]."\" value=\"".$row["idimagen"]."\" class=\"collection-item col s2".(($IDEdit == $row["idimagen"]) ? " active Initial":"")."\" style=\"margin-left:5px;margin-bottom:5px;width:110px;height:110px;cursor:pointer\" 
								ondblclick=\"EditarImagen(".$row["idimagen"].")\">														  
								<i class=\"material-icons tiny\" onclick=\"DeleteImage(".$row["idimagen"].")\" style=\"position:absolute;margin-left:85px;cursor:pointer;\">close</i>
								<div class=\"center-align\">
									<img src=\"".$row["ruta"]."\" style=\"width:80px;height:80px;\">
									<span class=\"truncate\">".$row["img"]."</span>
								</div>
							  </a>";						
					}					
				}				
				
				break;			
		case 10: //Insertar Imagen
				$sourcePath = $_FILES['file']['tmp_name'];
				$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$targetPath = "uploads/images/". uniqid('Slider-', true) . $targetExt;
				$targetName = basename($_FILES['file']['name'] , $targetExt);
				move_uploaded_file($sourcePath,"../../" . $targetPath);
								
				$last_id = $mysqli->insert("imagenes",
				[
					"img"  => $targetName,
					"ruta" => GetURL($targetPath),
					"categoria" => "slider"
				]
				);
				if(CheckDBError($mysqli)) return;
				echo "<a id=\"IMG_".$last_id."\" value=\"".$last_id."\" class=\"collection-item col s2\" style=\"margin-left:5px;margin-bottom:5px;width:110px;height:110px;\" ondblclick=\"EditarImagen(".$last_id.")\">
						<i class=\"material-icons tiny\" onclick=\"DeleteImage(".$last_id.")\" style=\"position:absolute;margin-left:85px;cursor:pointer;\">close</i>
						<div class=\"center-align\">
							<img src=\"".GetURL($targetPath)."\" style=\"width:80px;height:80px;\">									
							<span class=\"truncate\">".$targetName."</span>
						</div>
						</a>";							
				
				break;
		case 11: //Eliminar Imagen
				$IDImagen = $_POST["IDImagen"];
				$Ruta = $mysqli->get("imagenes","ruta",["idimagen" => $IDImagen]);
				
				if(CheckDBError($mysqli)) return;
								
				$mysqli->delete("imagenes",["idimagen" => $IDImagen]);				
				
				//array_map('unlink', glob("some/dir/*.txt"));
				@unlink($Ruta);								
				echo "0";
				
				break;
		case 12: //Actualizar Imagen
				$IDImagen 	= $_POST["IDImagen"];
				$Imagen 	= $_POST["Imagen"];

				$mysqli->update("imagenes",["img" => $Imagen],["idimagen" => $IDImagen]);
				if(CheckDBError($mysqli)) return;

				echo "0";
				break;								
					
	}
	
	
	function SliderRowHTML($mysqli, $IDSlider, $IDImagen = null)
	{
		
		$strSQL = 				
		"SELECT i.idimagen,i.img,i.ruta,GROUP_CONCAT(idmodulo SEPARATOR ',') as modulos, orden
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
			
			echo 
			'
				<li id="Row_'.$row["idimagen"].'" style="display:none" class="dataitems collection-item avatar" pos="'.$row["orden"].'">
					<i class="material-icons left handler-class" style="cursor:move;margin-left:-100px;margin-top:10px">swap_vert</i>
					<img class="circle materialboxed" src="'.$row["ruta"].'" style=""/>									
					<a  class="black-text" href="#!">
						<span class="title">No titulo aun</span>								
					</a>                 
					<p class="grey-text lighten-2 title">Modulos:</p>
					'.$strModulos.'
					'.GetDropDownSettingsRow($row["idimagen"],GetMenuArray()).'			
				</li>
			';     	
		}
		
	}
	
	
	function GetMenuArray()
	{
		//Datarow menu
		return array(
			array
			(
				"href" 		=> "javascript:OpenModal('%id')",
				"icon" 		=> "edit",
				"contenido" => "Editar"
			),
			array
			(
				"href" 		=> "javascript:Eliminar('%id')",
				"icon" 		=> "delete",
				"contenido" => "Eliminar"
			)
		);		
	}	
?>
