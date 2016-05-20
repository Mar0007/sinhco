<?php
	global $mysqli;
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1)
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}	
    
?>
<body>
   
    <section id="hero-slider">
        
        <div class="section banner banner-pad-bot z-depth-1">
            <div class="container">
                <h1 class="no-mar-bot thin">Productos</h1>
                <h5 class="medium">Marcas reconocidas y de alta calidad.</h5>
            </div>
            <a href="#categories" class=" smoothScroll fab-btn right banner-fab hide-on-med-and-down btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                    <span><i class="material-icons">expand_more</i></span>
                </a>
        </div>
    </section>
    <main>
    <div class="row indigo-bg">
       <div class="container">
           <div id="categories" class=" section">
               <div style="height:30px"></div>
            <div class="col s12">
                <div class="row"> <!-- SECTION TITLE -->
                    <h2 class="light center blue-grey-text text-darken-2">Rotoplas</h2>                
                </div>
                
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#test1">Almacenamiento</a></li>
                    <li class="tab col s3"><a href="#test2">Conducción</a></li>
                    <li class="tab col s3"><a href="#test3">Filtro  y Purificación</a></li>
                    <li class="tab col s3"><a href="#test4">Mantenimiento</a></li>
                </ul> 
                              
            </div>
          </div>           
       </div>
    </div>
        <div class="">
                    <div id="test1" class="col s12">
                       <div class="row"> 
                           <div class="container">
                        <ul id="">
                        <?php
                            $stmt = $mysqli->select("productos",
                            [
                                "productos.idproducto",                    
                                "productos.nombre",
                                "productos.descripcion",
                                "productos.idcategoria",
                                "productos.idproveedor"
                            ],[
                                "ORDER" => "productos.idproducto DESC",
                                "LIMIT"=> 4
                            ]);
                            
                            if(!$stmt)
                            {
                                if($mysqli->error()[2] != "")
                                    echo "Error:".$mysqli->error()[2];

                                return;
                            }

                            foreach($stmt as $row){
                                $content=substr(strip_tags($row["descripcion"]), 0, 150) . "...";
                                echo 
                                '
                                    <li id="'.$row["idproducto"].'" class="dataproductos col s12 m6 l6">
                                        <div class="card medium z-depth-1 ">
                                            <div class="card-image waves-effect waves-block waves-light" style="object-fit:cover">
                                                <img class="responsive-img"  src="'.GetProductImagePath($row["idproducto"], false).'">      
                                                
                                            </div>
                                            <div class="card-content">
                                                
                                                <span class="card-title activator">'.$row["nombre"].'<i class="material-icons right">more_vert</i></span>
                                            </div>
                                            <div class="card-reveal">
                                                <span class="card-title">'.$row["nombre"].'<i class="material-icons right">close</i></span>                            
                                                <p class="flow-text">'.$content.'</p>
                                                 <div class="card-action">
                                              <a href="proyectview/'.$row["idproducto"].'">VER producto</a>
                                            </div>
                                            </div>
                                           
                                        </div>           
                                    </li>
                                ';
                            }
                        ?>
                        
                        
                    </ul>
                    </div>
                   </div> 
                    </div>
                    <div id="test2" class="col s12">
                    
                </div>
                    <div id="test3" class="col s12">
                   
                </div>
                    <div id="test4" class="col s12">
                    
                </div>
         </div>
        
    </main>
    
   
            
    
</body> 
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
        // We increase the value by 2 because we limit the results by 2
        document.getElementById("result_no").value = Number(val)+6;
      }
      });
    }
     
    </script>
    
</html>