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
                ["idusuario","nombre","email","estado"]);
                
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
					"usuario" 	=> $_POST["nombre"],
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
				$strSQL = "DELETE FROM usuarios WHERE idusuario = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idusuario);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
				}				
				break;							
	}
	
	
	function GetRowHTML($row)
	{
		echo 
		'
			<li id="'.$row["idusuario"].'" style="display:none" class="dataitems collection-item avatar">
				<img src="'.GetUserImagePath($row["idusuario"],true).'" class="circle">
				<a  class="black-text" href="#!">
					<span class="title">'.$row["nombre"].'</span>								
				</a>                 
				<p class="grey-text lighten-2 title">'.$row["idusuario"].' </p>
				<p class="grey-text lighten-2">'.$row["email"].'</p>
				<a class="">
						'.GetDropDownSettingsRow($row["idusuario"],GetMenuArray()).'
				</a> 
																	
			</li>
		';				
	}
	
	
	//Functions
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