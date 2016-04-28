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
        $(document).ready(function() 
        {
            $(".button-collapse").sideNav();
            swal.setDefaults({ html: 'true' });
        });
        
        function InitDropdown()
        {
            $('.dropdown-button').dropdown({
                inDuration: 100,
                outDuration: 100,
                constrain_width: false,
                gutter: 0,
                belowOrigin: true,
                alignment: 'right'
                }
            );			  
        }
        
        function ShowLoadingSwal()
        {
            swal({
                title: "Cargando...",
                text: "<div class=\"preloader-wrapper big active\">"+
                    "<div class=\"spinner-layer spinner-blue-only\">"+
                        "<div class=\"circle-clipper left\">"+
                        "<div class=\"circle\"></div>"+
                        "</div><div class=\"gap-patch\">"+
                        "<div class=\"circle\"></div>"+
                        "</div><div class=\"circle-clipper right\">"+
                        "<div class=\"circle\"></div>"+
                        "</div></div></div>",
                html: true,
                allowEscapeKey:false,
                showConfirmButton: false
            });		  
        }        

    </script>
    
    <style>
        header, main, footer,html {
            padding-left: 240px;
        }

        @media only screen and (max-width : 992px) {
            header, main, footer,html {
                padding-left: 0;
            }
        }                  
    </style>
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="dashboard.php" class="brand-logo"><i class="material-icons left">cloud</i>Dashboard</a>
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>            
        </div>
    </nav>          
    
    <?php
        $idusuario = $_SESSION['idusuario'];
        
        $stmt = $mysqli->select("usuarios",["nombre"],["idusuario" => $idusuario]);
        if(!$stmt)
        {
            if($mysqli->error()[2] != "")
                echo "Error:".$mysqli->error()[2];
                
           return;
        }        
        $nombre = $stmt[0]["nombre"];
                
        echo menu($mysqli, 2, "side-nav fixed" ,"slide-out",
        '
        <div class="card" style="z-depth-0;margin-top:-1px;background-image: url('.GetURL("uploads/covers/cover.jpg").'); height:120px;background-size: 100% 100%;">                
            <div class="card-content" style="margin-left: -10px">
                <div class="row" >
                    <div class="col s5">
                        <img src="' . GetUserImagePath($idusuario) . '" alt="" class="circle responsive-img">
                    </div>
                    <div style="col s7">
                        <span class="white-text truncate">
                            '. $nombre .'
                        </span>
                    </div>
                </div>
            </div>                        
        </div>
        '
        );
    
    
    //<--- Load Module --->
    
      //$modulo = ( isset($_GET['mod']) ) ? $_GET['mod'] : "dashboard"; 
      modulo($modulo ,$mysqli, "card z-depth-0", "ModuleView");
    ?>
</body>
</html>