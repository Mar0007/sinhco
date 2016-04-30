<?php
	global $mysqli;
	//global $SEGURIDAD;
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
    $idusuario= "aa";
?>
<div class="container"> 
  <!--Module Data-->
  <div class="row ">
		<div id="productocard">
		</div>	
  </div>
  
  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="crearProyecto" href="crearproyecto" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Nuevo producto">
                <i class="large material-icons">mode_edit</i>
            </a>
  
</div>

<script>
 
 $(document).ready(function(){
      
        $.ajax({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=1") ?>"
		}).done(
			function(data){
				$("#productocard").append(data);
				
			}
		);
    }); 
  
</script>