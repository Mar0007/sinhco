<?php	    
	require_once("config.php");
	require_once("funciones.php");
    
    inicio_sesion();
    
    if(isset($_GET['action']))
    {
        $Action = strtolower($_GET['action']);
        if($Action == "logout")
        {
            //Borramos los datos de la variable de sesion;
            $_SESSION = array();
            
            //Obtener los parametros de la Cookie
            $param = session_get_cookie_params();
            
            //Borramos la Cookie Actual
            setcookie(session_name(), '' , 
                        time() - 86400, $param["path"], $param["domain"], 
                        $param["secure"], $param["HTTPOnly"]);
                        
            //Destruimos la Sesion
            session_destroy();
            
            //Regresamos al Index
            header('Location:'.GetURL("inicio"));
            die();            
        }
    }
    
    if(login_check($mysqli))
    {
		if(isset($_SESSION['urltemp']) && $_SESSION['urltemp'] != "")
		{
			header("Location: " . $_SESSION['urltemp']);
			die();
		}        
        
        header("Location: dashboard");
        die();
    }
                                          
	require_once($tema."login.tema.php");
?>