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

<!--div class="card-content">
	<h3>Administracion de Modulos</h3>			
	<div class="row">
		<div class="col s12">
			<table id="tblModulos" class="highlight responsive-table centered">
				<thead>
					<tr>		
						<th>Codigo</th>
						<th>Titulo</th>
						<th>Tipo</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-action">
		<button id="btnCrearModulo" class="btn waves-effect waves-light" onclick="location.href='<?php echo GetURL("dashboard/crearmodulo")?>';"><i class="material-icons left">library_add</i>Crear Modulo</button>
		<button id="btnSubirModulo" class="btn waves-effect waves-light" onclick="SubirModulo()"><i class="material-icons left">cloud_upload</i>Subir Modulo</button>
	</div>
</div-->


<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Modulos</h3>
            <p class="center light">Cree, edite y organice los modulos.</p>
            <div class="divider3"></div>
        </div>
        
        <!--Module Data-->
        <ul id="datacontainer" class="collection fixed-drop">
			
		</ul>
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="btnCrear" href="crearmodulo" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Crear Modulo">
                <i class="large material-icons">mode_edit</i>
            </a>
        </div>   
    </div>
</div>


<script>
	//Main
	$(document).ready(function(){						
		//Get data
		$.ajax({
			url:"<?php echo GetURL("modulos/modmodulos/servicemodulos.php?accion=1"); ?>"
		}).done(
			function(data){
				$("#datacontainer").append(data);
				InitDropdown();
				$(".dataitems").fadeIn();
			}
		);		
	});			
		
	function Eliminar(id)
	{		
		swal({
			title:  "¿Eliminar Registro: " + id + "?" ,
			text: "¿Desea eliminar el registro seleccionado?",
			type: "warning",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
			},
			function(){
			$.ajax({
				url:"<?php echo GetURL("modulos/modmodulos/servicemodulos.php?accion=4"); ?>",
				method: "POST",
				data: {idmodulo:id}
			}).done(function(data){
				if(data == "0")
				{
					$("#"+id).fadeOut(function(){
						$(this).remove();
					});
					swal("Borrado", "Se borro exitosamente.", "success");					
				}
				else
					swal("Error", data, "error");
			});				
		});				
	}
		
</script>