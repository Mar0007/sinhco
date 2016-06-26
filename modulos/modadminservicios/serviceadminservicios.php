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
	switch ($accion) 
    {
        case 1: //Consulta
            $stmt = $mysqli->select("tipo_servicio",
            [
                "idtiposervicio","nombre","tipo_servicio.descripcion"
            ]);
            if( CheckDBError($mysqli) ) return;

            foreach ($stmt as $row) 
                echo GetCardHTML($row);

            break;

        case 2: //Insertar
            
            //Execute query
            $mysqli->action(function($mysqli){
                $data = 
                [
                    "nombre"      => $_POST['nombre'],
                    "descripcion" => $_POST['descripcion']
                ];
                $imagen		= $_FILES['imagen']['tmp_name'];

                $last_id = $mysqli->insert("tipo_servicio",$data);
                if( CheckDBError($mysqli) ) return false;

                if($imagen != "")
                {
                    $target_dir = "../../uploads/images/servicios/";
                    $imageFileType = pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);  										
                    $target_file = $target_dir."Servicio-".$last_id.".".$imageFileType;

                    if(!move_uploaded_file($imagen,$target_file))
                    {
                        echo "<h5> Imagen no fue subida </h5>";
                        return false;
                    }
                    else
                        foreach(glob($target_dir."Servicio-".$last_id.".*") as $Img)
                        {
                            if($Img != $target_file)
                                unlink($Img);
                        }
                }

                $data["idtiposervicio"] = $last_id;            
                echo GetCardHTML($data);
            });

            break;
        case 3: //Actualizar
            $mysqli->action(function($mysqli)
            {
                $response = new StdClass;
                $IDServicio = $_POST["id"];
                $data = 
                [
                    "nombre"      => $_POST['nombre'],
                    "descripcion" => $_POST['descripcion']
                ];
                $imagen		= $_FILES['imagen']['tmp_name'];

                $mysqli->update("tipo_servicio",$data,["idtiposervicio" => $IDServicio]);
                if( CheckDBError($mysqli) ) return false;

                if($imagen != "")
                {
                    $target_dir = "../../uploads/images/servicios/";
                    $imageFileType = pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);  										
                    $target_file = $target_dir."Servicio-".$IDServicio.".".$imageFileType;

                    if(!move_uploaded_file($imagen,$target_file))
                    {
                        echo "<h5> Imagen no fue subida </h5>";
                        return false;
                    }
                    else
                        foreach(glob($target_dir."Servicio-".$IDServicio.".*") as $Img)
                        {
                            if($Img != $target_file)
                                unlink($Img);
                        }
                    
                    $response->imgurl = GetServiceImagePath($IDServicio,true);
                }

                
                $response->status = 200;                
                echo json_encode($response);           
            });        
            break;
        case 4: //Eliminar        
            $IDServicio = $_POST["id"];

            //Exec Query
            $mysqli->delete("tipo_servicio",["idtiposervicio" => $IDServicio]);
            if( CheckDBError($mysqli) ) return;

            //Delete service resources
            $target_dir = "../../uploads/images/servicios/";
            foreach(glob($target_dir."Servicio-".$IDServicio.".*") as $Img)
                unlink($Img);
            
            //Notify
            echo "0";            

            break;
    }


    function GetCardHTML($row)
    {
        return 
        '<li id="Card_'.$row["idtiposervicio"].'">
            <a href="listaservicio/'.$row["idtiposervicio"].'">
                <div class="col s12 m4 four-cards"> 
                    <div class="card custom-small">                
                        <div class="card-image">
                            <img id="cardimg" class="responsive-img" style="height:120px;width:100%; object-fit:cover" src="'.GetServiceImagePath($row["idtiposervicio"],true).'">
                            <input id="InitImage" type="hidden" value="">
                        </div>            
                            '.GetDropDownSettingsRow($row["idtiposervicio"],GetMenuArray(),'dropdown-button btn-flat right no-padding grey-text','margin-right:10px').'
                        <div class="card-content-custom" style="">                          
                            <div class="black-text card-title-small">'.$row["nombre"].'
                            </div>
                            <div class="grey-text card-subtitle-small" style="white-space:unset">'.$row["descripcion"].'</div>                     
                        </div>                
                    </div>
                </div>
            </a>
        </li>
    ';
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
				"href" 		=> "javascript:Eliminar('%id')",
				"icon" 		=> "delete",
				"contenido" => "Eliminar"
			)
		);		
	}    
?>