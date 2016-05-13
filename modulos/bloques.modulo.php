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

<div class="card-content">
	<h3>Administracion de Bloques</h3>
	<div class="row">
		<div class="col s12">	
			<table id="tblBloques" class="highlight responsive-table centered">
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
</div>
	<div class="card-action">
		<button id="btnCrearBloque" class="btn waves-effect waves-light" onclick="location.href='<?php echo GetURL("dashboard/crearbloque")?>';"><i class="material-icons left">library_add</i>Crear Bloque</button>
		<button id="btnSubirBloque" class="btn waves-effect waves-light" onclick="SubirBloque()"><i class="material-icons left">cloud_upload</i>Subir Bloque</button>
	</div>
	
<div id="frmModalAsignacion" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Asignacion de Bloques a modulos</h4>
		<div class="divider"></div>
		<div class="row center">
			<div class="col s6 l6">	
				<table id="ModulosDisponibles">
					<thead><tr><th>Modulos Disponibles</th><tr></thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="col s6 l6">
				<table id="ModulosAsignados">
					<thead><tr><th>Modulos Asignados</th><tr></thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">		
	<button id="btnCancelDialog" class="btn waves-effect waves-light red modal-action modal-close" name="action">Cancelar
		<i class="material-icons left">close</i>
	</button>
	<button id="btnSaveDialog" class="btn waves-effect waves-light green" style="margin-right:10px" name="action">Guardar
		<i class="material-icons left">save</i>
	</button>
	</div>
</div>



<script>
	//Main
	$(document).ready(function(){						
		//Get data
		$.ajax({
			url:"<?php echo GetURL("modulos/modbloques/servicebloques.php?accion=1")?>"
		}).done(
			function(data){
				$("#tblBloques tbody").append(data);
				$(".databloques").fadeIn();
				InitDropdown();
			}
		);		
	});
	
	//Functions		
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
				url:"<?php echo GetURL("modulos/modbloques/servicebloques.php?accion=4")?>",
				method: "POST",
				data: {idbloque:id}
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