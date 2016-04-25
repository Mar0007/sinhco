<?php
	global $modulo;
	global $mysqli;
	global $tema;
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="es_HN" http-equiv="Content-Language">
    <meta name="Author" content="Mar">
    <meta name="Designer" content="">
    <meta name="Date" content="">

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
        $(document).ready(function() {
            $(".button-collapse").sideNav();
            swal.setDefaults({ html: 'true' });
            $('#adminnav').sideNav({
                menuWidth: 240,
                edge: 'right',
                closeOnClick: true
            });
            $('.slider').slider();            						            
        });
        
        function InitDropdown()
        {
            $('.dropdown-button').dropdown({
                inDuration: 100,
                outDuration: 100,
                constrain_width: false,
                gutter: 0,
                belowOrigin: false,
                alignment: 'left'
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
        
        function LoginFrm()
        {
             $('.button-collapse').sideNav('hide');
             $('#LoginModal').closeModal({
                 complete: function(){
                     $('#LoginModal').openModal();
                 }
             });             
        }  
    </script>
</head>
<body>
    <!-- NavBar -->
    <nav>
        <div class="nav-wrapper">
            <a href="index.php" class="brand-logo"><i class="material-icons left">cloud</i>Blog</a>
            <a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>
            <?php
                echo menu($mysqli, 1, "right hide-on-med-and-down");
                echo menu($mysqli, 1, "side-nav", "mobile-menu");                
                echo menu($mysqli, 2, "side-nav", "admin-slideout","<li class=\"black-text\"><i class=\"material-icons left\">view_module</i>Modulos Administrador</li>");
                echo "<a style=\"display:none\" id=\"adminnav\" data-activates=\"admin-slideout\" class=\"button-collapse2\"></a>";
            ?>            
        </div>
    </nav>        
    <div id="LoginModal" class="modal" >
        <div class="modal-content">
            <?php bloque('login',$mysqli,"bloque","")?>
        </div>
    </div>    
            
    <div class="container" style="width:85%">                                
        <?php 
            $SliderHTML = ShowSlider($mysqli,1,$modulo);
            if($SliderHTML != "")
                echo $SliderHTML;
        ?>        
        <!-- Main Row -->
        <div class="row">        
            <!-- Left Column -->
            <div class="col s12 m12 l8">
                
                <?php
                    modulo($modulo ,$mysqli, "card", "inicio");
                ?>
            </div>
            <!-- END Left Column -->        
        </div> <!-- END Main row -->
    </div>
</body>
<footer class="page-footer">
  <div class="footer-copyright">
    <div class="container">
    © 2015 Copyright Negocios Web, Mario Nuñez
    <a class="grey-text text-lighten-4 right" href="#!">Mas Links</a>
    </div>
  </div>
</footer>
</html>