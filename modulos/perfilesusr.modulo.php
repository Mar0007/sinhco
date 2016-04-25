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
	<h3>Manejo de Perfiles</h3>
	<div class="row">
		<div class="col s12">
			<table id="perfilesusr" class="highlight responsive-table">
				<thead>
					<tr>		
						<th>Perfil</th>
						<th>Descripcion</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="card-action">
		<button id="btnagregar" class="btn waves-effect waves-light" onclick="OpenModal()"><i class="material-icons left">library_add</i>Agregar Perfil</button>
	</div>
</div>

<div id="modalFrmAdd" class="modal">
	<div class="modal-content">
		<h4>Agregar Perfil</h4>
		<div class="divider"></div><br>
		<form id="frmagregar" title="Agregar Perfil" action="">
			<div class="input-field col s12">
				<i class="material-icons prefix">business_center</i>
				<input type="text" name="idperfil" id="idperfil" placeholder="Nombre" required/>
				<label for="idperfil">Nombre del Perfil</label>
			</div>
			<div class="input-field col s12">
				<i class="material-icons prefix">description</i>
				<input type="text" name="perfil" id="perfil" placeholder="Descripcion" required/><br/><br/>
				<label for="perfil">Descripcion del Perfil</label>
			</div>
			<input type="submit" style="display:none"/>
		</form>
	</div>
	<div class="modal-footer">		
	  <button id="btnCancelDialog" class="btn waves-effect waves-light red modal-action modal-close">Cancelar
    	<i class="material-icons left">close</i>
  	  </button>
	  <button id="btnSaveDialog" class="btn waves-effect waves-light green" onclick="$('#modalFrmAdd').find('form').find(':submit').click()" style="margin-right:10px">Guardar
    	<i class="material-icons left">save</i>
  	  </button>
    </div>
</div>

<!--div>
	<form id="frmagregar" title="Agregar Perfil" action="javascript:agregardatos()">
		<label>Nombre del Perfil:</label>
		<input type="text" name="idperfil" id="idperfil" required/>
		<label>Descripcion del Perfil:</label>
		<input type="text" name="perfil" id="perfil" required/><br/><br/>
		<input type="submit" style="display:none" />
	</form>
</div>

<div>
	<form id="frmEditar" title="Editar Perfil">
		<label>Nombre del Perfil:</label>
		<input type="text" name="idperfil" id="eidperfil" required/>
		<label>Descripcion del Perfil:</label>
		<input type="text" name="perfil" id="eperfil" required/>
		<input type="submit" style="display:none" />
	</form>
</div-->

<div id="frmmodulosperfiles" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Permisos del Perfil</h4>
		<div class="divider"></div>
		<div class="row center">
			<div class="col s6 l6">	
				<table id="modulosdisp">
					<thead><tr><th>Modulos Disponibles</th><tr></thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="col s6 l6">
				<table id="modulospermisos">
					<thead><tr><th>Modulos Accesibles</th><tr></thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">		
	  <button id="btnCancelDialogMods" class="btn waves-effect waves-light red modal-action modal-close" name="action">Cancelar
    	<i class="material-icons left">close</i>
  	  </button>
	  <button id="btnSaveDialogMods" class="btn waves-effect waves-light green" style="margin-right:10px" name="action">Guardar
    	<i class="material-icons left">save</i>
  	  </button>
    </div>
</div>

<script>	
	//Main	
	$(document).ready(function(){		
		$.ajax({
			url:"modulos/modperfilesusr/serviceperfilesusr.php?accion=1"
		}).done(
			function(data){
				$("#perfilesusr tbody").append(data);
				InitDropdown();
				$(".dataperfiles").fadeIn();
			}
		);
		
		//Hide all dialogs.
		//OcultarDialogos();
	});
	
	//Functions
	/*
	function OcultarDialogos()
	{
		$("#frmagregar,#frmEditar").dialog({
			autoOpen: false,
			modal:true
		});
	}
	*/
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
				url:"modulos/modperfilesusr/serviceperfilesusr.php?accion=4",
				method: "POST",
				data: {idperfil:id}
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
	/*
	function mostrarfrmagregar()
	{
		//Clean first
		$("#idperfil").val("");
		$("#perfil").val("");
		
		//Set buttons
		$("#frmagregar").dialog({
			buttons:{
				"Enviar Datos":function(){
					//Force HTML form validation;
					$("#frmagregar").find(':submit').click();
				},
				"Cancelar":function(){
					$("#frmagregar").dialog("close");
				}
			}			
		});

		//Open it.				
		$("#frmagregar").dialog("open");
	}
	*/
	function Agregar()
	{
		var idperfil = $("#idperfil").val();
		var perfil = $("#perfil").val();
		
		ShowLoadingSwal();
		
		$.ajax(
			{
			url:"modulos/modperfilesusr/serviceperfilesusr.php?accion=2",
			method: "POST",
			data: {idperfil:idperfil,perfil:perfil}
		}).done(function(data){
			$("#modalFrmAdd").closeModal();		
			if(data.indexOf("<tr") > -1)
			{
				//Close loading swal.
				swal.close();			
				
				$("#perfilesusr tbody").append(data);
				InitDropdown();
				$("#"+idperfil).fadeIn();
			}
			else
			{
				sweetAlert("Error", data, "error");
			}
		});
	}	
	
	function Editar(idperfil)
	{
		var newidperfil = $("#idperfil").val();
		perfil = $("#perfil").val();
		
		console.log("Editar()->idperfil="+idperfil);							
		
		ShowLoadingSwal();
		
		//Begin Ajax			
		$.ajax({
			url:"modulos/modperfilesusr/serviceperfilesusr.php?accion=3",
			method: "POST",
			data: {idperfil:idperfil,perfil:perfil,newidperfil:newidperfil}
		}).done(function(data){
			$("#modalFrmAdd").closeModal();
			if(data == "0")
			{
				//Close loading swal.
				swal.close();
				
				$("#"+idperfil).fadeOut(function(){
					//Get table cells
					var cells = $("#"+idperfil).children();					
					
					//Update Table data.								
					cells[0].innerHTML = newidperfil;
					cells[1].innerHTML = perfil;																								
					var Actions = cells[2].children[1].children;
					//Editar
					Actions[0].children[0].setAttribute("href","javascript:OpenModal('"+ newidperfil +"')");
					//Modulos
					Actions[1].children[0].setAttribute("href","javascript:Modulos('"+ newidperfil +"')");								
					//Eliminar
					Actions[3].children[0].setAttribute("href","javascript:Eliminar('"+ newidperfil +"')");
					//Update id
					$(this).attr("id",newidperfil);
					//Show()
					$(this).fadeIn();
				});																												
			}
			else
				//ShowErrorDialog(data);
				sweetAlert("Error", data, "error");			
		});
		//End Ajax						
	}
	
	function OpenModal(idEdit)
	{
		var frm = $('#modalFrmAdd').find('form');
		frm.trigger('reset');
			
		//Reusing frmAdd
		if(!idEdit)
		{
			$('#modalFrmAdd').find('H4').html("Agregar Perfil");
			
			//Update form action
			frm.attr('action','javascript:Agregar()');
			//Update Button Text
			$('#btnSaveDialog').html('<i class="material-icons left">library_add</i>Agregar');	
		}
		else
		{
			$('#modalFrmAdd').find('H4').html("Editar Perfil");
			//Get row cells
			var cells = $("#"+idEdit).children();		
					
			//Update form info
			$('#idperfil').val(cells[0].innerHTML);	
			$('#perfil').val(cells[1].innerHTML);
			
			//Update form action
			frm.attr('action','javascript:Editar("'+idEdit+'")');			
			//Update Button Text
			$('#btnSaveDialog').html('<i class="material-icons left">save</i>Guardar');
		}
		
		//At last open it.
		$('#modalFrmAdd').openModal();
		$('#idperfil').focus();	  
	}	
	
	//Global Var
	//2D Array -> 1 for inserts, 2 for delete
	var Changes = [[],[]];	
	function Modulos(idperfil)
	{
		//$FIX Clear first;
		$('#modulosdisp tbody').html("");
		$('#modulospermisos tbody').html("");
		CleanChanges();		
		
		$.ajax({
			url:"modulos/modperfilesusr/serviceperfilesusr.php?accion=5",
			method: "POST",
			data: {idperfil:idperfil}
		}).done(function(data){
			if(data != "1")
			{
				var datos = data.split(";"),
					tbody = $('#modulosdisp tbody'),
					modulos = datos[0].split(","); // Modulos disponibles
					
				$.each(modulos, function(i, modulo){
					var tr = $('<tr>'),
						a = $('<a>');
					tr.attr("id", "mod_"+modulo);
					tr.attr("class", "modulosperfildata");
					tr.attr("style", "display:none");
					a.attr("href","javascript:agregarmod('"+modulo+"')");
					a.html(modulo);
					$('<td>').html(a).appendTo(tr);
					tbody.append(tr);
				});
				
				if(datos[1].length > 0)
				{
					var datos = data.split(";"),
						tbody = $('#modulospermisos tbody'),
						modulos = datos[1].split(","); // Modulos disponibles
					$.each(modulos, function(i, modulo){		
						var tr = $('<tr>'),
							a = $('<a>');
						tr.attr("id", "mod_"+modulo);
						tr.attr("class", "modulosperfildata");
						tr.attr("style", "display:none");
						a.attr("href","javascript:quitarmod('"+modulo+"')");
						a.html(modulo);
						$('<td>').html(a).appendTo(tr);
						tbody.append(tr);
					});
				}
				$(".modulosperfildata").fadeIn();
				$('.modal-content').scrollTop(1);
			}
			else
			{
				sweetAlert("Error", "Error al obtener modulos del perfil.", "error");
			}
		});
		
		$("#btnSaveDialogMods").unbind('click').click(function(){		
			ShowLoadingSwal();							
			$.ajax({
				url:"modulos/modperfilesusr/serviceperfilesusr.php?accion=6",
				method: "POST",
				data: {idperfil:idperfil,
						moduloinsertar:Changes[0].toString(),
						moduloborrar:Changes[1].toString()}
			}).done(function(data){
				$('#frmmodulosperfiles').closeModal();
				if(data == "0")
					swal("Cambios guardados", "Se guardaron los cambios exitosamente.", "success");
				else
					sweetAlert("Error", data, "error");
			});										
		});
  		$('#frmmodulosperfiles').openModal();          
	}
		
    function agregarmod(idmodulo){
        var tr=$("#mod_"+idmodulo),
            tbody = $('#modulospermisos tbody');
        
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
            tbody = $('#modulosdisp tbody');
			
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