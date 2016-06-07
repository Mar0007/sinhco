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
            <h3 class="light center blue-grey-text text-darken-3">Administrar Modulos</h3>
            <p class="center light">Cree, edite y organice los modulos.</p>
            <div class="divider3"></div>
        </div>
        
        <!--Module Data-->
        <ul id="datacontainer" class="collection fixed-drop">
			
		</ul>
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="btnCrear" href="javascript:OpenModal()" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Crear Modulo">
                <i class="large material-icons">add</i>
            </a>
        </div>   
    </div>
</div>

<!--Module data MODAL-->
<div id="datamodal" class="modal create-item modal-fixed-footer">
    <div class="modal-content">
        <h5 style="margin-top:-10px">Crear modulo</h5>        
		<form id="frmModal" autocomplete="off" action="javascript:Agregar()">
			<div class="row card-content">				
				<div class="input-field col s12">
					<label for="txtCodigo">Codigo</label>
					<input id="txtCodigo" type="text" class="validate" required pattern="\S+" title="Sin espacios" maxlength="20" length="20" value="">		
				</div>			
				<div class="input-field col s12">
					<label for="txtTitulo">Titulo</label>
					<input id="txtTitulo" type="text" class="validate" required value="">		
				</div>
				<div class="input-field col s12">
					<label for="txtDescripcion">Descripcion</label>
					<input id="txtDescripcion" type="text" class="validate" required value="">		
				</div>
			</div>			
			<input type="submit" style="display:none">
		</form>          
    </div>
    
    <div class="modal-footer">
        <a id="guardar" onclick="$('#frmModal').find(':submit').click();"  class="modal-action btn-flat waves-effect waves-light">Crear</a>        
        <a id="cancel" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div>        

</div>
<!--END Module data MODAL -->



<script>
	//Main
	$(document).ready(function()
	{						
		//Get data
		$.ajax({
			url:"<?php echo GetURL("modulos/modmodulos/servicemodulos.php?accion=1"); ?>"
		}).done(
			function(data)
			{
				if(data == "none")
				{
					$("#datacontainer").append('<li class="DataEmpty center"><p class="center light">No hay modulos disponibles</p></li>');
					return;
				}
				
				if(data.indexOf("<li") > -1)
				{
					$("#datacontainer").append(data);
					InitDropdown();
					$(".dataitems").fadeIn();
				}
				else
				{
					Materialize.toast('Error al traer los modulos', 3000,"red");				
					console.error("GetAjax->" + data);					
				}
			});		
	});

	function OpenModal()
	{
		$("#datamodal").find("form").trigger("reset");
		$('#datamodal').openModal();
	}

	function Agregar()
	{
		var idmodulo  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		var descripcion = $("#txtDescripcion").val();
		
		//Check first if form is valid.
		if (!$("#frmModal")[0].checkValidity()) 		
		{
			$("#frmModal").find(':submit').click()
			return;
		}			
				
		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modcrearmodulo/servicecrearmodulo.php?accion=2")?>",
			method: "POST",
			data: {idmodulo:idmodulo,titulo:titulo,contenido:null,descripcion:descripcion}
		}).done(function(data){
			if(data == "0")
			{
				$('#datamodal').closeModal();				
				location.href = "crearmodulo/"+idmodulo ;
			}				
			else
			{
				if(data == "104")
					Materialize.toast('Codigo ya existe', 3000,"red");
				else
					Materialize.toast('Error al guardar los datos', 3000,"red");
				
				console.error("Agregar->" + data);
			}
		});					
	}				
		
	function Eliminar(id)
	{		
		ConfirmDelete("Borrar modulo","¿Esta seguro de borrar el modulo?","",
		function()
		{
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
					Materialize.toast('El modulo se borro exitosamente', 3000,"green");					
				}
				else
				{
					Materialize.toast('Error al borrar el modulo', 3000,"red");
					console.error("Eliminar->"+data);
				}
			});
		});
		
	}
		
</script>