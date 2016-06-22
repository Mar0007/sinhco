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
                <h1 class="no-mar-bot thin">Contáctanos</h1>
                <h5 class="medium">Estamos a tu disposición y nos encantaría poder atenderte.</h5>
            </div>
            <a href="#email-form" class="fab-btn right banner-fab hide-on-med-and-down btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                <span><i class="material-icons">expand_more</i></span>
            </a>
        </div>        
    </section>
    
    <main>
        <div id="email-form" class="section"></div>
        <div class="section"><!-- FOR CONTAINER end -->
            <div id="" class="row"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-2">Déjanos un mensaje</h2>
                <p class="center light">Llena el siguiente formulario de contacto para enviarnos un correo electrónico. Te responderemos en un plazo de 24 horas.</p>
            </div>
            <div class="row container section">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="first_name" type="text" class="validate">
                            <label for="first_name">Nombre</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Apellido</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="email" type="email" class="validate">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="company" type="text" class="validate">
                            <label for="company">Empresa</label>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="number" type="text" class="validate">
                            <label for="number">Teléfono</label>
                        </div>
                        <div class="input-field col s6">
                            <select>
                                <option value="" disabled selected>Escoge una categoría</option>
                                <option value="1">Cotización</option>
                                <option value="2">Servicio al cliente</option>
                                <option value="3">Quejas</option>
                            </select>
                            <label>Asunto</label>
                        </div>    
                  </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="textarea1" class="materialize-textarea"></textarea>
                            <label for="textarea1">Textarea</label>
                        </div>
                    </div>                    
                    <a href="#!" class="right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                        <span><i class="material-icons">send</i></span>
                    </a>        
                </form>
            </div>
        </div> <!-- FOR CONTAINER end -->
        
        <div class="parallax-container z-depth-1">
            <div class="section no-pad-bot">
                <div class="parallax"><img class="" src="../recursos/img/contact.jpg"></div>
            </div>
        </div>
        
        <div id="intro" class="section"></div>
        <div class="section"><!-- FOR CONTAINER end -->
            <div class="row"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-3">Más opciones</h2>
                <p class="center light">Obten más información acerca de cómo contactarnos para obtner información sobre nuestros servicios.</p>
            </div>
            <div class="row">
                <div class="col s12 m4">
                    <div class="">
                        <h2 class="center light-blue-text text-accent-4">
                            <i style="font-size:54px" class="material-icons">phone</i>
                        </h2>
                        <h5 class="center">Llámanos</h5>
                        <p class="light">Puedes comunicarte con nosotros de 09:00am a 4:00pm, de lunes a viernes. Llamando a los teléfonos:</p>
                        <div class="col s12 m12 l4">
                            <p class="light">(504) 2551-5555 </p>
                        </div>
                        <div class="col s12 m12 l4">
                            <p class="light">(504) 2566-0455 </p>  
                        </div>
                        <div class="col s12 m12 l4">
                            <p class="light">(504) 2566-0670 </p>      
                        </div>
                    </div>
                </div>        
                <div class="col s12 m4">
                    <div class="">
                        <h2 class="center light-blue-text text-accent-4">
                            <i style="font-size:54px" class="material-icons">location_on</i>
                        </h2>
                        <h5 class="center">Visítanos</h5>
                        <p class="light">Estamos ubicados en la Colonia Universidad 24 calle, entre 9 y 11 ave, # 3, San Pedro Sula, Honduras.</p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="">
                        <h2 class="center light-blue-text text-accent-4">
                            <i style="font-size:54px" class="material-icons">thumb_up</i>
                        </h2>
                        <h5 class="center">Facebook</h5>
                        <p class="light">Obten información inmediata en línea durante el horario laboral mencionado anteriormente.</p>
                        <p>
                            <a href="#!" class="light-blue-text text-accent-4 medium">Visita nuestro Facebook
                                <span>
                                    <i class="fix-icon center light-blue-text text-accent-4 material-icons">navigate_next</i>
                                </span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div> <!-- FOR CONTAINER end -->        
    </main>