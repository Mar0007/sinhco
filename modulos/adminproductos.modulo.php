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
            <a id="crearProyecto" onclick="OpenModal()" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Nuevo producto">
                <i class="large material-icons">mode_edit</i>
            </a>
  
</div>
    
<div id="modalFrmAdd" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Agregar Productos</h4>
		<div class="divider"></div>
		<form id="frmagregar" action="javascript:Agregar()">
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="Nombre" type="text" class="validate" maxlength="20" required>
			<label for="Nombre">Nombre del producto</label>
			</div>		
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">perm_identity</i>
			<input id="Descripcion" type="text" class="validate" required>
			<label for="Descirpcion">Descripcion</label>
			</div>
            <div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="Estado" type="text" class="validate" maxlength="20" required>
			<label for="Estado">Estado</label>
			</div>		
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">perm_identity</i>
			<input id="Precio" type="text" class="validate" required>
			<label for="Precio">Precio</label>
			</div>
            <div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="IdProveedor" type="text" class="validate" maxlength="20" required>
			<label for="IdProveedor">IdProveedor</label>
			</div>		
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">perm_identity</i>
			<input id="IdCategoria" type="text" class="validate" required>
			<label for="IdCategoria">IdCategoria</label>
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
    
<div id="modalFrmEdit" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Editar Producto</h4>
		<div class="divider"></div>
		<form id="frmeditar" action="javascript:Editar()">
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="ENombre" type="text" class="validate" maxlength="20" required>
			<label for="ENombre">Nombre del producto</label>
			</div>
            
            <div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="EDescripcion" type="text" class="validate" maxlength="20" required>
			<label for="EDescripcion">Descripcion del producto</label>
			</div>
            <input type="submit" style="display:none">
        </form>
    </div>
    <div class="modal-footer">		
	  <button id="btnCancelDialogUsr" class="btn waves-effect waves-light red modal-action modal-close">Cancelar
    	<i class="material-icons left">close</i>
  	  </button>
	  <button id="btnSaveDialogUsr" class="btn waves-effect waves-light green" style="margin-right:10px" onclick="$('#modalFrmEdit').find('form').find(':submit').click()">
    	<i class="material-icons left">library_add</i>Agregar
  	  </button>
    </div>
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
    
  function OpenModal(ID)
	{
        if(ID){
            var frm = $('#modalFrmEdit').find('form');
		frm.trigger('reset');
        
            //Get row cells
				var cells = $("#Card_"+ID).children();
				//Set Nombre
				$("#ENombre").val(cells[0].children[1].getElementsByTagName("span")[0].innerHTML);
				//Set descripcion
                $("#EDescripcion").val(cells[0].children[3].children[2].innerHTML);
				//cells[0].children[3].children[2].innerHTML
				//Set Categoria
				//cells[0].children[3].children[1].innerHTML
                
				
        frm.attr('action','javascript:Editar('+ID+')')
		//At last open it.		
        $('#modalFrmEdit').openModal();
		
         
            
        }
        else{
		var frm = $('#modalFrmAdd').find('form');
		frm.trigger('reset');
							
		//At last open it.
		$('#modalFrmAdd').openModal();
		
        }
	}
    
    
    
    function Agregar()
	{														
					
		
		
		var Nombre 		= $("#Nombre").val();
        var Descripcion = $("#Descripcion").val();
        var Estado      = $("#Estado").val();
        var Precio      = $("#Precio").val();
        var IdCategoria = $("#IdCategoria").val();
        var IdProveedor = $("#IdProveedor").val();
        //var estado 	= $("#Estado").val();
								
		
		ShowLoadingSwal();
																			
		$.ajax(
			{
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=2")?>",
			method: "POST",
			data: {Nombre:Nombre,Descripcion:Descripcion,Estado:Estado,IdCategoria:IdCategoria,IdProveedor:IdProveedor,Precio:Precio}
		}).done(function(data){
			$("#modalFrmAdd").closeModal();
			if(data.indexOf("<div") > -1)
			{
				swal.close();			
				$("#productocard").append(data);
				
			}
			else
				swal("Error", data, "error");
		});								
	}
    
    function Editar(IdProductos)
	{
        
		var Nombre        = $("#ENombre").val();
		var Descripcion	  = $("#EDescripcion").val();

		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=3")?>",
			method: "POST",
			data: {IdProductos:IdProductos,Nombre:Nombre,Descripcion:Descripcion}
		}).done(function(data){
            $("#modalFrmEdit").closeModal();
			if(data == "0")// si esta 
			{
                swal.close();
				$("#Card_"+IdProductos).fadeOut(function()
			{
                var cells = $("#Card_"+IdProductos).children();
				//Get row cells
				cells[0].children[1].getElementsByTagName("span")[0].innerHTML = Nombre;		
				//Set Descripcion
				cells[0].children[3].children[2].innerHTML = Descripcion;
				$(this).fadeIn();								
			});					
			}				
			else
				swal("Error", data, "error");
		});					
	}
  function Eliminar(id)
  {
	
	var IdProductos= id;
	
	swal({
		title:  "¿Eliminar Registro ?" ,
		text: "¿Desea eliminar el registro seleccionado?",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true,
		},
		function()
		{				
		$.ajax({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=4")?>",
			method: "POST",
			data: {IdProductos:IdProductos}
		}).done(function(data){
			if(data == "0")
			{
				$("#Row_"+id).fadeOut(function(){
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