<?php
    require_once 'recursos/medoo.php';    
    
    //Mail info
    $phpEmailUser = "fbsinhco@gmail.com";
    $phpEmailPass = "Jugomontana";
    
    //PhpMailer
    $UsePHPMailer = true;
    $EmailHost = 'smtp.gmail.com';
    $EmailPort = 587;
    $EmailUseSMTPAuth = true;
    $EmailSMTPSecure = 'tls'; 

    try
    {
        $mysqli = @ new medoo([
            'database_type' => 'mysql',
            'database_name' => 'bd5',
            'server' => '127.0.0.1',
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