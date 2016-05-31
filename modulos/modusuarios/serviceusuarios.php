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
                $stmt = $mysqli->select("usuarios",
                ["idusuario","nombre","apellido","email","estado"]);
                
                if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }                
                
                foreach ($stmt as $row)
                {
                    GetRowHTML($row);
                }
                               
				break;		
		case 2: // Insertar
				$Data = 
				[
					"idusuario" => $_POST["idusuario"],
					"nombre" 	=> $_POST["nombre"],
                    "apellido" 	=> $_POST["apellido"],
					"email" 	=> $_POST["email"],
					"estado" 	=> $_POST["estado"],
					"llave" 	=> hash('sha512',rand()),
					"password" 	=> $_POST["password"],
					"#fecha_registro" => "NOW()" 
				];				
				$Data["password"] = hash('sha512',$Data["password"] . $Data["llave"]);															
				$mysqli->insert("usuarios",$Data);
				if( CheckDBError($mysqli) ) return;								
				
				GetRowHTML($Data);
				                    				
				break;
		case 3: //Actualizar
		case 4: //Eliminar
            $idusuario = $_POST["idusuario"];
			
            $mysqli->delete("usuarios",
            [
				"AND" =>
            [
				"idusuario" => $idusuario					
			]
			]);			
                
           if( CheckDBError($mysqli) ) return false;
           echo "0" ;
							
				break;							
	}
	
	
	function GetRowHTML($row)
	{
		echo 
		'
            
				   <li    id="User_'.$row["idusuario"].'" class="dataitems">
                            <a href="usuarioperfil/'.$row["idusuario"].'">';
                    echo'
                                <div class="col s12 m4 four-cards">                                    
                                    <div class="card custom-small">
                                        <div class="row center description">   
                                            <img id="UserImage" class="circle responsive-img" style="width:90px;height:90px;object-fit:cover;" src="'.GetUserImagePath($row["idusuario"],true).'">
                                        </div>

                                        <div id="user-overview'.$row["idusuario"].'" class="center card-content-custom">                                    
                                            <div id="getid" style="display:none" class="grey-text card-subtitle-small ">'.$row["idusuario"].'</div>
                                            <div class="black-text card-title-small">'.$row["nombre"]." ".$row["apellido"].'</div>
                                            <div class="grey-text card-subtitle-small ">'.$row["email"].'</div>
                                            <a style="margin-top:15px;" class=" btn-flat blue-text lighten-1" onclick="javascript:Eliminar('.$row["idusuario"].')">Eliminar</a>
                                        </div>
                                    </div> 
                                </div>
                                </a>
                            </li>
					';
                    
					
	}
	
	
	//Functions

    function GetDropDownSettings($id,$Items)
	{
		$HTMLResult = 
		"<a style='margin-top:15px;' class='dropdown-button btn-flat blue-text lighten-1' href='#' data-activates='cbSettingsRow_$id'>Administrar</a>
			<ul id='cbSettingsRow_$id' class='dropdown-content'>";
			
		
		foreach($Items as $Item)
		{
			//Skip if custom condition doest meet.
			if(isset($Item["ifonly"]) && $Item["ifonly"] != true)
				continue;
			
			if(isset($Item[0]) == "divider")
			{
				$HTMLResult .= "<li class=\"divider\"></li>";
				continue;
			}
			
			$HTMLResult .= "<li". ((isset($Item["id"])) ? "id=\"".$Item["id"]."\"" : "" ) .">";
			$HTMLResult .= "<a class=\"truncate\" href=".((isset($Item["href"])) ? str_replace("%id",$id,$Item["href"]) : "" ) . ">";
			if(isset($Item["icon"])) $HTMLResult .= "<i class=\"material-icons left\">".$Item["icon"]."</i>";
			$HTMLResult .= $Item["contenido"] . "</a></li>";
		}
		
		$HTMLResult .= "</ul>";
		
		return $HTMLResult;
	}
	function GetMenuArray()
	{
		//Datarow menu
		return array(
			array
			(
				"href" 		=> "usuarioperfil/%id",
				"icon" 		=> "account_circle",
				"contenido" => "Ver Perfil"
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
	
	function GetIconHTML($b)
	{
		if($b)
			return "<i class=\"material-icons green-text\">check</i>";
		
		return "<i class=\"material-icons red-text\">close</i>";
	}

?>