<?php
	require_once("../../config.php");
	require_once("../../funciones.php");		
	
	 $no = $_POST['getresult'];
	
	if (isset($no) ) {
            $stmt = $mysqli->select("proyectos",
            [

               "proyectos.idproyecto",

                "proyectos.nombre",
                "proyectos.lugar",
                "proyectos.fecha" 

            ],[
               "ORDER" => "proyectos.idproyecto DESC",
                "LIMIT"=> [$no, 6]

            ]);

            if(!$stmt)
            {
                if($mysqli->error()[2] != "")
                    echo "Error:".$mysqli->error()[2];

                return;
            }
            
            if(empty($stmt))
            {
                echo "none";
                return;
            }	
            
            foreach($stmt as $row){
                echo 
                '   <li    id="'.$row["idproyecto"].'" class="dataproyectos">
                        <a href="crearproyecto/'.$row["idproyecto"].'">';
                echo'
                            <div class="col s12 m4 four-cards">                                    
                                <div class="card custom-small">
                                    <div class="card-image">   
                                        <img id="ProyectImage" class="responsive-img" style="height:120px;width:100%; object-fit:cover" src="'.GetProyectImagePath($row["idproyecto"], true).'">
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
            }}

	
?>