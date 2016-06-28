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
                        <h2 class="light center blue-grey-text text-darken-2">Norweco</h2>                
                    </div>
                
                <ul class="tabs" style="overflow: hidden">
                    <li onclick="llenar(1)" class="tab col s3"><a class="active" href="#test1">Dosificadores</a></li>
                    <li onclick="llenar(2)" class="tab col s3"><a href="#test2">Pastillas Hipoclorito</a></li>
                </ul> 
                       
            </div>
          </div>           
       </div>
    </div>
        <div class="">
            <div id="test1" class=" col s12"  >
                <div class="row"> 
                    <div class="container">
                        <ul id="1" >
                        </ul>
                    </div>
                </div> 
            </div>
            <div id="test2" class=" col s12" " >
                <div class="row"> 
                    <div class="container">
                        <ul id="2"> 
                        </ul>
                    </div>
                </div>   
            </div>
            <input type="hidden" id="result_no" value="4">
            <div id="pulldata" class="section center-align">
            <a id="loadMore" onclick="javascript:loadmore()" class="btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect  waves-circle">
                <span><i class="material-icons">add</i></span>                
            </a>
        </div>
            
        </div>
        
    </main>
    
   
            
    
</body> 
    <script>
    
        $(function() {  
            // $('#test1').attr('style', "height:440px");
           

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
         $("#pulldata").html('<a id="loadMore" onclick="javascript:loadmore()" class="btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect  waves-circle"><span><i class="material-icons">add</i></span></a>');
         $('#test'+a).attr('style', "height:740px");
        var Categoria;
        var Proveedor;
        var cells = $("#categories").children();
        Proveedor = cells[1].children[0].children[0].innerHTML ;
        var cells2 = $(".tabs").children();
        Categoria = cells2[a-1].children[0].innerHTML;

          $.ajax({
                url:"<?php echo GetURL("modulos/modproductos/serviceproductos.php?accion=2") ?>",
                method: 'POST',
                data:{Proveedor:Proveedor,Categoria:Categoria}
              }).done(function(data){
                   if (data) {
                        
                        $("#"+a).fadeOut(function(){
                            $('#test'+a).removeAttr('style');
                            $(this).empty();
                            $("#"+a).prepend(data);	
                            $(this).fadeIn();		
                                                            
				        });
                   }
                   else {
                      // alert("no productos");
                       $('#test'+a).attr('style', "height:540px");
                       $("#test"+a+" ul").html("<div style=\"padding-top:20%\" class=\"center grey-text\">No hay productos de esta categoria</div>");
                       $("#loadMore").hide();
                    
                   }
                       
              });
    }
    function loadmore()
    {
        
        var Categoria;
        var Proveedor;
        var cells = $("#categories").children();
        Proveedor = cells[1].children[0].children[0].innerHTML ;
        var cells2 = $(".tabs").children();
        Categoria= cells2[0].children[0].innerHTML;
      var val = document.getElementById("result_no").value;
      $.ajax({
      type: 'post',
      url: "<?php echo GetURL("modulos/modproductos/serviceproductos.php?accion=3") ?>",
      data: {getresult:val,Proveedor:Proveedor,Categoria:Categoria},
      success: function (response) {
        var content = document.getElementById("1");   
          if(response == "")
              {
                $("#loadMore").hide();
                  $("#pulldata").append('<div class="DataEmpty center"><div class="center grey-text">Parece que has llegado al final.</div></div>');
                        return;
              }          
        content.innerHTML = content.innerHTML+response;          
        // We increase the value by 2 because we limit the results by 2
        document.getElementById("result_no").value = Number(val)+6;
      }
      });
    }
     
    </script>
    
</html>