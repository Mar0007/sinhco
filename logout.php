<?php
	require("funciones.php");
	inicio_sesion();
	
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
	header('Location: ./index.php');
?>