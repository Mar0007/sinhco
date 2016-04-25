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
		<button id="btnCrearBloque" class="btn waves-effect waves-light" onclick="location.href='index.php?mod=crearbloque';"><i class="material-icons left">library_add</i>Crear Bloque</button>
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
			url:"modulos/modbloques/servicebloques.php?accion=1"
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
				url:"modulos/modbloques/servicebloques.php?accion=4",
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
	
	//Global Var
	//2D Array -> 1 for inserts, 2 for delete
	var Changes = [[],[]];	
	function Modulos(idbloque)
	{
		$('#ModulosDisponibles tbody').html("");
		$('#ModulosAsignados tbody').html("");
		CleanChanges();
		
		$.ajax({
			url:"modulos/modbloques/servicebloques.php?accion=5",
			method: "POST",
			data: {idbloque:idbloque}
		}).done(function(data){
			if(data != "1")
			{
				var datos = data.split(";"),
					tbody = $('#ModulosDisponibles tbody'),
					modulos = datos[0].split(","); // Modulos disponibles
					
				$.each(modulos, function(i, modulo){
					var tr = $('<tr>'),
						a = $('<a>');
					tr.attr("id", "mod_"+modulo);
					tr.attr("class", "modaldata");
					tr.attr("style", "display:none");
					a.attr("href","javascript:agregarmod('"+modulo+"')");
					a.html(modulo);
					$('<td>').html(a).appendTo(tr);
					tbody.append(tr);
				});
				
				if(datos[1].length > 0)
				{
					var datos = data.split(";"),
						tbody = $('#ModulosAsignados tbody'),
						modulos = datos[1].split(","); // Modulos disponibles
					$.each(modulos, function(i, modulo){		
						var tr = $('<tr>'),
							a = $('<a>');
						tr.attr("id", "mod_"+modulo);
						tr.attr("class", "modaldata");
						tr.attr("style", "display:none");
						a.attr("href","javascript:quitarmod('"+modulo+"')");
						a.html(modulo);
						$('<td>').html(a).appendTo(tr);
						tbody.append(tr);
					});
				}
				$(".modaldata").fadeIn();
				$('.modal-content').scrollTop(1);
			}
			else
			{
				sweetAlert("Error", "Error al obtener modulos del perfil.", "error");
			}
		});
		
		$("#btnSaveDialog").unbind('click').click(function(){		
			swal({
				title: "Cargando...",
				text: "<div class=\"preloader-wrapper big active\">"+
					"<div class=\"spinner-layer spinner-blue-only\">"+
						"<div class=\"circle-clipper left\">"+
						"<div class=\"circle\"></div>"+
						"</div><div class=\"gap-patch\">"+
						"<div class=\"circle\"></div>"+
						"</div><div class=\"circle-clipper right\">"+
						"<div class=\"circle\"></div>"+
						"</div></div></div>",
				html: true,
				allowEscapeKey:false,
				showConfirmButton: false
			});
							
			$.ajax({
				url:"modulos/modbloques/servicebloques.php?accion=6",
				method: "POST",
				data: {idbloque:idbloque,
						DataAdd:Changes[0].toString(),
						DataRemove:Changes[1].toString()}
			}).done(function(data){
				$('#frmModalAsignacion').closeModal();
				if(data == "0")
					swal("Cambios guardados", "Se guardaron los cambios exitosamente.", "success");
				else
					sweetAlert("Error", data, "error");
			});										
		});
  		$('#frmModalAsignacion').openModal();          
	}
		
    function agregarmod(idmodulo){
        var tr=$("#mod_"+idmodulo),
            tbody = $('#ModulosAsignados tbody');
        
		//Checks if it's already marked for deletion
		if(!CheckForChanges(idmodulo,1,true))
		{
			Changes[0].push(idmodulo);
		}
		
        tr.fadeOut("fast",function(){
            $(this).remove();
            tbody.append($(this));
            $("a", this).attr("href","javascript:quitarmod('"+idmodulo+"')");
            $(this).fadeIn("fast");
            
        });
        
    }
	    
    function quitarmod(idmodulo){
        var tr=$("#mod_"+idmodulo),
            tbody = $('#ModulosDisponibles tbody');
			
		if(!CheckForChanges(idmodulo,0,true))
		{
			Changes[1].push(idmodulo);
		}			
        
        tr.fadeOut("fast",function(){
            $(this).remove();
            tbody.append($(this));
            $("a", this).attr("href","javascript:agregarmod('"+idmodulo+"')");
            $(this).fadeIn("fast");            
        });
        
    }
	
	//Event = 0 for Inserts, 1 for Delete
	function CheckForChanges(id,event,bDeleteFound)
	{
		for (var j = 0; Changes[event] && j < Changes[event].length; j++) {
			if(Changes[event][j] == id)
			{
				if(bDeleteFound)
					Changes[event].splice(j,1);
					
				return true;
			}
		}
		
		return false;
	}
	
	function CleanChanges()
	{
		for(var i = 0; i < Changes.length; i++)
			Changes[i].length = 0;
	}
		
		
</script>