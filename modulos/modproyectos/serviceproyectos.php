<?php
	require_once("../../config.php");
	require_once("../../funciones.php");		
	
	//1 = Consulta; 2 = Insertar; 3 = Actualizar; 4 = Eliminar;
	$accion = $_GET["accion"];
	switch($accion)
	{
		case 1: // Consulta
				$stmt = $mysqli->select("proyectos",
                [
                    "proyectos.idproyecto",                    
                    "proyectos.nombre",
                    "proyectos.lugar",
                    "proyectos.contenido",
                    "proyectos.fecha"
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
                                    <img class="responsive-img" src="'.GetProyectImagePath($row["idproyecto"], true).'">      
                                    <span class="card-title">'.$row["nombre"].'</span>
                                </div>
                                <div class="card-content">
                                    <p class="grey-text ">'.$row["lugar"].'</p>
                                    <p class="truncate">'.$row["contenido"].'</p>
                                </div>
                                <div class="card-action">
                                  <a href="'.$row["idproyecto"].'">Ver Proyecto</a>
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
				
           break;	
            
	}
    
    function GetMenuArray()
	{
	
	}
?>