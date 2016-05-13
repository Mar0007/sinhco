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
<style>	
	@media only screen and (max-width: 601px){
		#datacontainer .collection-item{
			/*color: red;*/
			padding-left: 15px !important;
		}
		
		#datacontainer .collection-item.avatar .circle {
			width:28px;
			height:28px;
			left: -13px !important;
		}
		
		#datacontainer .handler-class{
			margin-left: 10px !important;
		}
		
		#datacontainer .secondary-content{
			top: 3px;
			right: -19px;
		}
		
		#datacontainer .collection-item.avatar i.circle {
			line-height: 28px;
		}
	}
	
	/* Class Collection
	*/		
	#datacontainer > li > ul{
		margin: 0.5rem 0 1rem 0;
		border: 1px solid #e0e0e0;
		border-radius: 2px;
		position: relative;
	}	
</style>

<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Menus</h3>
            <p class="center light">Cree, edite y organice los menus.</p>
            <div class="divider3"></div>
			<div class="col s12">
				<ul id="maintabs" class="tabs" style="width: 100%; overflow:hidden">
					<li class="tab col s6"><a menuid="3" href="#" OnClick="GetAjaxData('3')">Principal</a></li>
					<li class="tab col s6"><a menuid="2" href="#" OnClick="GetAjaxData('2')">Administrador</a></li>
				</ul>
			</div>					
        </div>		
        
        <!--Module Data-->
        <ul id="datacontainer" class="collection fixed-drop" style="margin-bottom:100px">
			
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
				<div class="row">
				<form class="col s12" id="FrmAdd" action="javascript:Agregar()">				
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
<script type="text/javascript" src="<?php echo GetURL("recursos/jquery.mjs.nestedSortable.js")?>"></script>

<script>
  $(document).ready(function() {		
	//Get Data via ajax
	GetAjaxData("3");
	
	$('.collection-item').unbind('click').click(function()
	{
		$(".collection-item").not(this).removeClass("active");
		$(this).toggleClass("active");
	});	
	
	$('#datacontainer').nestedSortable({
				forcePlaceholderSize: true,
				handle: '.handler-class',
				listType: 'ul',
				items: 'li',
				opacity: .6,
				placeholder: 'placeholder',
				revert: 0,
				tabSize: 10,
				tolerance: 'pointer',
				maxLevels: 2,
				rootID: 'datacontainer',
				isTree: true,
				expandOnHover: 700,
				startCollapsed: false,
				helper: function(e, tr) 
				{
					var $originals = tr.children();
					var $helper = tr.clone();
					//Adds the shadow on selected.
					$helper.addClass("z-depth-5");
					return $helper;
				},				
				update: function()
				{
					var IDMenu = $("#maintabs").find("li").find("a.active").attr("menuid");					
					var Data = JSON.stringify($('#datacontainer').nestedSortable('toHierarchy'));
					
					$.ajax({
						url:"<?php echo GetURL("modulos/modadminmenu/serviceadminmenu.php?accion=5")?>",
						method: "POST",
						data: {'JSONData':Data,'IDMenu':IDMenu}
					}).done(function(data)
					{
						if(data != "0")
						{
							Materialize.toast('Error al guardar las posiciones!', 4000);
							console.error(data);
						}
						else
							Materialize.toast('Guardado', 1000);
					});			  
				}
			}); //END sortable
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
			$('#datacontainer').nestedSortable('refresh')			
		}
	);			  
  }       
  
  function OpenModal(idEdit)
  {
	var frm = $('#modalFrmAdd').find('form');
	frm.trigger('reset');
	
	//Remove Selected
	$(".collection-item").removeClass("active");	
		
	//Reusing frmAdd
	if(!idEdit)
	{
		$('#modalFrmAdd').find('H4').html("Agregar item a menu");
		frm.attr('action','javascript:Agregar()');
		$('#btnSaveDialog').html('<i class="material-icons left">library_add</i>Agregar');	
	}
	else
	{
		$('#modalFrmAdd').find('H4').html("Editar item");
		//Get row cells
		var cells = $("#Row_"+idEdit+' div').children();		
				
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
	var Posicion = "0";
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
		if(data.indexOf('<li') > -1)
		{			
			//Close loading swal.
			swal.close();

			//Insert new row
			$("#datacontainer").prepend(data);
									
			//Get ID item from incoming data
			var IDItem = $(data).attr('id');
			$("#"+IDItem).fadeIn();
			
			//Update table
			renumber_table('#datacontainer');
			
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
	var Posicion = $("#Row_"+id).attr('pos');
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
				var cells = $("#Row_"+id+' div').children();
				//Set Icon
				if(IDIcon == "")
					 IDIcon = 'highlight_off';
				else
					$("#Row_"+id+" .circle").tooltip('remove');
										
				cells[1].innerHTML = IDIcon;	
				//Set Titulo
				cells[2].children[0].innerHTML = Titulo;
				//Set Vinculo
				cells[3].innerHTML = Vinculo;												
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
	var Posicion = $('#Row_'+id).attr('pos');
	var Titulo = $('#Row_'+ id + ' div').children()[2].children[0].innerHTML;
	var IDMenu 	 = $("#maintabs").find("li").find("a.active").attr("menuid");	
	
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
					renumber_table('#datacontainer');										
				});			
				swal("Borrado", "Se borro exitosamente.", "success");
			}
			else
				swal("Error", data, "error");
		});		  		
	});		  
  }
  
  //Renumber rows
  function renumber_table(ID) 
  {     
	var pos = 0;	
	$(ID).children().each(function() 
	{         
		//count = $(this).parent().children().index($(this));
		//$(this).removeAttr('style');
		$(this).attr('pos',pos++);		
	}); 
  }
    
            
</script>