<?php
	require_once("../../config.php");
	require_once("../../funciones.php");		
	
	 $accion = isset($_GET['accion']) ? $_GET['accion'] : null;
     
     if(empty($accion))
        return;
    
     $response = new StdClass;
     switch ($accion) 
     {
         case 1:
             $IDTipoServicio = $_POST["idcat"];
             $stmt = $mysqli->select("servicios",["servicio"],["idtiposervicio" => $IDTipoServicio]);
             if( CheckDBError($mysqli) ) return;

             $response->status = 200;             
             $response->data = $stmt;
             echo json_encode($response);
             break;         
     }
?>