<?php	
	require_once("config.php");
	require_once("funciones.php");
	
	inicio_sesion();	                    
        
    if(!isset($modulo))
    {
        $modulo = ( !URLParam(0) ) ? "inicio" : URLParam(0);
        
        //$Fix not going to 404 when in subfolder
        $DirArray = scandir('.');
        if(in_array($modulo,$DirArray))
        {
            require_once($tema."404.tema.php");
            return;
        }
    }
        
    
    $WebTitle = "Sinhco";    

    switch($modulo)
    {
        case "dashboard":
        {
            if(!login_check($mysqli))
            {
                $_SESSION['urltemp'] = $_SERVER['REQUEST_URI'];
                header("Location: " . GetURL("login"));
                die();
            }
            $_SESSION['urltemp'] = "";
            $OnDashboard = 1;
            if(URLParam(1)) $modulo = URLParam(1);            
            
            AddHistory("Dashboard",GetURL("dashboard/inicio"));            
            require_once($tema."dashboard.tema.php");            
            break;
        }
        case "404":
            require_once($tema."404.tema.php");
            break;
        case "login":
        case "resetpass":
            header("Location: " . GetURL("login"));
            die();        
            break;
        case "reset":
            $loginmod = "resetpass";
            require_once($tema."login.tema.php");
            break;
        
        default: 
            $SEGURIDAD = 1; 
            require_once($tema."index.tema.php");             
            break;
    }	    
?>
