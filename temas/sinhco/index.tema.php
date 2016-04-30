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
  <script src="<?php echo GetURL($tema."js/materialize.min.js")?>"></script>
    
</head>
<body>
    <header>
        <div class="navbar-fixed">
            <nav class="grey lighten-5">
                <div class="nav-wrapper">
                    <div class="">
                        <a href="index.html" class="brand-logo light-blue-text text-accent-4"><img class="logo responsive-img" src="<?php echo GetURL("uploads/static/logo.png");?>"></a>
                        <a href="#" data-activates="mobile-demo" class="button-collapse light-blue-text text-accent-4"><i class="material-icons">menu</i></a>
                        <ul class="right hide-on-med-and-down">
                            <li><a href="proyectos">Proyectos</a></li>
                            <li><a class='dropdown-button' data-activates='drop-products' href="products.html">Productos</a></li>
                            <li><a href="servicios.html">Servicios</a></li>
                            <li><a href="about.html">Acerca de</a></li>
                            <li><a href="contactanos.html">Contáctanos</a></li>
                        </ul>
                        <!-- Dropdown Products -->
                          <ul id='drop-products' class='dropdown-content'>
                            <li><a href="products.html">Rotoplas</a></li>
                            <li><a href="products.html">Norweco</a></li>                            
                            <li><a href="products.html">Fill-Rite</a></li>
                          </ul>
                        
                        <ul class="side-nav" id="mobile-demo">
                            <li><a href="index.html">Inicio</a></li>
                            <li><a href="proyectos.html">Proyectos</a></li>
                            <li class="no-padding">
                                <ul class="collapsible collapsible-accordion">
                                  <li>
                                    <a class="collapsible-header">Productos<i class="right mdi-navigation-arrow-drop-down"></i></a>
                                    <div class="collapsible-body">
                                      <ul>
                                        <li><a href="products.html">Rotoplas</a></li>
                                        <li><a href="products.html">Norweco</a></li>
                                        <li><a href="products.html">Fill-Rite</a></li>                                                                          <li class="divider"></li>
                                      </ul>
                                    </div>
                                  </li>
                                </ul>
                            </li>
                            <li><a href="servicios.html">Servicios</a></li>                            
                            <li><a href="about.html">Acerca de</a></li>                            
                            <li><a href="contactanos.html">Contáctanos</a></li>
                        </ul>
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
                    echo '
                        <div id="hero" style="position:relative; height:89vh;">'.
                        $Slider.
                        '</div>';
                } 
          ?>
    <!--/div-->    
    </section>
    <main>
        <?php modulo($modulo ,$mysqli, "", "inicio"); ?>
    </main>
    
    <footer class="page-footer light-blue darken-4" style="margin-top:0px">
          <div class="container center">
              <div class="row">
                  <a href="index.html" class=""><img class="logo-footer responsive-img" src="<?php echo GetURL("uploads/static/sinhco-white.png");?>"></a>
                  <p class="grey-text text-lighten-4">Brindando soluciones reales y prácticas.</p>
                  
                  <a class="grey-text text-lighten-4" href="#!">
                      <img class="responsive-img" src="<?php echo GetURL("uploads/static/facebook.png");?>">
                  </a>
                  <a class="grey-text text-lighten-4" href="#!">
                      <img class="responsive-img" src="<?php echo GetURL("uploads/static/twitter.png");?>">
                  </a>
                  <a class="grey-text text-lighten-4" href="#!">
                      <img class="responsive-img" src="<?php echo GetURL("uploads/static/instagram.png");?>">
                  </a>
                    
              </div>              
          </div>
          <div class="footer-copyright">
            <div class="container">
                © 2014 Copyright Text
                <a class="grey-text text-lighten-4 right" href="#!">Our-Link</a>
            </div>
          </div>
    </footer>
            
    
</body> 
    <script>
        
        $(document).ready(function(){
            
            $('.slider').slider({full_width: true, indicators:true});
            $(".button-collapse").sideNav();            
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
    <style>
        @media only screen and (min-width: 992px) {
            .modal.bottom-sheet{
                width:80%;
                margin:0 auto;
                height: 55%
            }
        }
        .logo {
                max-height: 44px;
                margin-top: 10px;
                margin-left: 5%;
        }
        .logo-footer {
                max-height: 44px;
                margin-top: 10px;                
        }
        .slider.fullscreen{
            height: 89%;
        }
        .slider .indicators .indicator-item.active{
            background-color: #90caf9;
        }
        #hero-img {
            position: relative;
            height: 100vh;
        }
        .hero-bg{
            background-image: url("../recursos/img/slide2.jpg");
            background-size: cover;
            background-position: center no-repeat;
            max-height: 89vh;
        }
        #proyect-img {
            position: relative;
            height: 100vh;
        }
        .modal{
            width:85%;            
        }
        .modal.bottom-sheet{
            max-height: 70%;            
        }
        .modal .description{
            padding: 24px;
        }        
        .float-btn{
            bottom:-28px; 
            z-index:2; 
            position:absolute
        }
        
        .indigo-bg{
            background-color: #e8eaf6;
        }
        .blue-darken-bg{
            background-color: #01579b;
            color: white
        }
        .floating-btn{
            position: absolute;
            bottom: -28px;
            right:32px;
            z-index: 2;
        }
        .fab-btn{
            position: absolute;
            right:10%;
        }
        .banner-fab{
            position:absolute;
            right:80px;            
            z-index: 2;
        }
        .card-floating-btn{
            position: absolute;
            bottom: -12px;
            right:12px;
            z-index: 2;
        }
        .card-fab-btn{
            position: absolute;
            right:2%;
        }
        
        .no-mar-bot{
            margin-bottom: 0;
        }
        .tabs .indicator{
            background-color: #1e88e5;
        }
        .tabs{
            background-color: #e8eaf6;
        }
        .tabs .tab a{
            color:#1e88e5;
        }
        .tabs .tab a:hover{
            color: #90caf9;
        }
        .banner{
            background-color: #01579b;
            color:white;
        }
        .banner-pad{
            padding-bottom: 80px;
            padding-top: 80px
        }
        .banner-pad-bot{
            padding-bottom: 2rem;
        }        
        nav ul a{
            color:#455a64;
            font-weight: 400;
            text-transform: uppercase;
            
        }
        nav ul li a:hover, nav ul a.active{
            color: #01579b;
            background-color: transparent;
            font-weight: 500;
        }
        nav ul li.active{
            background-color: transparent;
            color: #01579b;
        }
        .fix-icon{
            position: relative;
            top:7px
        }        
        .dropdown-content li a{
            color:#039be5;
        }
        
        .brand-list{
            list-style-type: none
        }
        .brand-list li{
            margin-bottom: 30px;
            text-align: center;
        }
        .brand-list li img{
            margin: 0 auto;
            max-height: 80px;
            max-width: 160px;
        }
        
        .overlay {            
            background:transparent; 
            position:relative; 
            width:100%;
            height:620px; 
            top:620px; 
            margin-top:-620px;  
        }
        </style>
</html>