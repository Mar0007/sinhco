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
				$stmt = $mysqli->select("modulos",["idmodulo","modulo","tipo"]);
				
				if(CheckDBError($mysqli))
					return;
				
				foreach ($stmt as $row) 
				{
					echo "<tr class=\"datamodulos\" id=\"".$row["idmodulo"]."\" style=\"display:none\">
							<td>".$row["idmodulo"]."</td>
							<td>".$row["modulo"]."</td>
							<td>".GetIconHTML($row["tipo"])."</td>
							<td>".GetDropDownSettingsRow($row["idmodulo"],GetMenuArray($row["tipo"] == 0))."</td>
							</tr>";
				}
							
				break;			
		case 2: // Insertar
				break;
		case 3: //Actualizar
				break;
		case 4: //Eliminar				
				$idmodulo = $_POST["idmodulo"];
				
				$mysqli->delete("modulos",["idmodulo" => $idmodulo]);
				if(CheckDBError($mysqli))
					return;
				
				echo "0";				
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