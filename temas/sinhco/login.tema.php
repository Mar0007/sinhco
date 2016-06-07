<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="es_HN" http-equiv="Content-Language">
    <meta name="Author" content="Negocios Web">
    <meta name="Designer" content="UNICAH">
    <meta name="Date" content="17 de Septiembre de 2015">

    <!-- JQuery -->
    <script type="text/javascript" src="<?php echo GetURL("recursos/jquery.js")?>"></script>				
    <!-- JQuery UI -->
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/jquery-ui.min.css")?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/jquery-ui.structure.min.css")?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/jquery-ui.theme.min.css")?>"/>
    <script src="<?php echo GetURL("recursos/jquery-ui.min.js")?>"></script>      
    
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL($tema."css/materialize.min.css")?>" media="screen,projection">
    <script type="text/javascript" src="<?php echo GetURL($tema."js/materialize.min.js")?>"></script>
    
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Sweet Alert -->
    <script src="<?php echo GetURL("recursos/sweetalert/dist/sweetalert.min.js")?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo GetURL("recursos/sweetalert/dist/sweetalert.css")?>">        
    
    <!-- Custom CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL($tema."css/styles.css")?>" media="screen,projection">
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/iconfont.css")?>">
    
    <script>        
    </script>
    
    <style>                
    </style>
</head>
<body>    
    <div class="row center " style="margin-top: 50px">
        <div class="col s12">
            <img src="<?php echo GetURL("recursos/img/sinhco.png")?>">
        </div>  
    </div>
    <div class="row center ">
        <div class="col s12">
            <h4 class="light">Brindando soluciones reales y prácticas.</h4>
            
        </div>  
    </div>
    <div class="container center-wrapper" style="margin-top: 50px">        
        <div class="row">
            <?php
                modulo('login',$mysqli,"bloque card-panel ");
            ?>
        </div>
    </div>
</body>
</html>