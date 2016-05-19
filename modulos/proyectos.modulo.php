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
                    <ul id="project-list">
                        <?php
                            $stmt = $mysqli->select("proyectos",
                            [
                                "proyectos.idproyecto",                    
                                "proyectos.nombre",
                                "proyectos.lugar",
                                "proyectos.contenido",
                                "proyectos.fecha"
                            ],[
                                "ORDER" => "proyectos.fecha DESC",
                                "LIMIT"=> 6
                            ]);
                            
                            if(!$stmt)
                            {
                                if($mysqli->error()[2] != "")
                                    echo "Error:".$mysqli->error()[2];

                                return;
                            }

                            foreach($stmt as $row){
                                $content=substr(strip_tags($row["contenido"]), 0, 100) . "...";
                                echo 
                                '
                                    <li id="'.$row["idproyecto"].'" class="dataproyectos col s12 m6 ">
                                        <div class="card medium hoverable">
                                            <div class="card-image waves-effect waves-block waves-light">
                                                <img class="responsive-img" src="'.GetProyectImagePath($row["idproyecto"], false).'">      
                                                <span class="card-title">'.$row["nombre"].'</span>
                                            </div>
                                            <div class="card-content">
                                                <p class="grey-text ">'.$row["lugar"].'</p>
                                                <p class="">'.$content.'</p>
                                            </div>
                                            <div class="card-action">
                                              <a href="proyectview/'.$row["idproyecto"].'">VER PROYECTO</a>
                                            </div>
                                        </div>           
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <input type="hidden" id="result_no" value="6">
            <div class="section center-align">
            <a id="loadMore" onclick="javascript:loadmore()" class="btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect  waves-circle">
                <span><i class="material-icons">add</i></span>
            </a>
        </div>
        </div>
    </main>

<script>
    
    $(document).ready(function(){
       
        /*$.ajax({
                url:"<?php echo GetURL("modulos/modproyectos/serviceproyectos.php?accion=1") ?>"
            }).done(
                function(data){
                    $("#project-list").append(data);		                
                    $(".dataproyectos").fadeIn();
                }
            );*/
        
        
        });
    function loadmore()
    {
      var val = document.getElementById("result_no").value;
      $.ajax({
      type: 'post',
      url: "<?php echo GetURL("modulos/modproyectos/serviceproyectos.php") ?>",
      data: {
        getresult:val
      },
      success: function (response) {
        var content = document.getElementById("project-list");
        content.innerHTML = content.innerHTML+response;
          if(!response){
              $("#loadMore").hide;
          }
        // We increase the value by 2 because we limit the results by 2
        document.getElementById("result_no").value = Number(val)+6;
      }
      });
    }
     
</script>