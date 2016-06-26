<?php
	global $mysqli;
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1)
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}


    $Categorias = $mysqli->select("tipo_servicio",
    [
        "idtiposervicio","nombre","descripcion"
    ]);
    
    	
/*
 //Frontend
*/
?>
<section id="hero-slider">        
        <div class="section banner banner-pad-bot z-depth-1">
            <div class="container">
                <h1 class="no-mar-bot thin">Servicios</h1>
                <h5 class="medium">Nos especializamos en diferentes áreas.</h5>
            </div>
            <a href="#services" class="smoothScroll fab-btn right banner-fab hide-on-med-and-down btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
                    <span><i class="material-icons">expand_more</i></span>
                </a>
        </div>
</section>

       
<div class="section indigo-bg"><!-- FOR CONTAINER end -->
    <div class="row"> <!-- SECTION TITLE -->
        <h2 class="light center blue-grey-text text-darken-3">Nuestros servicios</h2>                
    </div>

<div id="services" class="indigo-bg section"></div>
<div class="row container"> <!-- SECTION CONTENT -->
    <?php
        foreach ($Categorias as $row) 
        {
            echo
            '
                <div id="SCard_'.$row["idtiposervicio"].'" class="col s12 m6" data-id="'.$row["idtiposervicio"].'">
                    <div class="card medium">
                        <div class="card-image">
                            <img src="'.GetServiceImagePath($row["idtiposervicio"]).'">
                        </div>
                        <a OnClick="OpenModal('.$row["idtiposervicio"].')" class="card-fab-btn btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" style="margin-top:-30px">
                            <span><i class="material-icons">navigate_next</i></span>
                        </a>                        
                        <div class="card-content" style="margin-top:-15px;max-height:42%">
                            <a><span class="card-title truncate">'.$row["nombre"].'</span></a>               
                            <p class="medium grey-text">'.$row["descripcion"].'</p>
                        </div>
                    </div>                        
                </div>            
            ';
        }
    ?>
</div> <!-- FOR CONTAINER end --> 

<!-- Modal Structure -->
<div id="modalservice" class="modal bottom-sheet">
    <div class="modal-content">
        <span><i class="modal-action modal-close material-icons right">close</i></span>
        <h4 id="modalTitle"></h4>
        <div id="datacontainer">
        </div>        
    </div>
    <div class="modal-footer"></div>
</div>

<script>
var ajax_request;
function OpenModal(id)
{
    if(!id) return;

    //Prevent parallel execution of ajax.
    if(ajax_request) ajax_request.abort();

    //Exec ajax
    ajax_request = $.post("<?php echo GetURL("modulos/modservicios/serviceservicios.php?accion=1")?>",
                        {idcat:id},null,"json");
    
    //Update modal title
    $("#modalTitle").text($("#SCard_"+id).find(".card-title").text());

    //Open modal and show loading animation
    $("#datacontainer").html(HTMLLoader);
    $("#modalservice").openModal();
    
    ajax_request.done
    (
        function(data)
        {
            if(data["status"] == 200)
            {
                //Clear animation and load data.
                $("#datacontainer").empty();                                
                data["data"].forEach(function(item,index)
                {
                    $("<p>",
					{
						"class":"grey-text flow-text",                    
                         text: item["servicio"]
					}).appendTo("#datacontainer");
                });                
            }
        }
    );
    
    ajax_request.fail(function(AjaxObject){
        Materialize.toast('Error al cargar los servicios', 3000,"red");
        console.error("ErrorJSON->Servicios->OpenModal("+id+"): " + AjaxObject.responseText);
    });                                     
    
}
</script>