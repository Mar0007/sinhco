<?php
	global $mysqli;	
	global $OnDashboard;
	
	
		
	if( !URLParam(1) )
	{
		echo "Proyecto no encontrado";
		return;
	}
	
	$idproyecto = URLParam(1);	
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	
		
	//Get proyect info
	$stmt = $mysqli->select("proyectos",
		[
            "nombre","lugar","contenido", "fecha"
        ],
		[
            "idproyecto" => $idproyecto            
        ]
                            
	);
    $date = strtotime($stmt[0]["fecha"]);

	if(!$stmt)
	{
		if($mysqli->error()[2] != "")
			echo "Error:".$mysqli->error()[2];
		
		return;
	}	
?>			
<section id="hero-slider">     
    <div id="hero-img" class="hero-bg " style="background-image:url(<?php echo GetProyectImagePath($idproyecto)?>)">
        
    </div>
        <div class="section banner banner-pad-bot z-depth-1">
            <div class="container">
                <h1 class="no-mar-bot thin"><?php echo $stmt[0]["nombre"] ?></h1>
                <h5 class="medium"><?php echo $stmt[0]["lugar"] ?></h5>
            </div>
            <a href="#background" class="smoothScroll fab-btn right banner-fab hide-on-med-and-down btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                    <span><i class="material-icons">expand_more</i></span>
                </a>
        </div>
</section>

<main>
        <div id="background" class="indigo-bg section"></div>
        
        <div class="section indigo-bg"><!-- FOR CONTAINER end -->
            <div class="row container"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-3">Breve reseña</h2>
                <p class="flow-text grey-text center"><?php echo date("F j, Y", $date) ?></p>
                <p class="center flow-text"><?php echo $stmt[0]["contenido"] ?></p>
            </div>
            
            <section id="hero-slider">
          <?php
                $Slider = ShowProyectSlider($mysqli,$idproyecto,"fullscreen");
                if($Slider != "")
                { 
                    echo '<div id="hero" style="position:relative; height:89vh;">'.
                            $Slider .
                         '</div>';
                } 
          ?>    
    </section>
            
            <div class="row container"> <!-- SECTION CONTENT -->
                <div class="col s12">
                    <ul id="project-list"></ul>
                </div>
            </div>
            
            <div class="section center-align">
            <a href="../proyectos" class="btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect  waves-circle">
                <span><i class="material-icons">arrow_back</i></span>
            </a>
        </div>
        </div>
    </main>

<script>
    $(function() {  
      $('.smoothScroll').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 800); 
            return false;
          }
        }
      });
    });
   
</script>