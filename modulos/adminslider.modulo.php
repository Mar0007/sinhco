<?php
	global $mysqli;
	global $OnDashboard;
	
	if($OnDashboard != 1 || !login_check($mysqli))
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}
		
?>


<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Sliders</h3>
            <p class="center light">Cree, edite y organice los sliders.</p>
		</div>										
        
        <!--Module Data-->
        <ul id="datacontainer"></ul>
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="btnCrear" class="btn-floating btn-large blue-grey darken-2 tooltipped"  onclick="OpenModal()" data-position="left" data-delay="50" data-tooltip="Crear slider">
                <i class="large material-icons">add</i>
            </a>
        </div>   
    </div>
</div> 


<script>
  $(document).ready(function() {			
	//Get Data via ajax
	GetAjaxData();				
  }); //END Main
  
  var ajax_request;
  function GetAjaxData()
  {
	//Prevent parallel execution of ajax.
	if(ajax_request) ajax_request.abort();
	//Clear
	$("#datacontainer").empty();
	//Get data
	ajax_request = $.ajax({
		url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=1") ?>"
	}).done(
		function(data){
			$("#datacontainer").append(data);
			InitDropdown();
			$(".dataitems").fadeIn();
			$('.materialboxed').materialbox();
		}
	);			  
  }
  
  function OpenModal(idEdit)
  {	
  }
   
  
  function Agregar()
  {		
					 
  }
  
  function Editar(id)
  {
  }
  
            
</script>