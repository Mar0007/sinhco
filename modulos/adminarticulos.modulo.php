<?php
	global $mysqli;
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1 || !login_check($mysqli))
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
	<h3>Administracion de Articulos</h3>			
	<div class="row">
		<div class="col s12">
			<table id="tblArticulos" class="highlight responsive-table centered">
				<thead>
					<tr>		
						<th>Codigo</th>
						<th>Titulo</th>
						<th>Fecha</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>					
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-action">
		<button id="btnCrearArticulo" class="btn waves-effect waves-light" onclick="location.href='index.php?mod=creararticulo';"><i class="material-icons left">library_add</i>Crear Articulo</button>
	</div>
</div>

<script>
	//Main
	$(document).ready(function(){						
		//Get data
		$.ajax({
			url:"modulos/modadminarticulos/serviceadminarticulos.php?accion=1"
		}).done(
			function(data){
				$("#tblArticulos tbody").append(data);
				$(".dataArticulos").fadeIn();
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
				url:"modulos/modadminarticulos/serviceadminarticulos.php?accion=4",
				method: "POST",
				data: {idarticulo:id}
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
