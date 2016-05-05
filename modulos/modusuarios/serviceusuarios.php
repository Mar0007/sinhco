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
                    echo 
                    '
                        <tr class="datausuarios" id="'.$row["idusuario"].'" style="display:none">
							  <td><a href="usuarioperfil/'.$row["idusuario"].'">'.$row["idusuario"].'</a></td>
							  <td>'.$row["nombre"].'</td>
							  <td>'.$row["email"].'</td>
							  <td>'.GetIconHTML($row["estado"]).'</td>
							  <td>'.GetDropDownSettingsRow($row["idusuario"],GetMenuArray()).'</td>
                        </tr>                        
                    ';
                }
                               
				break;		
		case 2: // Insertar
				$idusuario 	= $_POST["idusuario"];
				$usuario   	= $_POST["nombre"];
				$email   	= $_POST["email"];
				$estado   	= $_POST["estado"];
				$password   = $_POST["password"];
				$llave 		= hash('sha512',rand());
				$password 	= hash('sha512',$password . $llave);
				
				$strSQL   = "INSERT INTO usuarios(idusuario, nombre, email, estado, llave, password, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, NOW());";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ssssiiss',$idusuario,$usuario,$email,$estado,$llave,$password);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
					}
					else
					{
						echo "<tr class=\"datausuarios\" id=\"$idusuario\" style=\"display:none\">
							  <td><a href=\"index.php?mod=usuarioperfil&idusuario=$idusuario\">$idusuario</a></td>
							  <td>$usuario</td>
							  <td>$email</td>
							  <td>".GetIconHTML($estado)."</td>
							  <td>".GetDropDownSettingsRow($idusuario,GetMenuArray())."</td>
							  </tr>";
					}										
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
                    				
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