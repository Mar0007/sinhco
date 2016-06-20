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
				$stmt = $mysqli->select("modulos",["idmodulo","modulo","tipo","descripcion"],["tipo" => 0]);
				
				if(CheckDBError($mysqli))
					return;

				if(empty($stmt))
				{
					echo "none";
					return;
				}					
				
				foreach ($stmt as $row) 
				{
<<<<<<< HEAD
                    $content=substr(strip_tags($row["modulo"]), 0, 1);
					echo 
					'
						<li id="'.$row["idmodulo"].'" style="display:none" class="dataitems collection-item avatar">
							<h5 class=" circle" style="text-align:center; vertical-align:middle; line-height:40px; color:#FFF;background-color:#1665c1">'.$content.'</h5>
							<a  class="black-text" href="#!">
								<span class="title">'.$row["modulo"].'</span>								
							</a>                 
							<p class="grey-text lighten-2 title">'.$row['descripcion'].'</p>
							<a class="">
									'.GetDropDownSettingsRow($row["idmodulo"],GetMenuArray($row["tipo"] == 0)).'
							</a> 
																				
						</li>
					';									
					
=======
					echo GetRowHTML($row);					
>>>>>>> 11a55e53e79d6fbef0a25f328af0595e0dace1e8
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

				if(is_dir("../../uploads/images/editor/M_" . $idmodulo . "/"))
					deleteDir("../../uploads/images/editor/M_" . $idmodulo . "/");

				echo "0";
		case 'search':
				$Keyword = $_POST['search'];	
				$stmt = $mysqli->select("modulos",["idmodulo","modulo","tipo","descripcion"],
				[
					"AND" => 
					[
						"tipo" => 0,
						"OR" => 
						[
							"modulo[~]" => $Keyword,
							"descripcion[~]" => $Keyword 							
						]
					]
				]
				);
				//echo $mysqli->last_query();
				
				if(CheckDBError($mysqli))
					return;

				if(empty($stmt))
				{
					echo "none";
					return;
				}					
				
				foreach ($stmt as $row) 
				{
					echo GetRowHTML($row);					
				}
										
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


	function GetRowHTML($row)
	{
		return
		'
			<li id="'.$row["idmodulo"].'" style="display:none" class="dataitems collection-item avatar">
				<i class="material-icons circle" style="background-color:#1665c1">view_module</i>
				<a  class="black-text" href="#!">
					<span class="title">'.$row["modulo"].'</span>								
				</a>                 
				<p class="grey-text lighten-2 title">'.$row['descripcion'].'</p>
				<a class="">
						'.GetDropDownSettingsRow($row["idmodulo"],GetMenuArray($row["tipo"] == 0)).'
				</a> 
																	
			</li>
		';		
	}				
?>