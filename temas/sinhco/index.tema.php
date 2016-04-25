<!DOCTYPE html>
<html lang="es_HN">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Sinhco</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo GetURL($tema."css/materialize.css")?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo GetURL($tema."css/style.css")?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="<?php echo GetURL($tema."js/materialize.min.js")?>"></script>
  <script src="<?php echo GetURL($tema."js/init.js")?>"></script>
    
</head>
<body>
    <header>
        <div class="navbar-fixed">
            <nav class="grey lighten-5">
                <div class="nav-wrapper">
                    <div class="">
                        <a href="index.html" class="brand-logo light-blue-text text-accent-4"><img class="logo responsive-img" src="../recursos/img/sinhco.png"></a>
                        <a href="#" data-activates="mobile-demo" class="button-collapse light-blue-text text-accent-4"><i class="material-icons">menu</i></a>
                        <ul class="right hide-on-med-and-down">
                            <li><a href="proyectos.html">Proyectos</a></li>
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
        <!--div id="hero" style="position:relative; height:100vh;"-->
            <!--div class="slider fullscreen">                
                <ul class="slides">
                    <li>
                        <img src="../recursos/img/proyecto1.jpg">            
                    </li>
                    <li>
                        <img src="../recursos/img/proyecto2.jpg">            
                    </li>
                    <li>
                        <img src="../recursos/img/slide3.jpg">            
                    </li>
                </ul>               
                <a href="#sinhco-intro" class="hide-on-med-and-down floating-btn fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                    <span><i class="material-icons">expand_more</i></span>
                </a>
          </div-->
          <?php
                $Slider = ShowSlider($mysqli,"",$modulo,"fullscreen");
                if($Slider != "")
                { 
                    echo '
                        <div id="hero" style="position:relative; height:100vh;">'.
                        $Slider.
                        '</div>';
                } 
          ?>
    <!--/div-->    
    </section>
    <main>
        <div id="sinhco-intro" class="section"></div>
        <div class="section"><!-- FOR CONTAINER end -->
            <div class="row"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-2">Sinhco</h2>
                <p class="center light">Especializados en el suministro e instalación de obras civiles, hidráulicas y eléctricas,incluyendo la comercialización de equipos.</p>
            </div>
            <div class="row">
                <div class="col s12 m4">
                  <div class="">
                    <h2 class="center light-blue-text text-accent-4"><i style="font-size:54px" class="material-icons">group</i></h2>
                    <h5 class="center">La Empresa</h5>

                    <p class="light">Conformada por profesionales de la ingeniería civil, industrial, mecánica, electrónica y eléctrica con más de 15 años de experiencia en cada rama, personal técnico y auxiliar calificado.</p>
                  </div>
                </div>        
                <div class="col s12 m4">
                    <div class="">
                        <h2 class="center light-blue-text text-accent-4"><i style="font-size:54px" class="material-icons">shopping_cart</i></h2>
                        <h5 class="center">Productos</h5>

                        <p class="light">Marcas reconocidas y de alta calidad, circunstancia que nos permite manejar un alto control de calidad y ofrecer a nuestros clientes garantías de funcionamiento e instalación.</p>
                      </div>
                </div>
                <div class="col s12 m4">
                  <div class="">
                    <h2 class="center light-blue-text text-accent-4"><i style="font-size:54px" class="material-icons">location_on</i></h2>
                    <h5 class="center">Visítanos</h5>
                    <p class="light">Nuestra sede está en San Pedro Sula, Cortes y atendemos en cualquier zona del país.</p>
                  </div>
                </div>
            </div>
        </div> <!-- FOR CONTAINER end -->
        
        <div class="parallax-container z-depth-1">
            <div class="section no-pad-bot">
                <div class="parallax"><img class="" src="../recursos/img/parallax.jpg"></div>
            </div>
        </div>
        
        <div id="products" class=""></div>
        <div class="section indigo-bg"> <!-- FOR CONTAINER -->
            <div class="row"> <!-- SECTION TITLE -->
                <h3 class="light center blue-grey-text text-darken-2">Nuestros productos</h3>
                <p class="center light">Conoce nuestra variedad de productos</p>
            </div>
            <div class="row"> <!-- SECTION CONTENT -->
                <div class="col s12 m4 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="../recursos/img/norweco.png">
                            <a href="products.html" class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                                <span><i class="material-icons">open_in_new</i></span>
                            </a>
                       </div>
                       <div class="card-content">
                           <h2 class="card-title">Norweco</h2>
                           <p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p>
                        </div>                       
				    </div>
				</div>
                <div class="col s12 m4 l4">
                    <div class="card">
                        <div class="card-image">
                            <img src="../recursos/img/rotoplas.png">
                            <a href="products.html" class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                                <span><i class="material-icons">open_in_new</i></span>
                            </a>
				        </div>
                        <div class="card-content">
                           <h2 class="card-title">Rotoplas</h2>
                           <p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p>
                        </div>                     
				    </div>
				</div>
                <div class="col s12 m4 l4">
                    <div class="card">
                        <div class="card-image">
                            <img  src="../recursos/img/fill-rite.png">
                            <a href="products.html" class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                                <span><i class="material-icons">open_in_new</i></span>
                            </a>                                
                        </div>                            
						<div class="card-content">
                           <h2 class="card-title">Fill-Rite</h2>
                           <p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p>
                        </div>                       
				    </div>				    
            </div>
            </div>
        </div><!-- FOR CONTAINER end -->

        <div class="section banner z-depth-1">
            <div class="container">
                <h1 class="no-mar-bot thin">Alto control de calidad</h1>
                <h5 class="medium">Contamos con el respaldo de los fabricantes de los equipos que suministramos.</h5>
				<!--<a href="products.html" class="light-blue-text text-accent-4 medium">VER TODOS LOS PRODUCTOS<span><i class="fix-icon center light-blue-text text-accent-4 material-icons">navigate_next</i></span></a>-->
            </div>
            <div class="section"></div>            
        </div>

        <div id="outro" class="section"></div>
        <div class="section"><!-- FOR CONTAINER end -->
            <div class="row"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-3">Confían en nosotros</h2>
                <p class="center light"></p>
            </div>
            <div class="row">
                <div class="col m12">
                    <ul class="row brand-list">
                        <li class="col s12 m6 l3">
                            <img src="../recursos/img/Gildan.png">
                        </li>
                        <li class="col s12 m6 l3">
                            <img src="../recursos/img/collective.jpg">
                        </li>
                        <li class="col s12 m6 l3">
                            <img src="../recursos/img/colonia.png">
                        </li>
                        <li class="col s12 m6 l3">
                            <img src="../recursos/img/antorcha.png">
                        </li>
                    </ul>             
                </div>
            </div> <!-- FOR CONTAINER end -->

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content no-padding">
                <div class="row">
                    <div id="product-img" class="col s12 m12 l5 no-padding">
                        <img class="responsive-img" src="../recursos/img/tanque.jpg">
                    </div>
                    <div class="col s12 m12 l7 description">
                        <span><i class="modal-action modal-close material-icons right">close</i></span>
                        <h4 class="">Tanques para Agua y Químicos</h4>
                        <h6 class="grey-text text-lighten-1">Almacenamiento</h6>
                        <p class="flow-text">Los tanques Rotoplas son ideales para el acopio de agua en granjas durante tiempos de sequía, así como para el almacenamiento de melazas, alimentos y más de 300 sustancias químicas tales como: ácidos, cloruros y fosfatos.</p>     
                        <div style="height:30px" class="section "></div>
                        <a  style="bottom: 45px; right: 24px;" class="right btn waves-effect wave-light light-blue accent-4">Ver producto</a>                          
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="page-footer light-blue darken-4" style="margin-top:0px">
          <div class="container center">
              <div class="row">
                  <a href="index.html" class=""><img class="logo-footer responsive-img" src="../recursos/img/sinhco-white.png"></a>
                  <p class="grey-text text-lighten-4">Brindando soluciones reales y prácticas.</p>
                  
                  <a class="grey-text text-lighten-4" href="#!">
                      <img class="responsive-img" src="../recursos/img/facebook.png">
                  </a>
                  <a class="grey-text text-lighten-4" href="#!">
                      <img class="responsive-img" src="../recursos/img/twitter.png">
                  </a>
                  <a class="grey-text text-lighten-4" href="#!">
                      <img class="responsive-img" src="../recursos/img/instagram.png">
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
            $('a[href^="#"]').click(function(e) {
                e.preventDefault();
                var target = this.hash, $target = $(target);
                $('html, body').stop().animate({
                    'scrollTop': $target.offset().top
                }, 900, 'swing', function() {
                    window.location.hash = target;
                });
            });
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