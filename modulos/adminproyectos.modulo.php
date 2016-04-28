<?php
	global $mysqli;
	global $OnDashboard;
	
	if($OnDashboard != 1 || !login_check($mysqli))
	{
		echo "<div class=\"row\">
                <div class=\"col s12 m12\">
                    <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                            <span class=\"card-title\">Warning!</span>
                                <p>Login in if you want to see this information. You have to be an administrator in order to make changes and/or visualize this information.</p>
                        </div>
                    <div class=\"card-action\">
                        <a class=\"modal-trigger\" href=\"#modal1\">Sign in</a>
                    </div>
                </div>
            </div>
        </div>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<div class=\"row\">
                <div class=\"col s12 m12\">
                    <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                            <span class=\"card-title\">Warning!</span>
                                <p>You need administration access to view this information.</p>
                        </div>
                    <div class=\"card-action\">
                        <a class=\"modal-trigger\" href=\"#\">Sign in</a>
                    </div>
                </div>
            </div>
        </div>";
		return;
	}    
    
?>
<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Proyectos</h3>
            <p class="center light">Cree, edite y organice los proyectos.</p>
            <div class="divider3"></div>
        </div>
        
        <!--Module Data-->
        <ul id="proyectostb" class="collection"></ul>
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="crearProyecto" href="crearproyecto" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Nuevo proyecto">
                <i class="large material-icons">mode_edit</i>
            </a>
            <!--<ul>
              <li>
                  <a id="crearArticulo" href="?mod=creararticulo" class="btn-floating green tooltipped" data-position="left" data-delay="50" data-tooltip="Nuevo proyecto">
                      <i class="material-icons">add</i>
                  </a>
              </li>
              <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
        </ul>
    </div>-->      
        </div>   
    </div>
</div>

    <!-- Confirm Delete Modal -->
    <div id="confirmar-eliminar" class="modal">
        <div class="modal-content">
            <h4>¿Eliminar proyecto?</h4>
            <p class="flow-text">Se eliminará el proyecto de la lista. Esta acción no se puede regresar. </p>
        </div>
        <div class="modal-footer">
            <button type="submit" value="SI" id="delete-yes"  class=" modal-action modal-close btn-flat waves-effect waves-light">eliminar</button>
            <button type="submit" value="NO" id="delete-no"  class=" modal-action modal-close btn-flat waves-effect waves-light">cancelar</button>
        </div>        
    </div>
    <!-- Confirm Delete Modal -->


<script>
    
    
    $(document).ready(function(){
        $.ajax({
			url:"<?php echo GetURL("modulos/modproyectos/serviceadminproyectos.php?accion=1") ?>"
		}).done(
			function(data){
				$("#proyectostb").append(data);				
				$(".dataproyectos").fadeIn();
			}
		);
    });
    function eliminar (idproyecto){              
        $("#confirmar-eliminar").openModal();
        $( "#delete-yes" ).click(function() {
                $.ajax({
				    url:"<?php echo GetURL("modulos/modproyectos/serviceadminproyectos.php?accion=4") ?>",
				    method: "POST",
				    data: {idproyecto:idproyecto}
			    }).done(
                        function(data){
                            if(data=="0"){
                                $("#"+idproyecto).fadeOut(function(){
                                    $(this).remove();
                                });
                                $("#confirmar-eliminar").closeModal();
                            }
                            else{
                                alert(data);
                            }
                        }
                    );
  
});
        $( "#delete-no" ).click(function() {
                 $("#confirmar-eliminar").closeModal();
        });
   
       
    }   
    
    
    
</script>