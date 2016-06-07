<?php
	global $mysqli;	
	global $OnDashboard;
	
	
		
	if( !URLParam(1) )
	{
		echo "producto no encontrado";
		return;
	}
	
	$idproductos = URLParam(1);	
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	
		
	//Get product info
	$stmt = $mysqli->select("productos",
		[
            "nombre","descripcion"
        ],
		[
            "idproducto" => $idproductos            
        ]
                            
	);
    

	if(!$stmt)
	{
		if($mysqli->error()[2] != "")
			echo "Error:".$mysqli->error()[2];
		
		return;
	}	
?>			


<main>
        <div id="background" class="indigo-bg section"></div>
       
        <div class="section indigo-bg"><!-- FOR CONTAINER end -->
            <div class="row container"> <!-- SECTION TITLE -->
                <h2 class="light center blue-grey-text text-darken-3"><?php echo $stmt[0]["nombre"] ?></h2>
                
                <p class="center flow-text"><?php echo $stmt[0]["descripcion"] ?></p>
            </div>
             <div class="container">
            <section id="hero-slider">
          <?php
                $Slider = ShowproductSlider($mysqli,$idproductos,"fullscreen");
                if($Slider != "")
                { 
                    echo '<div id="hero" style="position:relative; height:79vh; ">'.
                            $Slider .
                         '</div>';
                } 
          ?>    
    </section>
            </div>
            <div class="row container"> <!-- SECTION CONTENT -->
                <div class="col s12">
                    <ul id="project-list"></ul>
                </div>
            </div>
            
            <div class="section center-align">
                <p class="center flow-text">Ver todos los productos</p>
            <a href="../productos" class="btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect  waves-circle">
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