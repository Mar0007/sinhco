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
            "proyectos.contenido",
            "proyectos.fecha"
        ],[
            "ORDER" => "proyectos.fecha DESC",
            "LIMIT"=> [$no, 6]
        ]);

        
        if(empty($stmt)){
            echo "none";
            return;
        }
        
        if(!$stmt)
        {
            if($mysqli->error()[2] != "")
                echo "Error:".$mysqli->error()[2];

            return;
        }
        
		foreach($stmt as $row){
            $content=substr(strip_tags($row["contenido"]), 0, 100) . "...";
            echo 
            '
                <li id="'.$row["idproyecto"].'" class="dataproyectos col s12 m6 ">
                    <div class="card medium hoverable">
                        <div class="card-image waves-effect waves-block waves-light">
                            <a href="proyectview/'.$row["idproyecto"].'">
                                <img class="responsive-img" src="'.GetProyectImagePath($row["idproyecto"], true).'">
                                <span class="card-title">'.$row["nombre"].'</span>
                            </a>
                        </div>
                        <div class="card-content">
                            <p class="grey-text ">'.$row["lugar"].'</p>
                            <p class="">'.$content.'</p>
                        </div>
                        <div class="card-action">
                          <a href="proyectview/'.$row["idproyecto"].'">VER PROYECTO</a>
                        </div>
                    </div>           
                </li>
            ';
            
        }

    }
    else{
        echo "Error en la formulacion de la consulta";
        echo $mysqli->eh1rror;
    }

	
?>