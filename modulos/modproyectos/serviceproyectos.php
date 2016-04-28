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
                    "[>]proyectos_img" => [
                        "idproyecto" => "idproyecto"
                    ]                    
                    
                ],[
                    "proyectos.idproyecto",
                    "proyectos_img.ruta",
                    "nombre",
                    "lugar",
                    "contenido",
                    "fecha"
                ],[
                    "ORDER" => "proyectos.fecha DESC",
                   
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
						<li id="'.$row["idproyecto"].'" class="dataproyectos col s12 m6 ">
							<div class="card medium hoverable">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="responsive-img" src="'.$row["ruta"].'">      
                                    <span class="card-title">'.$row["nombre"].'</span>
                                </div>
                                <div class="card-content">
                                    <p class="grey-text ">'.$row["lugar"].'</p>
                                    <p class="truncate">'.$row["contenido"].'</p>
                                </div>
                                <div class="card-action">
                                  <a href="#">Ver Proyecto</a>
                                </div>
                            </div>           
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