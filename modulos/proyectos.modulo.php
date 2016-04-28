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
        <div id="hero-img" class="hero-bg "></div>
        <div class="section banner banner-pad-bot z-depth-1">
            <div class="container">
                <h1 class="no-mar-bot thin">Proyectos</h1>
                <h5 class="medium">Brindando soluciones reales y prácticas.</h5>
            </div>
            <a href="#services" class="fab-btn right banner-fab hide-on-med-and-down btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                    <span><i class="material-icons">expand_more</i></span>
                </a>
        </div>
</section>

<main>
        <div id="services" class="indigo-bg section"></div>
        
        <div class="section indigo-bg"><!-- FOR CONTAINER end -->
            <div class="row"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-3">Proyectos recientes</h2>                
            </div>
            
            <div class="row container"> <!-- SECTION CONTENT -->
                <div class="col s12">
                    <ul id="project-list"></ul>
                </div>
            </div>
            
            <div class="section center-align">
            <a class="btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect  waves-circle">
                <span><i class="material-icons">add</i></span>
            </a>
        </div>
        </div>
    </main>

<script>
    $(document).ready(function(){
            $.ajax({
                url:"<?php echo GetURL("modulos/modproyectos/serviceproyectos.php?accion=1") ?>"
            }).done(
                function(data){
                    $("#project-list").append(data);		                
                    $(".dataproyectos").fadeIn();
                }
            );
        });
</script>