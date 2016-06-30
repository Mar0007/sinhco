<?php

    $Modulo = modulo($modulo ,$mysqli, "", "inicio",true);
    
    if(!$Modulo)
    {
        require_once($tema."404.tema.php");
        return;
    }
?>
<!DOCTYPE html>
<html lang="es_HN">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Sinhco</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo GetURL($tema."css/materialize.css")?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo GetURL($tema."css/styles.css")?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="<?php echo GetURL($tema."js/customscripts.js")?>"></script>
  <script src="<?php echo GetURL($tema."js/materialize.min.js")?>"></script>
    
</head>
<body>
    <header>
        <div class="navbar-fixed">
            <nav class="grey lighten-5">
                <div class="nav-wrapper">
                    <div class="">
                        <a href="<?php echo GetURL("inicio");?>" class="brand-logo light-blue-text text-accent-4"><img class="logo responsive-img" src="<?php echo GetURL("uploads/static/logo.png");?>"></a>
                        <a href="#" data-activates="mobile-demo" class="button-collapse light-blue-text text-accent-4"><i class="material-icons">menu</i></a>
                          <?php
                            echo menu($mysqli,3,"right boxline hide-on-med-and-down");
                            echo menu($mysqli,3,"side-nav","mobile-demo");                            
                          ?>                       
                    </div>
                </div>
            </nav>
        </div>        
    </header> 
    <section id="hero-slider">
          <?php
                $Slider = ShowSlider($mysqli,"",$modulo,"fullscreen");
                if($Slider != "")
                { 
                    echo '<div id="hero" style="position:relative; height:89vh;">'.
                            $Slider .
                         '</div>';
                } 
          ?>    
    </section>
    <main>
        <?php echo $Modulo ?>
    </main>
    
    <footer class="page-footer light-blue darken-4" style="margin-top:0px">
          <?php
                bloque('footer',$mysqli,"",'blqfooter');
          ?>
          <div class="footer-copyright">
            <div class="container">
                © 2014 Copyright Text
                <a class="grey-text text-lighten-4 right" href="#!">Our-Link</a>
            </div>
          </div>
    </footer>
            
    
</body> 
    <script>        
        $(document).ready(function()
        {           
            smoothScroll(); 
    
            $('.slider').slider({full_width: true, indicators:true});
            $(".button-collapse").sideNav(); 
            $('select').material_select();
			$('.modal-trigger').leanModal();
            $('.parallax').parallax();
            $('.dropdown-button').dropdown({
                  inDuration: 300,
                  outDuration: 225,
                  constrain_width: false, // Does not change width of dropdown to that of the activator
                  hover: false, // Activate on hover
                  gutter: 0, // Spacing from edge
                  belowOrigin: true, // Displays dropdown below the button
                  alignment: 'left' // Displays dropdown with edge aligned to the left of button
                }
              );            
        });
        
    </script>    
</html>