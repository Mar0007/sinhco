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
		echo "<h2>No tiene permisos para ver este bloque.</h2>";
		return;
	}	
	
	$accion = $_GET["accion"];	
	switch($accion)
	{
		case 1: // Consulta
				$strSQL = "SELECT idbloque, bloque, tipo FROM bloques";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($idbloque,$bloque, $tipo);					
										
					while ( $stmt->fetch() )
					{
						echo "<tr class=\"databloques\" id=\"$idbloque\" style=\"display:none\">
							  <td>$idbloque</td>
							  <td>$bloque</td>
							  <td>".GetIconHTML($tipo)."</td>
							  <td>".GetDropDownSettingsRow($idbloque,GetMenuArray($tipo == 0))."</td>
							  </tr>";							  
					}
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
							
				break;			
		case 2: // Insertar
				break;
		case 3: //Actualizar
				break;
		case 4: //Eliminar				
				$idbloque = $_POST["idbloque"];
				$strSQL = "DELETE FROM bloques WHERE idbloque = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idbloque);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";	
				}
				else
					echo "Error en la consulta: " . $mysqli->error;		
				break;
		case 5: // Consulta
				$idbloque = $_POST["idbloque"];
				$resultado = "";
				$strSQL = "SELECT idmodulo FROM modulos WHERE idmodulo 
						   NOT IN ( SELECT idmodulo FROM bloquemodulo WHERE idbloque = ?)";
				
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idbloque);
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
				
				$strSQL = "SELECT idmodulo FROM bloquemodulo WHERE idbloque = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idbloque);
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
		case 6: //Aplicar cambios a tabla.
				$idbloque = $_POST["idbloque"];
				$InsertData = $_POST["DataAdd"];
				$DeleteData = $_POST["DataRemove"];
				
				if($DeleteData != "")
				{					
					$Params = array();
					$strSQL = "DELETE FROM bloquemodulo WHERE (idmodulo,idbloque) IN (";
					$DeleteData = explode(",", $DeleteData);
					for($i = 0, $j = 0; $i < count($DeleteData); $i++)
					{
						$strSQL .= "(?,?),";
						$Params[$j++] = $DeleteData[$i];						
						$Params[$j++] = $idbloque;
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
						echo "Error en la consulta: " . $mysqli->error;
						return;
					}
				}
				
				if($InsertData != "")
				{
					$Params = array();
					$strSQL = "INSERT INTO bloquemodulo(idmodulo,idbloque) VALUES ";
					$InsertData = explode(",", $InsertData);
					for($i = 0, $j = 0; $i < count($InsertData); $i++)
					{
						$strSQL .= "(?,?),";
						$Params[$j++] = $InsertData[$i];						
						$Params[$j++] = $idbloque;
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
						echo "Error en la consulta: " . $mysqli->error;
						return;
					}					
				}
				
				echo "0";
				break;			
							
	}
	
	//Functions
	function GetMenuArray($b)
	{
		//Datarow menu
		return array(
			array
			(
				"ifonly"	=> $b,
				"href" 		=> "index.php?mod=crearbloque&idbloque=%id",
				"icon" 		=> "edit",
				"contenido" => "Editar"
			),
			array
			(
				"href" 		=> "javascript:Modulos('%id')",
				"icon" 		=> "view_module",
				"contenido" => "Modulos"
			),
			array("divider"),
			array
			(
				"href" 		=> "javascript:Eliminar('%id')",
				"icon" 		=> "delete",
				"contenido" => "Eliminar"
			)			
		);		
	}		
		
	function GetIconHTML($b)
	{
		if($b)
			return "<i class=\"material-icons\">insert_drive_file</i>";
		
		return "<i class=\"material-icons\">storage</i>";
	}	

?>