<?php	    
	require_once("config.php");
	require_once("funciones.php");
    
    $OnDashboard = 1;     
    inicio_sesion();
    
    if(!login_check($mysqli))
    {
        header("Location: login");
        die();
    }
    //Test
    //$modulo = ( isset($_GET['mod']) ) ? $_GET['mod'] : "dashboard";                                      
    // para el desktop
    // cogito ergo sum.
    // Just commit.
    // Commit and Push!
    $modulo = ( !URLParam(1) ) ? "dashboard" : URLParam(1);
    
    echo $modulo;
	require_once($tema."dashboard.tema.php");    
?>