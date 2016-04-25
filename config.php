<?php
    require_once '/recursos/medoo.php';    
        
    try
    {
        $mysqli = @ new medoo([
            'database_type' => 'mysql',
            'database_name' => 'bd5',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
            ]);
    }
    catch(Exception $e)
    {
        echo 'Error: ' .$e->getMessage();
        die();
    }                 
                
    $tema = "temas/sinhco/";
?>