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
            <a href="#email-form" class="fab-btn smoothScroll right banner-fab hide-on-med-and-down btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                <span><i class="material-icons">expand_more</i></span>
            </a>
        </div>        
    </section>
    
    <main>
        <div id="email-form" class="section"></div>
        <div class="section"><!-- FOR CONTAINER end -->
            <div id="" class="row"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-2">Déjanos un mensaje</h2>
                <p class="center">Llena el siguiente formulario de contacto para enviarnos un correo electrónico. Te responderemos en un plazo de 24 horas.</p>
            </div>
            <div class="row container section">
                <form class="col s12" method="post" action="javascript:SendEmail()" autocomplete="on">
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="first_name" name="nombre" type="text" class="validate" required autocomplete="fname" autofocus>
                            <label for="first_name">Nombre</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" name="apellido" type="text" class="validate" required autocomplete="lname">
                            <label for="last_name">Apellido</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="email" name="email" type="email" class="validate" required autocomplete="email" title="Por favor ingresa un correo electrónico.">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="company" name="empresa" type="text" class="validate" required>
                            <label for="company">Empresa</label>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="number" name="telefono" type="tel" class="validate" required autocomplete="tel" pattern="\d*" maxlength="15" title="Por favor ingresa un número de teléfono.">
                            <label for="number">Teléfono</label>
                        </div>
                        <div class="input-field col s6">
                            <select id="subject" name="asunto" required>
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
                            <textarea id="message" maxlength="1500" length="1500" name="mensaje" class="materialize-textarea" required></textarea>
                            <label for="message">Mensaje</label>
                        </div>
                    </div>   
                    <input type="submit" style="display:none">
                    <a id="btnSend" onclick="$(this).parents().find(':submit').click();" class="right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                        <span><i class="material-icons">send</i></span>
                    </a>        
                </form>
            </div>
        </div> <!-- FOR CONTAINER end -->
        
        <div class="parallax-container z-depth-1">
            <div class="section no-pad-bot">
                <div class="parallax"><img class="" src="/recursos/recursos/img/contact.jpg"></div>
            </div>
        </div>
        
        <div id="intro" class="section"></div>
        <div class="section"><!-- FOR CONTAINER end -->
            <div class="row"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-3">Más opciones</h2>
                <p class="center">Comunícate con nosotros para obtner información sobre nuestros servicios.</p>
            </div>
            <div class="row">
                <div class="col s12 m4">
                    <div class="center">
                        <a  class="btn-floating btn-large nohover grey lighten-5 ">
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
                </div>        
                <div class="col s12 m4">
                    <div class="center ">
                        <a  class="btn-floating btn-large nohover grey lighten-5 ">
                            <span><i class="material-icons light-blue-text text-accent-4">email</i></span>
                        </a>                    
                        <h5 class="center grey-text text-darken-1">Déjanos un mensaje</h5>
                        <div class="container">
                            <p class="">sinhco.hn@gmail.com</p>
                            <p class="">gerencia@sinhco.com</p>
                            <p class="">proyectos@sinhco.com</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="center ">
                        <a  class="btn-floating btn-large nohover grey lighten-5 ">
                            <span><i class="material-icons light-blue-text text-accent-4">thumb_up</i></span>
                        </a>                    
                        <h5 class="center grey-text text-darken-1">Facebook</h5>
                        <div class="container">
                            <p class="">Obten información inmediata en línea durante el horario laboral mencionado anteriormente.</p>
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
            </div>
        </div> <!-- FOR CONTAINER end -->        
    </main>


<script>
var ajax_request;
    
    function SendEmail(){
        if($("#btnSend").hasClass("disabled"))
        return;        
    
        if(ajax_request) ajax_request.abort();

        var nombre = $("#first_name").val();
        var apellido = $("#last_name").val();
        var email = $("#email").val();
        var empresa = $("#company").val();
        var telefono = $("#number").val();
        var asunto = $("#subject").val();
        var mensaje = $("#message").val();
        

        $("#btnSend").addClass("disabled");
       /* $("#btnSend i").fadeOut(0,function(){
            $("#btnSend").append(SmallLoader);
        });*/

        ajax_request = $.ajax({
            url: "<?php echo GetURL("modulos/modcontactanos/servicecontactanos.php?accion=1")?>",
            method: "POST",
            dataType: "JSON",
            data: {nombre:nombre, apellido:apellido, email:email, empresa:empresa, telefono:telefono, asunto:asunto,mensaje:mensaje}
        });

        ajax_request.done(function(data)
        {                
            $("#btnSend").removeClass("disabled");
            /*$("#btnSend .preloader-wrapper").fadeOut(0,function()
            {
                $("#btnSend i").fadeIn();
                $(this).remove();
            });*/

            if(data["status"] == 200)
            {
                Materialize.toast('Correo enviado', 2000,"green",
                function()
                {
                    location.href="<?php echo GetURL("xinicio")?>";
                });
                return;
            }

            if(data["status"] == 172)
            {
                Materialize.toast('No se pudo enviar el correo', 3000,"red");
                console.error("Error->SendResetEmail(): "+data["error"]);
                return;
            }

            if(data["status"] == 404)
            {
                //Materialize.toast('No hay ningun usuario asociado a ese correo', 3000,"red");
                Materialize.toast('No se encontro ese correo', 3000,"red");
                return;            
            }

            if(data["status"] == 999)
            {
                Materialize.toast('Por favor espere '+data["left"]+"seg para volver a intentar", 3000,"red");
                return;
            }

            Materialize.toast('Error interno: No se pudo enviar el correo', 3000,"red");
            console.error("JSON-Error->SendResetEmail(): "+data);
        });	

        ajax_request.fail(function(AjaxObject)
        {
            $("#btnSend").removeClass("disabled");
            /*$("#btnSend .preloader-wrapper").fadeOut(0,function()
            {
                $("#btnSend i").fadeIn();
                $(this).remove();
            });    */    
            Materialize.toast('Error interno: No se pudo enviar el correo', 3000,"red");
            console.error("JSON-Error->SendResetEmail(): "+AjaxObject.responseText);
        });		        
    }
</script>