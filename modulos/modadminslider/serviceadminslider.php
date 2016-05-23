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
				$stmt = $mysqli->select("slider",
                [                   
                   "idslider",                    
                    "nombre",                    
                ]);
            
                if( CheckDBError($mysqli) ) return;				
                
                foreach($stmt as $row)
				{
					$ImageCount = $mysqli->count("slider_img_mod",
					[
						"idslider" => $row["idslider"],
                        "GROUP" => "idimagen"
					]);
					
                    echo 
					'   <li id="CSlider_'.$row["idslider"].'" class="dataitems" style="display:none">
                            <a href="editslider/'.$row["idslider"].'">
						      <div class="col s12 m4 four-cards">                                    
                                    <div class="card hoverable custom-small" style="height:197px">
                                        <div class="card-image">   
                                            <img id="coverImage" class="responsive-img" style="height:120px;width:100%; object-fit:cover" src="'.GetProyectImagePath("CoverSlider-".$row["idslider"], true).'">
                                        </div>
                                        <div id="cover-overview_'.$row["idslider"].'" class="card-content-custom" style="height:48px">                                            
                                            <div class="black-text card-title-small">'.$row["nombre"].'</div>
                                            <div class="grey-text card-subtitle-small ">'.$ImageCount.' Imagenes</div>
                                        </div>
                                    </div> 
                                </div>
							</a>
						</li>
					';
				}
				break;		
		case 2: // Insertar	

		case 3: //Actualizar                                

		case 4: //Eliminar									
            
	}
    
    
?>