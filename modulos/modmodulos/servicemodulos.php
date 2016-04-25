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
		case 1: // Consulta
				$strSQL = "SELECT idmodulo, modulo, tipo FROM modulos";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($idmodulo,$modulo, $tipo);					
										
					while ( $stmt->fetch() )
					{
						echo "<tr class=\"datamodulos\" id=\"$idmodulo\" style=\"display:none\">
							  <td>$idmodulo</td>
							  <td>$modulo</td>
							  <td>".GetIconHTML($tipo)."</td>
							  <td>".GetDropDownSettingsRow($idmodulo,GetMenuArray($tipo == 0))."</td>
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
				$idmodulo = $_POST["idmodulo"];
				$strSQL = "DELETE FROM modulos WHERE idmodulo = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idmodulo);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";	
				}
				else
					echo "Error en la consulta: " . $mysqli->error;		
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
				"href" 		=> "index.php?mod=crearmodulo&idmodulo=%id",
				"icon" 		=> "edit",
				"contenido" => "Editar"
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