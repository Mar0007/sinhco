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
	switch($accion)
	{
		case 1: // Consulta
				$strSQL = "SELECT idarticulo, titulo, fecha, estado FROM mod_articulos";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($idarticulo,$titulo,$fecha,$estado);					
										
					while ( $stmt->fetch() )
					{
						echo "<tr class=\"dataArticulos\" id=\"$idarticulo\" style=\"display:none\">
							  <td>$idarticulo</td>
							  <td>$titulo</td>
							  <td>".date("Y-m-d", strtotime($fecha)) ."</td>
							  <td>".GetIconHTML($estado)."</td>
							  <td>".GetDropDownSettingsRow($idarticulo,GetMenuArray())."</td>							  
							  </tr>";
					}
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
							
				break;			
		case 2: // Insertar
				break;
		case 3: //Actualizar
				break;
		case 4: //Eliminar				
				$idarticulo = $_POST["idarticulo"];
				$strSQL = "DELETE FROM mod_articulos WHERE idarticulo = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$idarticulo);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "0";	
				}
				else
					echo "Error en la consulta: " . $mysqli->error;		
				break;				
	}
	
	//Functions	
	function GetIconHTML($b)
	{
		if($b)
			return "<i class=\"material-icons green-text\">check</i>";
		
		return "<i class=\"material-icons red-text\">close</i>";
	}	

	function GetMenuArray()
	{
		//Datarow menu
		return array(
			array
			(
				"href" 		=> "index.php?mod=creararticulo&idarticulo=%id",
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