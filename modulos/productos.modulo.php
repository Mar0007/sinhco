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
                    <div class="row"> 
                        <h2 class="light center blue-grey-text text-darken-2">Rotoplas</h2>                
                    </div>
                
                <ul class="tabs">
                    <li onclick="llenar(1)" class="tab col s3"><a class="active" href="#test1">Almacenamiento</a></li>
                    <li onclick="llenar(2)" class="tab col s3"><a href="#test2">Quimicos</a></li>
                    <li onclick="llenar(3)" class="tab col s3"><a href="#test3">Biodigestores</a></li>
                    <li onclick="llenar(4)" class="tab col s3"><a href="#test4">Fosas Septicas</a></li>
                </ul> 
                              
            </div>
          </div>           
       </div>
    </div>
        <div class="">
            <div id="test1" class="col s12" >
                <div class="row"> 
                    <div class="container">
                        <ul id="1" >
                        </ul>
                    </div>
                </div> 
            </div>
            <div id="test2" class="col s12" >
                <div class="row"> 
                    <div class="container">
                        <ul id="2"> 
                        </ul>
                    </div>
                </div>
                
            </div>
            <div id="test3" class="col s12">
                
                <div class="row"> 
                    <div class="container">
                        <ul id="3">   
                        </ul>
                    </div>
                </div>
            </div>
            
            <div id="test4" class="col s12">
                    <div class="row"> 
                    <div class="container">
                        <ul id="4">  
                        </ul>
                    </div>
                </div> 
            </div>
        </div>
        
    </main>
    
   
            
    
</body> 
    <script>
       
        
        $(function() {  
//            $(".tabs").tabs("select_tab","test1");
            $(".tab").first().trigger("click");
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
    
   
    
    function llenar(a){
        var Categoria;
        var Proveedor;
        var cells = $("#categories").children();
        Proveedor = cells[1].children[0].children[0].innerHTML ;
        var cells2 = $(".tabs").children();
        Categoria= cells2[a-1].children[0].innerHTML;

          $.ajax({
                url:"<?php echo GetURL("modulos/modproductos/serviceproductos.php?accion=1") ?>",
                method: 'POST',
                data:{Proveedor:Proveedor,Categoria:Categoria}
              }).done(function(data){
                   
                   $("#"+a).fadeOut(function(){
					
					    $(this).empty();
				        $("#"+a).prepend(data);	
						$(this).fadeIn();		
														
				});	                
                
                                      
              });
    }
     
    </script>
    
</html>