<?php	    
	require_once("config.php");
	require_once("funciones.php");
    
    inicio_sesion();
    
    if(login_check($mysqli))
    {
        header("Location: dashboard");
        die();
    }
                                          
	require_once($tema."login.tema.php");
?>