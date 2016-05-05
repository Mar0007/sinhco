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
				$stmt = $mysqli->select("modulos",["idmodulo","modulo","tipo"],["tipo" => 0]);
				
				if(CheckDBError($mysqli))
					return;
				
				foreach ($stmt as $row) 
				{
					echo 
					'
						<li id="'.$row["idmodulo"].'" style="display:none" class="dataitems collection-item avatar">
							<i class="material-icons circle" style="background-color:#1665c1">view_module</i>
							<a  class="black-text" href="#!">
								<span class="title">'.$row["modulo"].'</span>								
							</a>                 
							<p class="grey-text lighten-2 title">Descripcion del el modulo muy descriptivo.</p>
							<a class="">
									'.GetDropDownSettingsRow($row["idmodulo"],GetMenuArray($row["tipo"] == 0)).'
							</a> 
																				
						</li>
					';									
					
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
				"href" 		=> GetURL("dashboard/crearmodulo/%id"),
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