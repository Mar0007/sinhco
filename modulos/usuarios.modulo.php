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
	<h3>Manejo de Usuarios</h3>			
	<div class="row">
		<div class="col s12">
			<table id="usuarios" class="highlight responsive-table centered">
				<thead>
					<tr>		
						<th>Usuario</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Activo</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-action">
		<button id="btnagregar" class="btn waves-effect waves-light" onclick="OpenModal()">Agregar Usuario</button>
	</div>
</div>

<div id="modalFrmAdd" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Agregar Usuario</h4>
		<div class="divider"></div>
		<form id="frmagregar" action="javascript:Agregar()">
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="idusuario" type="text" class="validate" maxlength="20" required>
			<label for="idusuario">Usuario</label>
			</div>		
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">perm_identity</i>
			<input id="nombre" type="text" class="validate" required>
			<label for="nombre">Nombre</label>
			</div>		
			<div class="input-field col s12 m6 l6">
			<i class="material-icons prefix">email</i>
			<input id="email" type="email" class="validate" required>
			<label for="email">Email</label>
			</div>		
													
			<div class="input-field col s12 m6 l6">
			<i class="material-icons prefix">lock</i>
			<input id="txtpassword" type="password" class="validate" required>
			<label for="txtpassword">Contraseña</label>
			</div>		
			<div class="input-field col s12 m6 l6">
			<i class="material-icons prefix">lock_outline</i>
			<input id="confirmpassword" type="password" class="validate" required>
			<label for="confirmpassword">Confirmar Contraseña</label>
			</div>			
					
			<div class="input-field col s4">
			<input type="checkbox" id="ckactivo" />
			<label for="ckactivo">Activo</label>
			</div>
			<input type="submit" value="Guardar" style="display:none">  						
		</form>
	</div>
	<div class="modal-footer">		
	  <button id="btnCancelDialogUsr" class="btn waves-effect waves-light red modal-action modal-close">Cancelar
    	<i class="material-icons left">close</i>
  	  </button>
	  <button id="btnSaveDialogUsr" class="btn waves-effect waves-light green" style="margin-right:10px" onclick="$('#modalFrmAdd').find('form').find(':submit').click()">
    	<i class="material-icons left">library_add</i>Agregar
  	  </button>
    </div>	
</div>

<!-- Import SHA512 functions -->
<script src="<?php echo GetURL("recursos/sha512.js")?>"></script>

<script>
	
	//Main
	$(document).ready(function(){		        
		//Get data
		$.ajax({
			url:"<?php echo GetURL("modulos/modusuarios/serviceusuarios.php?accion=1") ?>"
		}).done(
			function(data){
				$("#usuarios tbody").append(data);
				InitDropdown();
				$(".datausuarios").fadeIn();
			}
		);		
	});
		
	function Agregar()
	{														
		if($("#txtpassword").val() != $("#confirmpassword").val())		
		{
			swal("Error", "Contraseñas no concuerdan", "error");
			return;
		}				
		
		var idusuario 	= $("#idusuario").val();
		var nombre 		= $("#nombre").val();
		var email 		= $("#email").val();
		var estado 		= $("#ckactivo").is(':checked') | 0;
		var password 	= hex_sha512($("#txtpassword").val());										
		
		ShowLoadingSwal();
																			
		$.ajax(
			{
			url:"<?php echo GetURL("modulos/modusuarios/serviceusuarios.php?accion=2")?>",
			method: "POST",
			data: {idusuario:idusuario,nombre:nombre,email:email,estado:estado,password:password}
		}).done(function(data){
			$("#modalFrmAdd").closeModal();
			if(data.indexOf("<tr") > -1)
			{
				swal.close();			
				$("#usuarios tbody").append(data);
				InitDropdown();
				$("#"+idusuario).fadeIn();
			}
			else
				swal("Error", data, "error");
		});								
	}

	function Eliminar(idusuario)
	{
		swal({
			title:  "¿Eliminar Registro: " + idusuario + "?" ,
			text: "¿Desea eliminar el registro seleccionado?",
			type: "warning",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
			},
			function(){
			$.ajax({
				url:"<?php echo GetURL("modulos/modusuarios/serviceusuarios.php?accion=4") ?>",
				method: "POST",
				data: {idusuario:idusuario}
			}).done(function(data){
				if(data == "0")
				{
					$("#"+idusuario).fadeOut(function(){
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