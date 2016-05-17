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
                   
                   "proyectos.idproyecto",
                    
                    "proyectos.nombre",
                    "proyectos.lugar",
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
					'   <li    id="'.$row["idproyecto"].'" class="dataproyectos">
                            <a href="crearproyecto/'.$row["idproyecto"].'">';
                    echo'
                                <div class="col s12 m4 l4">                                    
                                    <div class="card custom-small">
                                        <div class="card-image">   
                                            <img id="ProyectImage" class="responsive-img" style="height:120px;width:100%" src="'.GetProyectImagePath($row["idproyecto"], true).'">
                                        </div>

                                        <div id="proyect-overview'.$row["idproyecto"].'" class="card-content-custom">                                            
                                            <div class="black-text card-title-small">'.$row["nombre"].'</div>
                                            <div class="grey-text card-subtitle-small ">'.$row["lugar"].'</div>
                                        </div>
                                    </div> 
                                </div>
                                </a>
                            </li>
					';
				}
				break;		
		case 2: // Insertar	
            $nombre      	  = $_POST["nombre"];
            $lugar   	      = $_POST["lugar"];
           // $fecharealizacion = $_POST["fecharealizacion"];
            
            
            $last_id = $mysqli->insert("proyectos",
                [
                    "nombre"    => $nombre,
                    "lugar"     => $lugar                    
                   
                ]);
                
                     
            if(!$last_id)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
                echo $last_id;
				break;
		case 3: //Actualizar                                
            $mysqli->action(function($mysqli)
				{				
					$idproyecto = $_POST['idproyecto'];				
					$newnombre = $_POST['nombre-proyecto'];
                    $newlugar = $_POST['lugar-proyecto'];
                    $newcontenido = $_POST['contenido-proyecto'];
                    $newfecha = $_POST['fecha-proyecto'];
                    $imagen		= $_FILES['imagen']['tmp_name'];
								
				if($imagen != "")
				{
					$target_dir = "../../uploads/images/";
					$imageFileType = pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);  										
					$target_file = $target_dir.$idproyecto.".".$imageFileType;
					//echo "Imagen->".$target_file."<br>";
					if(!move_uploaded_file($imagen,$target_file))
					{
						echo "<h5> Imagen no fue actualizada </h5>";
					}
					else
					{
						foreach(glob("../../uploads/images/".$idproyecto.".*") as $Img)
						{
							if($Img != $target_file)
								unlink($Img);
						}
					}
				}	
					
					$mysqli->update("proyectos",
						[
                            "nombre" => $newnombre,
                            "lugar"  => $newlugar,
                            "contenido" => $newcontenido,
                            "fecha" => $newfecha
                        ],[
							"AND" => 
							[
								"idproyecto" => $idproyecto
								
							]
						]);
						
						if( CheckDBError($mysqli) ) return false;
				echo $idproyecto;      
                });
										
					
				break;
								
		case 4: //Eliminar	
			
				
           break;	
            
	}
    
    
?>