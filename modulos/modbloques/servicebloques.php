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
		
				$stmt = $mysqli->select("bloques",["idbloque","bloque","tipo"]);				
				
				if( CheckDBError($mysqli) ) return;
				
				foreach ($stmt as $row) 
				{
					echo "<tr class=\"databloques\" id=\"".$row["idbloque"]."\" style=\"display:none\">
							<td>".$row["idbloque"]."</td>
							<td>".$row["bloque"]."</td>
							<td>".GetIconHTML($row["tipo"])."</td>
							<td>".GetDropDownSettingsRow($row["idbloque"],GetMenuArray($row["tipo"] == 0))."</td>
							</tr>";							
				}
								
				break;			
		case 2: // Insertar
				break;
		case 3: //Actualizar
				break;
		case 4: //Eliminar				
				$idbloque = $_POST["idbloque"];
				
				$mysqli->delete("bloques",["idbloque" => $idbloque]);
				if( CheckDBError($mysqli) ) return;
				
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
				"href" 		=> GetURL("dashboard/crearbloque/%id"),
				"icon" 		=> "edit",
				"contenido" => "Editar"
			),
			/*array
			(
				"href" 		=> "javascript:Modulos('%id')",
				"icon" 		=> "view_module",
				"contenido" => "Modulos"
			),
			*/
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