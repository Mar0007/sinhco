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
				$strSQL = "SELECT idperfil, perfil FROM perfiles";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($idperfil,$perfil);
					while ( $stmt->fetch() )
					{
						echo "<tr class=\"dataperfiles\" id=\"$idperfil\" style=\"display:none\">
							  <td>$idperfil</td>
							  <td>$perfil</td>
							  <td>".GetDropDownSettingsRow($idperfil,GetMenuArray())."</td>
							  </tr>";
					}
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;
		case 2: // Insertar
				$idperfil = $_POST["idperfil"];
				$perfil   = $_POST["perfil"];
				$strSQL   = "INSERT INTO perfiles(idperfil, perfil) VALUES (?, ?);";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ss',$idperfil,$perfil);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
					}
					else
					{
						echo "<tr class=\"dataperfiles\" id=\"$idperfil\" style=\"display:none\">
							  <td>$idperfil</td>
							  <td>$perfil</td>
							  <td>".GetDropDownSettingsRow($idperfil,GetMenuArray())."</td>
							  </tr>";
					}										
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}					
				break;
		case 3: // Actualizar
				$newidperfil = $_POST["newidperfil"];
				$idperfil 	 = $_POST["idperfil"];
				$perfil   	 = $_POST["perfil"];
				$strSQL = "UPDATE perfiles SET idperfil = ?, perfil = ? WHERE idperfil = ?;";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('sss',$newidperfil,$perfil,$idperfil);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $stmt->error;
					}
					else
					{
						echo "0";
					}	
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;		
		case 4: // Eliminar
				$idperfil = $_POST["idperfil"];
				$strSQL = "DELETE FROM perfiles WHERE idperfil = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idperfil);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno;
					}
					else
					{
						echo "0";
					}	
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;
		case 5: // Consulta
				$idperfil = $_POST["idperfil"];
				$resultado = "";
				$strSQL = "SELECT idmodulo FROM modulos WHERE idmodulo 
						   NOT IN ( SELECT idmodulo FROM modulosperfil WHERE idperfil = ?)";
				
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idperfil);
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
					//$resultado = 1;
					echo "1";
					break;	
				}
				
				$strSQL = "SELECT idmodulo FROM modulosperfil WHERE idperfil = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idperfil);
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
					//$resultado = 1;
					echo "1";
					break;
				}				
				echo $resultado;
				break;
		case 6: //Aplicar cambios a tabla.
				$idperfil = $_POST["idperfil"];
				$InsertModules = $_POST["moduloinsertar"];
				$DeleteModules = $_POST["moduloborrar"];
				
				if($DeleteModules != "")
				{					
					$Params = array();
					$strSQL = "DELETE FROM modulosperfil WHERE (idmodulo,idperfil) IN (";
					$DeleteModules = explode(",", $DeleteModules);
					for($i = 0, $j = 0; $i < count($DeleteModules); $i++)
					{
						$strSQL .= "(?,?),";
						$Params[$j++] = $DeleteModules[$i];						
						$Params[$j++] = $idperfil;
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
				
				if($InsertModules != "")
				{
					$Params = array();
					$strSQL = "INSERT INTO modulosperfil(idmodulo,idperfil) VALUES ";
					$InsertModules = explode(",", $InsertModules);
					for($i = 0, $j = 0; $i < count($InsertModules); $i++)
					{
						$strSQL .= "(?,?),";
						$Params[$j++] = $InsertModules[$i];						
						$Params[$j++] = $idperfil;
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
		
?>