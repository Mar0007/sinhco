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
?>


<!--div class="card-content">
	<h3>Administracion de Menus</h3>
	<div class="row">
		<div class="col s7 m9 l6" style="">
			<div class="input-field col s12">
				<select id="cbMenu">
					<option value="" href="" disabled>Escoge el menu</option>
					<?php
                    
                        $stmt = $mysqli->select("menus",
                        [
                            "idmenu","menu"
                        ]);
                        
                        if($stmt)
                        {
                            foreach($stmt as $row)
                                echo '<option value="'.$row["idmenu"].'">'.$row["menu"].'</option>';
                        }
                        else
                        {
                            if($mysqli->error()[2] != "")
                                echo "<option value=\"-1\" disabled>Error al traer menus</option>";
                            else
                                echo "<option value=\"-1\" disabled>No hay Menus disponible</option>";
                        }                                           					
					?>				
				</select>
				<label>Menu</label>
			</div>
		</div>
		<div class="col s1 m1 l1">
			<a class="btn tooltipped dropdown-button" href='#' data-activates='HSettings' style="margin-top:15px" data-position="bottom" data-delay="50" data-tooltip="Herramientas">			
			<i class="material-icons">build</i>
			</a>
			<ul id='HSettings' class='dropdown-content'>
				<li><a href="javascript:AddNewMenu()"><i class="material-icons left">playlist_add</i>Agregar Menu</a></li>
				<li class="divider"></li>
				<li><a href="javascript:DeleteMenu()"><i class="material-icons left">delete</i>Eliminar Menu</a></li>
			</ul>					
		</div>
	<div class="col s12">
		<table id="tblMenus" class="highlight responsive-table">
			<thead>
				<tr>
					<th>Posicion</th>
					<th>Icono</th>		
					<th>Titulo</th>
					<th>Vinculo</th>
					<th class="center">Acciones</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
	<div class="card-action">
		<button id="btnagregar" class="btn waves-effect waves-light" onclick="OpenModal()">
			<i class="material-icons left">library_add</i>Agregar Item
		</button>
	</div>
</div-->


<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Menus</h3>
            <p class="center light">Cree, edite y organice los menus.</p>
            <div class="divider3"></div>
			<div class="col s12">
				<ul id="maintabs" class="tabs" style="width: 100%;">
					<li class="tab col s6"><a menuid="3" href="#" OnClick="GetAjaxData('3')">Principal</a></li>
					<li class="tab col s6"><a menuid="2" href="#" OnClick="GetAjaxData('2')">Administrador</a></li>
				</ul>
			</div>					
        </div>		
        
        <!--Module Data-->
        <ul id="datacontainer" class="collection fixed-drop">
			
		</ul>
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="btnCrear" class="btn-floating btn-large blue-grey darken-2 tooltipped"  onclick="OpenModal()" data-position="left" data-delay="50" data-tooltip="Crear item">
                <i class="large material-icons">mode_edit</i>
            </a>
        </div>   
    </div>
</div>

<!-- Modal -->
<div id="modalFrmAdd" class="modal modal-fixed-footer">
<div class="modal-content">		
	<div class="row">		
		<div class="col s12">
			<h4>Agregar Item a menu</h4>
			<ul class="tabs">
				<li class="tab col s3"><a class="active" href="#tabFrm">Datos</a></li>
				<li class="tab col s3"><a href="#tabicon">Icono</a></li>
			</ul>
		</div>
		<div id="tabFrm" class="col s12" style="margin-top:20px">        
			<div class="row">
				<form class="col s12" id="FrmAdd" action="javascript:Agregar()">
				<div class="row">
					<div class="input-field col s12">
					<i class="material-icons prefix">menu</i>
					<input id="txtTitulo" type="text" class="validate" required maxlength="20" length="20">
					<label for="txtTitulo">Titulo</label>
					</div>
					<div class="input-field col s12">
					<i class="material-icons prefix">link</i>
					<input id="txtvinculo" type="text" class="validate" required>
					<label for="txtvinculo">Vinculo/URL</label>					
					</div>										
					<input type="submit" style="display:none">					
				</div>
				</form>
			</div>			
		</div>
		<div id="tabicon" class="col s12">
			<h5>Iconos disponibles</h5>
				<?php						    
					$data = json_decode(file_get_contents('recursos/font/material-design-icons/gridicons.json'),true);															
					foreach($data['groups'] as $Group)
					{						
						echo "<div id=\"group_".$Group['data']['id']."\">";
						echo "<span>".$Group['data']['name']."</span>";
						echo "<div class=\"divider\"></div>";
						
						$Icons = array_filter($data['icons'],function($icon) use($Group){
							return ($icon['group_id'] == $Group['data']['id']);
						});						
						
						echo '<div class="collection" style="border-style: none;">';

						foreach($Icons as $Icon)
						{
							if($Icon['ligature'] != "highlight_off")
							{
								echo "<a id=\"icon_".$Icon['ligature']."\" value=\"".$Icon['ligature']."\" class=\"collection-item col s2\" style=\"margin-left:5px;margin-bottom:5px;width:100px;height:100px;cursor:pointer\">						  
										<div class=\"center-align\">
											<i class=\"material-icons medium black-text\">".$Icon['ligature']."</i>										
											<span class=\"truncate\">".$Icon['name']."</span>
										</div>
									</a>";
							}						
						}
						
						echo "</div></div>";						
					}					
				?>										
		</div>
	</div>
</div>
<div class="modal-footer">
	  <button id="btnCancelDialog" class="btn waves-effect waves-light red modal-action modal-close" name="action">Cancelar
    	<i class="material-icons left">close</i>
  	  </button>
	  <button id="btnSaveDialog" onclick="$('#modalFrmAdd').find('form').find(':submit').click()" class="btn waves-effect waves-light green" style="margin-right:10px" name="action">
    	<i class="material-icons left">library_add</i>Agregar
  	  </button>
</div>
</div>


<script>
  $(document).ready(function() {
	/*
	 //Init Materialize combobox/select
    $('select').material_select();
	
	//Add Listener to select
	$('#cbMenu').on('change',function()
	{
		GetAjaxData($(this).val());
	});
	*/
		
	//Get Data via ajax
	GetAjaxData("3");
	
	$('.collection-item').unbind('click').click(function()
	{
		$(".collection-item").not(this).removeClass("active");
		$(this).toggleClass("active");
	});	
	
	
	//Sortable from JQuery UI
	$("#tblMenus tbody").sortable({
		handle: ".handler-class",		
		helper: function(e, tr) 
		{
			//Fix for drag not keeping size
			var $originals = tr.children();
			var $helper = tr.clone();
			$helper.children().each(function(index)
			{
				$(this).width($originals.eq(index).width())
			});
			return $helper;
		},
		update: function(event, ui) 
		{
			var IDMenu = $('#cbMenu').val();
			var data = $("#tblMenus tbody").sortable('serialize') + "&IDMenu=" + IDMenu;
			$.ajax({
				url:"<?php echo GetURL("modulos/modadminmenu/serviceadminmenu.php?accion=5")?>",
				method: "POST",
				data: data
			}).done(function(data){
				if(data != "0")
				{
					Materialize.toast('Error al guardar las posiciones!', 4000);
					console.error(data);
				}
			});			  
		},
		stop: function(event,ui) 
		{
			renumber_table('#tblMenus');
		}   
	}); //END Sortable
	
  }); //END Main
  
  var ajax_request;
  function GetAjaxData(id)
  {
	//Prevent parallel execution of ajax.
	if(ajax_request) ajax_request.abort();
	//Clear table
	$("#datacontainer").empty();
	//Get data
	ajax_request = $.ajax({
		url:"<?php echo GetURL("modulos/modadminmenu/serviceadminmenu.php?accion=1")?>",
		method: "POST",
		data: {IDMenu:id}		
	}).done(
		function(data){
			$("#datacontainer").append(data);
			InitDropdown();
			$(".dataitems").fadeIn();
			$('.tooltipped').tooltip({delay: 50});
		}
	);			  
  }  
  
  function GetRowIDByOrder(idOrder)
  {
	var Rowid;
	$("#tblMenus tr").each(function(){		
		order = $(this).find('.ordermenu').find('span').html();
		if(order == idOrder)
		{
			Rowid = $(this).attr('id');
			return false;
		}
	});
	
	return Rowid;
  }
  
  function MoveRow(id,Posicion)
  {
	//Update Position on table
	var cells = $("#Row_"+id).children();
	var OtherID = GetRowIDByOrder(Posicion);
	if(OtherID)
		if(Posicion < cells[0].children[1].innerHTML)
		$("#Row_"+id).insertBefore($('#'+OtherID));
		else
		$("#Row_"+id).insertAfter($('#'+OtherID));
	else
		$("#tblMenus tbody").append($("#Row_"+id));
						
	cells[0].children[1].innerHTML = Posicion;
	$("#tblMenus tbody").sortable("option", "stop")();
	$("#tblMenus tbody").sortable("option", "update")();	  
  }
  
  function OpenModal(idEdit)
  {
	var frm = $('#modalFrmAdd').find('form');
	frm.trigger('reset');
	var TotalPos = 0;
	$("#tblMenus tr").each(function(){TotalPos++;});
	
	//Remove Selected
	$(".collection-item").removeClass("active");	
		
	//Reusing frmAdd
	if(!idEdit)
	{
		$('#modalFrmAdd').find('H4').html("Agregar item a menu");
		frm.attr('action','javascript:Agregar()');
		$('#btnSaveDialog').html('<i class="material-icons left">library_add</i>Agregar');
		$('#txtPosicion').attr("max",TotalPos - 1);		
	}
	else
	{
		$('#modalFrmAdd').find('H4').html("Editar item");
		//$('#txtPosicion').attr("max",TotalPos - 2);
		//Get row cells
		var cells = $("#Row_"+idEdit).children();		
				
		//Update form info
		$('#txtTitulo').val(cells[2].children[0].innerHTML);	
		$('#txtvinculo').val(cells[3].innerHTML);
		//$('#txtPosicion').val($("#Row_"+idEdit).attr('init'));
		
		$('#icon_'+cells[1].innerHTML).addClass('active');
		
		//Update form action
		frm.attr('action','javascript:Editar('+idEdit+')');
		$('#btnSaveDialog').html('<i class="material-icons left">save</i>Guardar');
	}
	
	Materialize.updateTextFields();
	
	//At last open it.
	$('#modalFrmAdd').openModal();
	$('ul.tabs').tabs('select_tab', 'tabFrm');
	$('.modal-content').scrollTop(1);
	$('#txtTitulo').focus();	  
  }
  
  function Agregar()
  {
	var Titulo   = $('#txtTitulo').val();	
	var Vinculo  = $('#txtvinculo').val();
	//var Posicion = $('#txtPosicion').val();
	var Posicion = "0";
	//var IDMenu   = $('#cbMenu').val();
	var IDMenu 	 = $("#maintabs").find("li").find("a.active").attr("menuid");
	var IDIcon 	 = $(".collection-item.active").attr('value');	
	if(!IDIcon) IDIcon = "";
	
	ShowLoadingSwal();
	
	$.ajax({
		url:"<?php echo GetURL("modulos/modadminmenu/serviceadminmenu.php?accion=2")?>",
		method: "POST",
		data: {"Titulo":Titulo,"Vinculo":Vinculo,"Posicion":Posicion,"IDMenu":IDMenu,"IDIcon":IDIcon}
	}).done(function(data){
		$("#modalFrmAdd").closeModal();		
		if(data.indexOf("<tr") > -1)
		{			
			//Close loading swal.
			swal.close();
			//Get Row that is after new item
			var RowID = GetRowIDByOrder(Posicion);
			//Insert New row to table depending on position
			if(RowID)
				$(data).insertBefore("#"+RowID);
			else
				$("#tblMenus tbody").append(data);
						
			//Get ID item from incoming data
			var IDItem = $(data).attr('id');
			$("#"+IDItem).fadeIn();
			
			//Update table
			renumber_table('#tblMenus');
			
			//Init dropdowns for new rows.
			InitDropdown();
		}
		else
			swal("Error", data, "error");
	});					 
  }
  
  function Editar(id)
  {
	var Titulo   = $('#txtTitulo').val();	
	var Vinculo  = $('#txtvinculo').val();
	//var Posicion = $('#txtPosicion').val();
	var Posicion = $("#Row_"+id).attr("init");
	//var IDMenu   = $('#cbMenu').val();
	var IDMenu 	 = $("#maintabs").find("li").find("a.active").attr("menuid");
	var IDIcon 	 = $(".collection-item.active").attr('value');
	if(!IDIcon) IDIcon = "";
	
	
	ShowLoadingSwal();
	
	$.ajax({
		url:"<?php echo GetURL("modulos/modadminmenu/serviceadminmenu.php?accion=3")?>",
		method: "POST",
		data: {Titulo:Titulo,Vinculo:Vinculo,Posicion:Posicion,IDMenu:IDMenu,IDItem:id,IDIcon:IDIcon}
	}).done(function(data){
		$("#modalFrmAdd").closeModal();
		if(data == "0")
		{			
			//Close loading swal.
			swal.close();			
			//Hide first
			$("#Row_"+id).fadeOut(function()
			{
				//Get row cells
				var cells = $("#Row_"+id).children();
				//Set Icon
				cells[1].innerHTML = IDIcon;		
				//Set Titulo
				cells[2].children[0].innerHTML = Titulo;
				//Set Vinculo
				cells[3].innerHTML = Vinculo;												
				//Move row position
				//MoveRow(id,Posicion);				
				//Show
				$(this).fadeIn();								
			});		
		}	
		else
			swal("Error", data, "error");
	});					 	  
  }
  function Eliminar(id)
  {
	var Posicion = $('#Row_'+id).find('.ordermenu').find('span').html();
	var Titulo = $('#Row_'+id).children()[2].innerHTML;
	var IDMenu = $('#cbMenu').val();
	
	swal({
		title:  "¿Eliminar Registro:\n " + Posicion + " - " + Titulo + "?" ,
		text: "¿Desea eliminar el registro seleccionado?",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true,
		},
		function()
		{				
		$.ajax({
			url:"<?php echo GetURL("modulos/modadminmenu/serviceadminmenu.php?accion=4")?>",
			method: "POST",
			data: {IDMenu:IDMenu,IDItem:id,Posicion:Posicion}
		}).done(function(data){
			if(data == "0")
			{
				$("#Row_"+id).fadeOut(function(){
					$(this).remove();
					renumber_table('#tblMenus');										
				});			
				swal("Borrado", "Se borro exitosamente.", "success");
			}
			else
				swal("Error", data, "error");
		});		  		
	});		  
  }
  
  function AddNewMenu()
  {
	swal(
	{
		title: "<i class=\"material-icons medium\" style=\"position:absolute;top:-40px; left:-10px\">playlist_add</i>"+
				"Agregar nuevo menu",
		text: "Ingrese el nombre del menu:",
		type: "input",
		showCancelButton: true,
		closeOnConfirm: false,
		inputPlaceholder: "Nombre del Menu",
		html:true
	},
	function(inputValue){
		if (inputValue === false) return false;
		
		if (inputValue === "") 
		{
			swal.showInputError("El nombre no puede ir en blanco!");
			return false;
		}
		
		ShowLoadingSwal();			
				
		$.ajax({
			url:"<?php echo GetURL("modulos/modadminmenu/serviceadminmenu.php?accion=6")?>",
			method: "POST",
			data: {Titulo:inputValue}
		}).done(function(data){
			if(data.indexOf("<option") > -1)
			{				
                $("#cbMenu").append(data);
				$('select').material_select();
				swal("Guardado", "Se agrego el menu: " + inputValue, "success");
                /*$TODO
                var Items = $("#cbMenu").children();
                if(Items[0].value == -1)
                {
                    
                }
                */
			}
			else
				swal("Error", data, "error");
		});					 						
	});
  }
  
  function DeleteMenu()
  {
	
    swal("Error","Opcion desabilitada por el Administrador",'error');
    /*
    swal({
			title:  "¿Eliminar el menu: " + $("#cbMenu option:selected").text() + "?" ,
			text: "¿Desea eliminar el menu seleccionado?",
			type: "warning",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
		},
		function(){
			var IDMenu = $("#cbMenu").val();
			$.ajax({
				url:"modulos/modadminmenu/serviceadminmenu.php?accion=7",
				method: "POST",
				data: {IDMenu:IDMenu}
			}).done(function(data){
				if(data == "0")
				{
					$("#cbMenu option:selected").remove();
					$('select').material_select();
					$("#cbMenu").trigger('change');
					swal("Borrado", "Se borro exitosamente.", "success");					
				}
				else
					swal("Error", data, "error");
			});				
	});
    */				  
  }  
            
</script>