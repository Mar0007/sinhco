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
    $response = new StdClass;
	switch ($accion) 
    {
        case 1:
            $IDTipoServicio = $_POST['idcat'];
            $stmt = $mysqli->select("servicios",
            [
                "idservicio","servicio"
            ],
            [
                "idtiposervicio" => $IDTipoServicio
            ]);
            if( CheckDBError($mysqli) ) return;

            $response->html = "";
            foreach ($stmt as $row) 
                $response->html .= GetCardHTML($row);

            $response->status = 200;                
            echo json_encode($response);           
            break;

        case 2: //Insertar
            $data = 
            [
                "servicio"       => $_POST["titulo"],
                "idtiposervicio" => $_POST["idcat"]
            ];

            $last_id = $mysqli->insert("servicios",$data);
            if( CheckDBError($mysqli) ) return;
            
            $data["idservicio"] = $last_id;
            $response->html = GetCardHTML($data);
            $response->status = 200;                
            echo json_encode($response);           
            
            break;
        case 3: //Actualizar
            $data = 
            [
                "idservicio"     => $_POST["idser"],
                "servicio"       => $_POST["titulo"]
            ];

            $mysqli->update("servicios",
            [
                "servicio" => $data["servicio"]
            ],
            [
                "idservicio" => $data["idservicio"]
            ]);
            if( CheckDBError($mysqli) ) return;
            $response->status = 200;                
            echo json_encode($response);           
            break;
        case 4: //Eliminar
            $data = 
            [
                "idservicio"     => $_POST["idser"]
            ];
            $mysqli->delete("servicios",$data);
            if( CheckDBError($mysqli) ) return;

            $response->status = 200;                
            echo json_encode($response);
            break;            
    }

    function GetCardHTML($row)
    {
        return 
        '<li id="Serv_'.$row["idservicio"].'" class="collection-item" data-id="'.$row["idservicio"].'">
            <div>
                <span class="content">'.$row["servicio"].'</span>
                '.GetDropDownSettingsRow($row["idservicio"],GetMenuArray(),'dropdown-button btn-flat secondary-content grey-text',"line-height:unset;padding:unset").'
            </div>
        </li>';        
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