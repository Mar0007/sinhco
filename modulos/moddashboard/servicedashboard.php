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


    // Load libs
    require_once "../../recursos/linfo".'/init.php';

    // Begin
    try 
    {

    // Load settings and language
        $linfo = new Linfo;

    // Run through /proc or wherever and build our list of settings
        $linfo->scan();

    // Give it off in html/json/whatever
        $linfo->output();
    }

    // No more inline exit's in any of Linfo's core code!
    catch (LinfoFatalException $e) {
        echo $e->getMessage()."\n";
        exit(1);
    }

?>