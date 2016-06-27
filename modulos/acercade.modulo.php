<?php
	global $mysqli;
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1)
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}	
    
?>
<section id="hero-slider">        
        <div class="section banner banner-pad-bot z-depth-1">
            <div class="container">
                <h1 class="no-mar-bot thin">Acerca de Sinhco</h1>
                <h5 class="medium">Conoce un poco nuestra empresa</h5>
            </div>
            <a href="#sinhco-intro" class="smoothScroll fab-btn right banner-fab hide-on-med-and-down btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                    <span><i class="material-icons">expand_more</i></span>
                </a>
        </div>
</section>



<main>
        <div id="sinhco-intro" class="section"></div>
        
        <div class="section no-pad-bot">
            <div class="row ">
                <div class="row"> <!-- SECTION TITLE -->
                    <h2 class="light center blue-grey-text text-darken-3">Sinhco</h2>
                    <p class="center light">Servicios de Ingeniería Hidráulica y Construcción</p>
                </div>
                <div class="section"></div>
                <div class="container">
                    <div id="" class="center col s12 m6 l6">
                    <img style="height:200px; weight:200px;" class="" src="<?php echo GetURL("uploads/static/logo2.png");?>">
                </div>
                <div class="col s12 m6 l6">
                    <p class="medium ">Fundada en el año 2009 con la finalidad de ser una empresa de ingeniería especializada en el Suministro e Instalación de Obras Civiles e Hidráulicas incluyendo la comercialización de equipos de almacenamiento y distribución de agua. Es una empresa consolidada que se dedicada a servicios de ingeniería hidráulica, mecánica y civil,ofreciendo calidad basada en tecnología de punta y con el respaldo de personal capacitado y comprometido.</p>
                    <p class="medium">SINHCO también se centra en PRÁCTICA DE LOS VALORES de la empresa, que han sido hasta el momento los pilares fundamentales de la calidad de los servicios que prestan a todos sus clientes.</p>
                    <h2 class="center-align light">
                        <a href="#mision-vision" class="light waves-effect waves-light grey-text text-darken-2">
                            <i style="font-size:54px" class="light material-icons center-align">expand_more</i>
                        </a>
                    </h2>
                </div>
                </div>
            </div>
            
            <div class="parallax-container">
                <div class="section no-pad-bot">
                    <div class="parallax"><img class="" src="/recursos/recursos/img/team.jpg"></div>
                </div>
            </div>    
            
            <div id="mision-vision" class="row banner-pad indigo-bg no-mar-bot">
                <div class="col s12 m6">
                    <div class="center">
                        <a  class="btn-floating btn-large grey lighten-5 ">
                            <span><i class="material-icons light-blue-text text-accent-4">my_location</i></span>
                        </a>
                        <h5 class="center grey-text text-darken-1">Misión</h5>
                        <div class="container">
                            <p class="">Ser la empresa líder ofreciendo productos de ingeniería a nuestros clientes con el mejor servicio profesional satisfaciendo sus necesidades y superando sus expectativas.</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="center">
                        <a  class="btn-floating btn-large grey lighten-5 ">
                            <span><i class="material-icons light-blue-text text-accent-4">visibility</i></span>
                        </a>
                        <h5 class="center grey-text text-darken-1">Visión</h5>
                        <div class="container">
                            <p class="">Consolidarnos como la mejor empresa en ofrecer soluciones de obras civiles, mecánicas e hidráulicas teniendo siempre como base la satisfacción de nuestros clientes a través del mejoramiento continuo.</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 description" style="height:15vh"></div>
                <div class="col s12 m6">
                    <div class="center">
                        <a  class="btn-floating btn-large grey lighten-5 ">
                            <span><i class="material-icons light-blue-text text-accent-4">work</i></span>
                        </a>
                        <h5 class="center grey-text text-darken-1">Valores</h5>
                        <div class="container">
                            <p class="">Nos centramos en la prática de los valores de la empresa, que han sido hasta el momento los pilares fundamentales de la calidad de los servicios que prestamos a nuestros clientes.</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="center">
                        <a  class="btn-floating btn-large grey lighten-5 ">
                            <span><i class="material-icons light-blue-text text-accent-4">trending_up</i></span>
                        </a>
                        <h5 class="center grey-text text-darken-1">Política de calidad</h5>
                        <div class="container">
                            <p class="">Nos fundamentamos en los códigos y normas nacionales e internacionales de construcción.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- FOR CONTAINER end -->
        
            
        <div class="section banner z-depth-1">
            <div class="container">
                <h1 class="no-mar-bot thin">Nuestra ubicación</h1>
                <h5 class="medium">Estamos ubicados en la capital industrial del país.</h5>
                <!--<a href="products.html" class="light-blue-text text-accent-4 medium">VER TODOS LOS PRODUCTOS<span><i class="fix-icon center light-blue-text text-accent-4 material-icons">navigate_next</i></span></a>-->
            </div>
            <div class="section"></div>            
        </div>
        
        
        
        <div class="row no-mar-bot" >
            <div class="col s12 m6 overlay" onClick="style.pointerEvents='none'"></div>
            <iframe class="col s12 " src="https://www.google.com/maps/embed?pb=!1m21!1m12!1m3!1d808.1360470850257!2d-88.02854280558509!3d15.529307168419324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m6!3e0!4m0!4m3!3m2!1d15.5294691!2d-88.0278752!5e0!3m2!1ses-419!2shn!4v1459358314568" width="100%" height="540" frameborder="0" style="border:2" allowfullscreen></iframe>
        </div>
        <div class="row no-mar-bot banner-pad">
            <div class="center col s12 m6">
                  <div class="center ">
                      <a  class="btn-floating btn-large grey lighten-5 ">
                            <span><i class="material-icons light-blue-text text-accent-4">location_on</i></span>
                        </a>
                    
                    <h5 class="center grey-text text-darken-1">Visítanos</h5>
                    <div class="container">
                        <p class="">Nuestra sede está en la Colonia Universidad 24 calle, entre 9 y 11 ave, # 3, San Pedro Sula, Cortes y atendemos en cualquier zona del país.</p>
                      </div>
                  </div>
            </div>
            <div class="center col s12 m6 banner-pad ">
                      <div class="">
                          <a  class="btn-floating btn-large grey lighten-5 ">
                              <span><i class="material-icons light-blue-text text-accent-4">phone</i></span>
                          </a>
                            <h5 class="grey-text text-darken-1">Llámanos</h5>
                            <div class="container">
                                <p class="">Puedes comunicarte con nosotros de 09:00am a 4:00pm, de lunes a viernes. Llamando a los teléfonos:</p>
                        <div class="col s12 m12 l4">
                            <p class="">(504) 2551-5555 </p>
                        </div>
                        <div class="col s12 m12 l4">
                            <p class="">(504) 2566-0455 </p>  
                        </div>
                        <div class="col s12 m12 l4">
                            <p class="">(504) 2566-0670 </p>      
                        </div>
                          </div>
                      </div>
            
               <!-- </div> 
                    <div class="col s12 m6 ">
                      <div class="">
                            <h2 class="center light-blue-text text-accent-4"><i style="font-size:54px" class="material-icons">email</i></h2>
                            <h5 class="center">Email</h5>
                            <p class="flow-text center light">Déjanos un mensaje.</p>
                            <p class="center light">sinhco.hn@gmail.com</p>
                            <p class="center light">gerencia@sinhco.com</p>  
                            <p class="center light">proyectos@sinhco.com</p>                            
                      </div>
                </div> -->
            </div>            
        </div>
    </main>