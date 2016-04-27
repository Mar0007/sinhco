<?php	
	require_once("config.php");
	require_once("funciones.php");
	
	inicio_sesion();	                
    
    //$modulo = ( isset($_GET["mod"]) ) ? $_GET["mod"] : "inicio";
        
    $modulo = ( !URLParam(0) ) ? "inicio" : URLParam(0);    

    switch($modulo)
    {
        case "dashboard":
        {
            if(!login_check($mysqli))
            {
                header("Location: " . GetURL("login"));
                die();
            }                        
            $OnDashboard = 1;
            if(URLParam(1)) $modulo = URLParam(1);
            require_once($tema."dashboard.tema.php");              
            break;
        }
        default: 
            $SEGURIDAD = 1; 
            require_once($tema."index.tema.php");             
            break;
    }	    
?>
