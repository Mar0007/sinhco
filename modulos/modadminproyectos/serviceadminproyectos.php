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
				$stmt = $mysqli->select("proyectos",
                [
                    "idproyecto",
                    "nombre",
                    "lugar",
                    "contenido",
                    "fecha"
                ],                
                [
                    "ORDER" => "fecha DESC"
                ]);
            
                if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
                
                foreach($stmt as $row){
                    echo 
					'
						<li id="'.$row["idproyecto"].'" class="dataproyectos collection-item avatar">
							<img src="/sinhco/recursos/img/proyect.jpg" class="circle">
							<a  class="black-text" href="#!">
								<span class="title">'.$row["nombre"].'</span>								
							</a>                 
							<p class="grey-text lighten-2 title">'.$row["lugar"].' </p>
							<p class="grey-text lighten-2">Proyecto realizado: '.$row["fecha"].'</p>
							<a class="">
                                    '.GetDropDownSettingsRow($row["idproyecto"],GetMenuArray()).'
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
			$IDProyecto = $_POST["idproyecto"];
			
            $mysqli->delete("proyectos",
            [
				"AND" =>
            [
				"idproyecto" => $IDProyecto					
			]
			]);			
                
           if( CheckDBError($mysqli) ) return false;
           echo "0" ;
				
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
				"href" 		=> "javascript:eliminar('%id')",
				"icon" 		=> "delete",
				"contenido" => "Eliminar"
			)
		);		
	}
?>