<?php
    $Modulo = modulo($loginmod ,$mysqli, "bloque card-panel width", "login-card",true);
    
    if(empty($Modulo))
    {
        require_once($tema."404.tema.php");
        return;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="es_HN" http-equiv="Content-Language">
    <meta name="Author" content="Negocios Web">
    <meta name="Designer" content="UNICAH">
    <meta name="Date" content="17 de Septiembre de 2015">
    <title><?php echo $WebTitle ?></title>

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
    <header>
        <div class="navbar">
            <nav class="light-blue z-depth-0">
                <div class="nav-wrapper">
                    <div class="" >
                       <img class="brand-logo center responsive-img" style="max-height:44px;margin-top:10px; margin-left:0px" src="<?php echo GetURL("uploads/static/sinhco-white.svg");?>">                        
                        <h5 class="center no-pad no-margin" style="position:relative;padding-top:70px">Inicia sesión para administrar el sitio</h5>
                    </div>
                    
                </div>
            </nav>
        </div>        
    </header>
    <div class="light-blue " style="height:28vh;"></div>
    <!-- here comes the login panel-->
    <div class="container center-wrapper" style="margin-top: -17vh; ">        
        <div class="row">
            <?php
                echo $Modulo;
            ?>
        </div>
        
    </div>    
    
</body>
    <script>
      $(document).ready(function(){
        $('.tooltipped').tooltip({delay: 50});
      });
    </script>
</html>