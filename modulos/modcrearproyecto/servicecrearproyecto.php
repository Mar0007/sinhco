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
				
				break;		
		case 2: // Insertar				
            $nombre      	= $_POST["nombre"];
            $lugar   	    = $_POST["lugar"];
            $fechaproyecto  = $_POST["fechaproyecto"];
			$descripcion    = $_POST["descripcion"];
            $idusuario      = $_SESSION['idusuario'];
            
            $stmt = $mysqli->insert("proyectos",
                [
                    "nombre"    => $nombre,
                    "lugar"     => $lugar,
                    "fecha"     => $fechaproyecto,
                    "contenido" => $descripcion,
                    "idusuario" => $idusuario
                ]);
                
                     
            if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
				break;
		case 3: //Actualizar                                
                             
				break;
								
		case 4: //Eliminar	
												
				break;				
		
    
	}
?>