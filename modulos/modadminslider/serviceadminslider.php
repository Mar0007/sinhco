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
				$strSQL = 				
				"SELECT i.idimagen,i.imagen,i.ruta,GROUP_CONCAT(idmodulo SEPARATOR ',') as modulos, orden
				FROM sliderimgmods s join sliderimgs i on s.idimagen = i.idimagen 
				WHERE idslider = ?
				GROUP BY idimagen
				ORDER BY orden;";				
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('i',$IDSlider);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($IDImagen,$Imagen,$Ruta,$IDModulo,$Orden);
					//$Cont = 0;
					while ( $stmt->fetch() )
					{						
						echo "<tr class=\"datarows1\" id=\"Row_$IDImagen\" style=\"display:none\">
								<td class=\"orderrow\" init=\"$Orden\"><i class=\"material-icons left handler-class\" style=\"cursor:move\">reorder</i> <span>$Orden</span></td>						
								<td idIMG=\"$IDImagen\"><img src=\"$Ruta\" style=\"width:90px;height:90px\"/></td>
								<td>";
						
						foreach(explode(",",$IDModulo) as $ID)
						{
							echo "<div class=\"chip\" style=\"margin-left:3px; margin-bottom: 3px;\">$ID</div>";						
						}								
						//echo "<td>$ID</td>";
								
						echo "</td>
							  <td>".GetDropDownSettingsRow($IDImagen,GetMenuArray())."</td>
								</tr>";				
					}
				}
				else
					echo "Error en la consulta: " . $mysqli->error;	
					
				break;		
		case 2: //Aplicar cambios a tabla.
				$IDImagen = $_POST["IDImagen"];
				$IDSlider = $_POST["IDSlider"];
				$InsertData = $_POST["DataAdd"];
				$DeleteData = $_POST["DataRemove"];
				$Orden 		= $_POST["Orden"];
				$IDImgInit  = ((isset($_POST['IDImgInit'])) ? $_POST['IDImgInit'] : $IDImagen);
				
				if($DeleteData != "")
				{					
					$Params = array();
					$strSQL = "DELETE FROM sliderimgmods WHERE (idmodulo,idimagen,idslider,orden) IN (";
					$DeleteData = explode(",", $DeleteData);
					for($i = 0, $j = 0; $i < count($DeleteData); $i++)
					{
						$strSQL .= "(?,?,?),";
						$Params[$j++] = $DeleteData[$i];						
						$Params[$j++] = $IDImagen;
						$Params[$j++] = $IDSlider;
						$Params[$j++] = $Orden;
					}
					$strSQL = substr($strSQL, 0, -1) . ")";					
					if( $stmt = $mysqli->prepare($strSQL) )
					{																		
						DynamicBindVariables($stmt,$Params);
						$stmt->execute();
						if($stmt->errno != 0)
						{
							echo $stmt->errno;
							return;
						}
					}
					else
					{
						echo "1:: Error en la consulta: " . $mysqli->error;
						return;
					}
				}										
				
				if($InsertData != "")
				{									 				
					$Params = array();
					$strSQL = "INSERT INTO sliderimgmods(idmodulo,idimagen,idslider,orden) VALUES ";
					$InsertData = explode(",", $InsertData);
					for($i = 0, $j = 0; $i < count($InsertData); $i++)
					{
						$strSQL .= "(?,?,?,?),";
						$Params[$j++] = $InsertData[$i];						
						$Params[$j++] = $IDImagen;
						$Params[$j++] = $IDSlider;
						$Params[$j++] = $Orden;
					}
					$strSQL = substr($strSQL, 0, -1);					
					if( $stmt = $mysqli->prepare($strSQL) )
					{																		
						DynamicBindVariables($stmt,$Params);
						$stmt->execute();
						if($stmt->errno != 0)
						{
							echo $stmt->errno;
							return;
						}
					}
					else
					{
						echo "2:: Error en la consulta: " . $mysqli->error;
						return;
					}					
				}
				
				if($IDImagen != $IDImgInit)
				{
					$strSQL   = "UPDATE sliderimgmods SET idimagen = ? WHERE idslider = ? and idimagen = ?";
					if( $stmt = $mysqli->prepare($strSQL) )
					{
						$stmt->bind_param('iii',$IDImagen,$IDSlider,$IDImgInit);
						$stmt->execute();
						if($stmt->errno != 0)
						{
							echo "Error";
							echo $stmt->errno . " : " . $mysqli->error;
							return;
						}						
					}
					else
					{
						echo "3:: Error en la consulta: " . $mysqli->error;
						return;
					}
				}
				
				//Return row 
				$strSQL = 				
				"SELECT i.idimagen,i.imagen,i.ruta,GROUP_CONCAT(idmodulo SEPARATOR ',') as modulos, orden
				FROM sliderimgmods s join sliderimgs i on s.idimagen = i.idimagen 
				WHERE idslider = ? and s.idimagen = ?
				GROUP BY idimagen;";				
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ii',$IDSlider,$IDImagen);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($IDImagen,$Imagen,$Ruta,$IDModulo,$Orden);
					while ( $stmt->fetch() )
					{						
						echo "<tr class=\"datarows1\" id=\"Row_$IDImagen\" style=\"display:none\">
								<td class=\"orderrow\" init=\"$Orden\"><i class=\"material-icons left handler-class\" style=\"cursor:move\">reorder</i> <span>$Orden</span></td>
								<td idIMG=\"$IDImagen\"><img src=\"$Ruta\" style=\"width:90px;height:90px\"/></td>
								<td>";
						
						foreach(explode(",",$IDModulo) as $ID)
						{
							echo "<div class=\"chip\" style=\"margin-left:3px;margin-bottom: 3px;\">$ID</div>";						
						}								
								
						echo "</td>
							  <td>".GetDropDownSettingsRow($IDImagen,GetMenuArray())."</td>
								</tr>";				
					}
				}
				else
					echo "4:: Error en la consulta: " . $mysqli->error;
									
				break;			
				
		case 3: //Actualizar
				break;				
				
		case 4: //Eliminar
				$IDImagen = $_POST["IDImagen"];
				$IDSlider = $_POST["IDSlider"];

				$strSQL = "DELETE FROM sliderimgmods WHERE idimagen = ? and idslider = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ii',$IDImagen,$IDSlider);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
						return;
					}
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
					return;
				}
				
				echo "0";
				break;
				
		case 5: //Update Order
				//Renumber database Order.
				$IDSlider = $_POST['IDSlider'];				
				
				$Orden = 0;
				foreach ($_POST['Row'] as $IDItem) 
				{
					$strSQL   = "UPDATE sliderimgmods SET orden = ? WHERE idslider = ? and idimagen = ?";
					if( $stmt = $mysqli->prepare($strSQL) )
					{
						$stmt->bind_param('iii',$Orden,$IDSlider,$IDItem);
						$stmt->execute();
						if($stmt->errno != 0)
						{
							echo $stmt->errno . " : " . $mysqli->error;
							return;
						}						
					}
					else
					{
						echo "Error en la consulta: " . $mysqli->error;
						return;
					}
					$Orden++;		
				}
				echo "0";
				break;
				
		case 6: //Insert Slider
				$Slider = $_POST['Titulo'];																
				
				$strSQL   = "INSERT INTO slider(slider) VALUES (?);";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$Slider);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "<option value=\"".$stmt->insert_id."\">$Slider</option>";										
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
		
				break;		
		case 7: //Delete Menu
				$IDSlider = $_POST["IDSlider"];
				$strSQL = "DELETE FROM slider WHERE idslider = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('i',$IDSlider);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
						return;
					}
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
					return;
				}
				echo "0";
				break;
				
		case 8: // Consulta Modulos
				$IDSlider = $_POST["IDSlider"];
				$IDImage  = $_POST["IDImage"];
				$resultado = "";
				$strSQL = "SELECT idmodulo FROM modulos WHERE idmodulo 
						   NOT IN ( SELECT idmodulo FROM sliderimgmods WHERE idslider = ? and idimagen = ?)";
				
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ii',$IDSlider,$IDImage);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($idmodulo);
					while( $stmt-> fetch() )
						$resultado .= "$idmodulo,";					
					$resultado = substr_replace($resultado, "", -1).";";
				}
				else
				{
					$resultado = 1;
					echo "1";
					break;	
				}
							
				$strSQL = "SELECT idmodulo FROM sliderimgmods WHERE idslider = ? and idimagen = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ii',$IDSlider,$IDImage);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($idmodulo);
					while( $stmt-> fetch() )
					{
						$resultado .= "$idmodulo,";
					}				
					$resultado = substr_replace($resultado, "", -1).";";
				}
				else
				{
					$resultado = 1;
					echo "1";
					break;
				}				
				echo $resultado;
				break;
		case 9: //Get Images
				$IDSlider = $_POST['IDSlider'];
				$IDEdit   = $_POST['IDEdit'];	
												
				$strSQL = "
				SELECT idimagen,imagen,ruta 
				FROM sliderimgs 
				WHERE idimagen NOT IN (SELECT idimagen FROM sliderimgmods WHERE IDSlider = ?".(($IDEdit == -1) ? "" : " and idimagen != ?").")";	
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$Params = array($IDSlider);
					if($IDEdit != -1)
						array_push($Params,$IDEdit);
						
					DynamicBindVariables($stmt,$Params);
					//$stmt->bind_param('i',$IDSlider);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($IDImagen,$Imagen,$Ruta);
					//echo "<div class=\"collection\" style=\"border-style: none;\">";						
					while ( $stmt->fetch() )
					{						
						echo "<a id=\"IMG_$IDImagen\" value=\"$IDImagen\" class=\"collection-item col s2".(($IDEdit == $IDImagen) ? " active Initial":"")."\" style=\"margin-left:5px;margin-bottom:5px;width:110px;height:110px;cursor:pointer\" ondblclick=\"EditarImagen($IDImagen)\">						  
								<i class=\"material-icons tiny\" onclick=\"DeleteImage($IDImagen)\" style=\"position:absolute;margin-left:85px;cursor:pointer;\">close</i>
								<div class=\"center-align\">
									<img src=\"$Ruta\" style=\"width:80px;height:80px;\">
									<span class=\"truncate\">$Imagen</span>
								</div>
							  </a>";
					}
					//echo "</div>	";
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;			
		case 10: //Insertar Imagen
				$sourcePath = $_FILES['file']['tmp_name'];
				$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$targetPath = "uploads/images/". uniqid('Slider-', true) . $targetExt;
				$targetName = basename($_FILES['file']['name'] , $targetExt);
				move_uploaded_file($sourcePath,"../../" . $targetPath);
				
				
				$strSQL   = "INSERT INTO sliderimgs(imagen,ruta) VALUES (?,?);";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ss',$targetName,$targetPath);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "<a id=\"IMG_".$mysqli->insert_id."\" value=\"".$mysqli->insert_id."\" class=\"collection-item col s2\" style=\"margin-left:5px;margin-bottom:5px;width:110px;height:110px;\" ondblclick=\"EditarImagen(".$mysqli->insert_id.")\">
								<i class=\"material-icons tiny\" onclick=\"DeleteImage(".$mysqli->insert_id.")\" style=\"position:absolute;margin-left:85px;cursor:pointer;\">close</i>
								<div class=\"center-align\">
									<img src=\"$targetPath\" style=\"width:80px;height:80px;\">									
									<span class=\"truncate\">$targetName</span>
								</div>
							  </a>";
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
				
				
				break;
		case 11: //Eliminar Imagen
				$IDImagen = $_POST["IDImagen"];
				$Ruta = "";
				
				$strSQL = "SELECT ruta FROM sliderimgs WHERE idimagen = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('i',$IDImagen);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($Ruta);
					if(!$stmt-> fetch())
						echo "Error->".$stmt->errno . " : " . $mysqli->error;					
				}

				$strSQL = "DELETE FROM sliderimgs WHERE idimagen = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('i',$IDImagen);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
						return;
					}
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
					return;
				}
				
				//array_map('unlink', glob("some/dir/*.txt"));
				unlink("../../".$Ruta);				
				echo "0";
				break;
		case 12: //Actualizar Imagen
				$IDImagen 	= $_POST["IDImagen"];
				$Imagen 	= $_POST["Imagen"];

				$strSQL = "UPDATE sliderimgs SET imagen = ? WHERE idimagen = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('si',$Imagen,$IDImagen);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
						return;
					}
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
					return;
				}
				
				echo "0";
				break;								
					
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
