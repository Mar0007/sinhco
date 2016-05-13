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
            <h3 class="light center blue-grey-text text-darken-3">Administrar Sliders</h3>
            <p class="center light">Cree, edite y organice los sliders.</p>
            <div class="divider3"></div>
			<div class="col s9 m10 l10" style="">
				<div class="input-field col s12">
					<select id="cbSlider">
						<option value="" href="" disabled>Escoge el Slider</option>
						<?php
							$stmt = $mysqli->select("slider",["idslider","nombre"]);						
							
							if(CheckDBError($mysqli))
								echo "<option value=\"\">Error al traer Sliders</option>";
							else
							{
								if(!$stmt)
									echo "<option value=\"\">No hay Sliders disponible</option>";
								else
								{
									foreach ($stmt as $row) 
										echo '<option value='.$row["idslider"].'">'.$row["nombre"].'</option>';
								}
							}															
						?>				
					</select>
					<label>Slider</label>
				</div>
			</div>
			<div class="col s1 m1 l1">
				<a class="btn tooltipped dropdown-button" href='#' data-activates='HSettings' style="margin-top:15px" data-position="bottom" data-delay="50" data-tooltip="Herramientas">			
				<i class="material-icons">build</i>
				</a>
				<ul id='HSettings' class='dropdown-content'>
					<li><a href="javascript:AddNewSlider()"><i class="material-icons left">playlist_add</i>Agregar Slider</a></li>
					<li class="divider"></li>
					<li><a href="javascript:DeleteSlider()"><i class="material-icons left">delete</i>Eliminar Slider</a></li>
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

<!--div class="row">
		<h3>Administracion de Sliders</h3>		
		<div class="col s9 m10 l6" style="margin-left:-20px;">
			<div class="input-field col s12">
				<select id="cbSlider">
					<option value="" href="" disabled>Escoge el Slider</option>
					<?php
						$stmt = $mysqli->select("slider",["idslider","nombre"]);						
						
						if(CheckDBError($mysqli))
							echo "<option value=\"\">Error al traer Sliders</option>";
						else
						{
							if(!$stmt)
								echo "<option value=\"\">No hay Sliders disponible</option>";
							else
							{
								foreach ($stmt as $row) 
									echo '<option value='.$row["idslider"].'">'.$row["nombre"].'</option>';
							}
						}															
					?>				
				</select>
				<label>Slider</label>
			</div>
		</div>
		<div class="col s1 m1 l1">
			<a class="btn tooltipped dropdown-button" href='#' data-activates='HSettings' style="margin-top:15px" data-position="bottom" data-delay="50" data-tooltip="Herramientas">			
			<i class="material-icons">build</i>
			</a>
			<ul id='HSettings' class='dropdown-content'>
				<li><a href="javascript:AddNewSlider()"><i class="material-icons left">playlist_add</i>Agregar Slider</a></li>
				<li class="divider"></li>
				<li><a href="javascript:DeleteSlider()"><i class="material-icons left">delete</i>Eliminar Slider</a></li>
			</ul>					
		</div>
				
	<table id="tblSliders" class="highlight bordered centered">
		<thead>
			<tr>
				<th>Posicion</th>		
				<th>Imagen</th>
				<th style="width:300px">Modulos</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<div class="card-action">
		<button id="btnagregar" class="btn waves-effect waves-light" onclick="OpenModal()">
			<i class="material-icons left">library_add</i>Agregar Item
		</button>
	</div-->

    <!-- Modal -->
    <div id="modalFrmAdd" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Agregar Item a Slider</h4>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3"><a class="active" href="#TabImg">Imgs</a></li>
                        <li id="TabModulos" class="tab col s3"><a href="#Modulos">Modulos</a></li>
                    </ul>
                </div>
                <div id="TabImg" class="col s12">
                    <ul class="collapsible z-depth-0" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">file_upload</i>Agregar Imagen</div>
                            <div class="collapsible-body col s12" style="display:inline">
                                <div id="LoaderUpload" class="progress" style="display:none">
                                    <div class="indeterminate"></div>
                                </div>						
                                <div id="contentUploads">				
                                    <form id="frmUpload" method="post" enctype="multipart/form-data">
                                        <div class="file-field input-field col s10">
                                            <div class="btn">
                                                <span><i class="material-icons left">camera_alt</i>Buscar</span>
                                                <input id="FileInput" name="file" type="file" accept=".jpg,.png">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text">
                                            </div>
                                        </div>
                                    </form>
                                    <div class="input-field col s2">
                                        <button id="btnUpload" class="btn waves-effect waves-light" onclick="AgregarImagen()"><i class="material-icons">file_upload</i>
                                        </button>
                                    </div>
                                </div>						
                            </div>
                        </li>
                    </ul>						
                    <div class="col s12">								
                        <h6>Seleccione una imagen:<h6>
                        <div id="ColImgs" class="collection" style="border-style: none;">
                        </div>
                    </div>
                </div>
                <div id="Modulos" class="col s12">
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
            </div>
        </div>
        <div class="modal-footer">
              <button id="btnCancelDialog" class="btn waves-effect waves-light red modal-action modal-close" name="action">Cancelar
                <i class="material-icons left">close</i>
              </button>
              <button id="btnSaveDialog" class="btn waves-effect waves-light green" style="margin-right:10px" name="action">
                <i class="material-icons left">library_add</i>Agregar
              </button>
        </div>
    </div>
</div>


<script>
  $(document).ready(function() {
	 //Init Materialize combobox/select
    $('select').material_select();		
	
	//Add Listener to select
	$('#cbSlider').on('change',function()
	{
		GetAjaxData($(this).val());
	});
			
	//Get Data via ajax
	GetAjaxData($('#cbSlider').val());
	
	//Sortable from JQuery UI
	$("#datacontainer").sortable({
		handle: ".handler-class",		
		helper: function(e, tr) 
		{
			//Fix for drag not keeping size
			var $originals = tr.children();
			var $helper = tr.clone();
			//Adds the shadow on selected.
			$helper.addClass("z-depth-5");			
			return $helper;
		},
		//axis: "y",
		tolerance: "pointer",		
		update: function(event, ui) 
		{
			var IDSlider = $("#datacontainer").val();
			var data = $("#datacontainer").sortable('serialize') + "&IDSlider=" + IDSlider;
			$.ajax({
				url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=5") ?>",
				method: "POST",
				data: data
			}).done(function(data){
				if(data != "0")
				{
					Materialize.toast('Error al guardar las posiciones!', 4000);
					console.error(data);
				}
				else
				{
					Materialize.toast('Guardado', 1000);
				}
			});			  
		},
		stop: function(event,ui) 
		{
			renumber_table("#datacontainer");
		}   
	}); //END Sortable	
	
  }); //END Main
  
  var ajax_request;
  function GetAjaxData(id)
  {
	//Prevent parallel execution of ajax.
	if(ajax_request) ajax_request.abort();
	//Clear
	$("#datacontainer").empty();
	//Get data
	ajax_request = $.ajax({
		url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=1") ?>",
		method: "POST",
		data: {IDSlider:id}		
	}).done(
		function(data){
			$("#datacontainer").append(data);
			InitDropdown();
			$(".dataitems").fadeIn();
			$('.materialboxed').materialbox();
		}
	);			  
  }
  
  //Renumber rows
  function renumber_table(ID) 
  {     
	var pos = 0;	
	$(ID).children().each(function() 
	{         
		//count = $(this).parent().children().index($(this));
		//$FIX
		$(this).removeAttr('style');
		$(this).attr('pos',pos++);		
	}); 
  }

  
  function OpenModal(idEdit)
  {	
	//Reusing frmAdd
	if(!idEdit)
	{
		$('#modalFrmAdd').find('H4').html("Agregar item a Slider");
		$('#btnSaveDialog').html('<i class="material-icons left">library_add</i>Agregar');		
	}
	else
	{
		$('#modalFrmAdd').find('H4').html("Editar item");		
		$('#btnSaveDialog').html('<i class="material-icons left">save</i>Guardar');
	}

	$("#btnSaveDialog").unbind('click').click(function(){		
		//PreCheck
		if(!$("#ColImgs .collection-item.active").length)
		{
			swal("Error", "Seleccione una imagen", "error");
			return;
		}
		
		if($('#ModulosAsignados tbody').html() == "")
		{
			swal("Error", "Asigne al menos 1 modulo", "error");
			return;
		}
		
		//Call needed function;
		if(!idEdit)	
			Agregar();
		else
			Editar(idEdit);							
	});
		
	
	GetAjaxImages(idEdit);
	LoadModulos(idEdit);
		 
	$('#modalFrmAdd').openModal();
	$('ul.tabs').tabs('select_tab', 'TabImg');
  }
  
  
//Loading Animation
  var HTMLLoader = 
  "<div class=\"col s12 center TabLoader\" style=\"margin-top: 10%\">" +
  "<div class=\"preloader-wrapper big active\">"+
  "<div class=\"spinner-layer spinner-blue-only\">"+
  "<div class=\"circle-clipper left\">"+
  "<div class=\"circle\"></div>"+
  "</div><div class=\"gap-patch\">"+
  "<div class=\"circle\"></div>"+
  "</div><div class=\"circle-clipper right\">"+
  "<div class=\"circle\"></div>"+
  "</div></div></div></div>";	
	
  function GetAjaxImages(IDEdit)
  {	
	var IDSlider   = $('#cbSlider').val();
	$("#TabImg").find('#ColImgs').empty();
	$("#TabImg").append(HTMLLoader);
	if(!IDEdit) IDEdit = -1;
	
	$.ajax({
		url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=9")?>",
		method: "POST",
		data: {IDSlider:IDSlider,IDEdit:IDEdit}		
	}).done(function(data){
		$("#TabImg").find('.TabLoader').remove();
		$("#TabImg").find('#ColImgs').html(data);
		$('#ColImgs .collection-item').unbind('click').click(function()
		{
			$("#ColImgs .collection-item").not(this).removeClass("active");
			$(this).toggleClass("active");
		});	
		
	});	  
		
  }
  
  function Agregar()
  {		
	IDImagen = $("#ColImgs .collection-item.active").attr('value');
	IDSlider = $('#cbSlider').val();
	Orden = 0;
	ShowLoadingSwal();
	
	$.ajax({
		url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=2")?>",
		method: "POST",
		data: {IDImagen:IDImagen,
			   IDSlider:IDSlider,
			   Orden:Orden,
			   DataAdd:Changes[0].toString(),
			   DataRemove:Changes[1].toString()}
	}).done(function(data){
		$("#modalFrmAdd").closeModal();		
		if(data.indexOf("<li") > -1)
		{			
			//Close loading swal.
			swal.close();
			
			$("#datacontainer").append(data);						
			//Get ID item from incoming data
			var IDItem = $(data).attr('id');
			$("#"+IDItem).fadeIn();						
			
			//Init dropdowns for new rows.
			InitDropdown();
			
			//Activate sortable events
			$("#datacontainer").sortable("option", "stop")();
			$("#datacontainer").sortable("option", "update")();	  			
		}
		else
			swal("Error", data, "error");
	});					 
  }
  
  function Editar(id)
  {
	var cells 	 = $("#Row_"+id).children();
	IDImagen 	 = $("#ColImgs .collection-item.active").attr('value');
	IDImgInit 	 = $("#ColImgs .collection-item.Initial").attr('value');
	IDSlider 	 = $('#cbSlider').val();
	Orden 		 = $("#Row_"+id).attr("pos");
	
	ShowLoadingSwal();
	
	$.ajax({
		url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=2")?>",
		method: "POST",
		data: {IDImagen:IDImagen,
			   IDImgInit:IDImgInit,
			   IDSlider:IDSlider,
			   Orden:Orden,
			   DataAdd:Changes[0].toString(),
			   DataRemove:Changes[1].toString()}
	}).done(function(data){
		$("#modalFrmAdd").closeModal();		
		if(data.indexOf("<li") > -1)
		{			
			//Close loading swal.
			swal.close();
			$("#Row_"+IDImgInit).fadeOut(function(){
				//Insert before the faded row.
				$(data).insertBefore($(this));
				$(this).remove();
				
				//Get ID item from incoming data
				var IDItem = $(data).attr('id');
				$("#"+IDItem).fadeIn();
				
				//Init dropdowns for new rows.
				InitDropdown();
			});			
		}
		else
			swal("Error", data, "error");
	});				
  }
  
  
  function Eliminar(id)
  {
	var IDSlider = $('#cbSlider').val();
	
	swal({
		title:  "¿Eliminar registro seleccionado?" ,
		text: "¿Desea eliminar el registro seleccionado?",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true,
		},
		function()
		{				
		$.ajax({
			url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=4")?>",
			method: "POST",
			data: {IDSlider:IDSlider,IDImagen:id}
		}).done(function(data){
			if(data == "0")
			{
				$("#Row_"+id).fadeOut(function(){
					$(this).remove();
					$("#datacontainer").sortable("option", "stop")();
					$("#datacontainer").sortable("option", "update")();													
				});				  				
				swal("Borrado", "Se borro exitosamente.", "success");
			}
			else
				swal("Error", data, "error");
		});		  		
	});		  
  }
  
  function AddNewSlider()
  {
	swal(
	{
		title: "<i class=\"material-icons medium\" style=\"position:absolute;top:-40px; left:-10px\">playlist_add</i>"+
				"Agregar nuevo slider",
		text: "Ingrese el nombre del slider:",
		type: "input",
		showCancelButton: true,
		closeOnConfirm: false,
		inputPlaceholder: "Nombre del slider",
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
			url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=6")?>",
			method: "POST",
			data: {Titulo:inputValue}
		}).done(function(data){
			if(data.indexOf("<option") > -1)
			{
				$("#cbSlider").append(data);
				$('select').material_select();
				swal("Guardado", "Se agrego el slider: " + inputValue, "success");
			}
			else
				swal("Error", data, "error");
		});					 						
	});
  }
  
  function DeleteSlider()
  {
	swal({
			title:  "¿Eliminar el slider: " + $("#cbSlider option:selected").text() + "?" ,
			text: "¿Desea eliminar el slider seleccionado?",
			type: "warning",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
		},
		function(){
			var IDSlider = $("#cbSlider").val();
			$.ajax({
				url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=7")?>",
				method: "POST",
				data: {IDSlider:IDSlider}
			}).done(function(data){
				if(data == "0")
				{
					$("#cbSlider option:selected").remove();
					$('select').material_select();
					$("#cbSlider").trigger('change');
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
	function LoadModulos(id)
	{
		$('#ModulosDisponibles tbody').empty();
		$('#ModulosAsignados tbody').empty();
		CleanChanges();
		
		if($("#Modulos .TabLoader").length < 0);
			$("#Modulos").append(HTMLLoader);
		
		var IDImage = (id ? id : -1);	
		var IDSlider = $('#cbSlider').val();
		
		if(ajax_request) ajax_request.abort();
		
		ajax_request = $.ajax({
			url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=8")?>",
			method: "POST",
			dataType: "JSON",
			data: {IDImage:IDImage,IDSlider:IDSlider}
		});
						
		ajax_request.done(function(data)
		{
			if(data["Disponibles"])
			{
				//console.log("-----------------------------");
				//console.log("-> Disponibles");
				//console.log("-----------------------------");
				$.each(data["Disponibles"],function( key, val)
				{
					//console.log("Val->" + val["idmodulo"]);
					$("<tr>",
					{
						"id":"mod_"+val["idmodulo"],
						"class":"modaldata",
						"style":"display:none",
						html:"<td><a href=\"javascript:agregarmod('"+val["idmodulo"]+"')\">"+val["idmodulo"]+"</a></td>"
					}).appendTo("#ModulosDisponibles tbody");
				});
			}
			
			if(data["Asignados"])
			{
				//console.log("-----------------------------");
				//console.log("-> Asignados");
				//console.log("-----------------------------");
				$.each(data["Asignados"],function( key, val)
				{
					//console.log("Val->" + val["idmodulo"]);
					$("<tr>",
					{
						"id":"mod_"+val["idmodulo"],
						"class":"modaldata",
						"style":"display:none",
						html:"<td><a href=\"javascript:quitarmod('"+val["idmodulo"]+"')\">"+val["idmodulo"]+"</a></td>"
					}).appendTo("#ModulosAsignados tbody");
				});
			}			
									
			$("#Modulos").find('.TabLoader').remove();
			$(".modaldata").fadeIn();
			$('.modal-content').scrollTop(1);			
		});
		
		ajax_request.fail(function(AjaxObject)
		{
			sweetAlert("Error", "Error al obtener modulos del perfil.", "error");
			console.error("Ajax JSON-> "+AjaxObject.responseText);
		});		
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
	
	function AgregarImagen()
	{
		if($('#FileInput').val() == "")
		{
			sweetAlert("Error", "Seleccione una imagen", "error");
			return;
		}
		
		$("#contentUploads").hide();
		$("#LoaderUpload").show();
		
		$.ajax({
				url: "<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=10")?>",
				type: "POST",
				data: new FormData($(frmUpload)[0]),
				contentType: false,
				cache: false,
				processData:false
		}).done(function(data){
			if(data.indexOf("<a") > -1)
			{
				//$("#TabImg").find('.TabLoader').remove();
				$("#TabImg").find('#ColImgs').append(data);
				$('#ColImgs .collection-item').unbind('click').click(function()
				{
					$("#ColImgs .collection-item").not(this).removeClass("active");
					$(this).toggleClass("active");
				});	
				$("#frmUpload").trigger('reset');
				$("#contentUploads").show();
				$("#LoaderUpload").hide();
						
			}
			else
				swal("Error", data, "error");
		});		
	}
	
	function DeleteImage(id)
	{
		//alert("Imagen->"+$("#IMG_"+id).html());
		//return;
		swal({
			title: "",
			text:  "¿Eliminar imagen seleccionada?" ,
			//text: "<img src=\""+$("#IMG_"+id).find('img').attr('src')+"\" width=\"80px\" height=\"80px\">",
			imageUrl: $("#IMG_"+id).find('img').attr('src'),
			type: "warning",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
			},
			function()
			{				
				$.ajax({
					url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=11")?>",
					method: "POST",
					data: {IDImagen:id}
				}).done(function(data){
					if(data == "0")
					{
						$("#IMG_"+id).fadeOut(function(){
							$(this).remove();								
						});			
						swal("Borrado", "Se borro exitosamente.", "success");
					}
					else
						swal("Error", data, "error");
				});		  		
		});		  		
	}
	
	function EditarImagen(id)
	{
		swal({
			title: "Editar Titulo",
			type: "input",
			inputValue: $("#IMG_"+id).find('span').html(),		
			imageUrl: 	$("#IMG_"+id).find('img').attr('src'),
			showCancelButton: true,
			closeOnConfirm: false,
			inputPlaceholder: "Titulo de la Imagen"
			},
			function(inputValue){
			if (inputValue === false) return false;
			
			if (inputValue === "") {
				swal.showInputError("La imagen necesita tener un titulo valido.");
				return false
			}
			
			ShowLoadingSwal();
			
			$.ajax({
				url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=12")?>",
				method: "POST",
				data: {IDImagen:id,Imagen:inputValue}
			}).done(function(data){
				if(data == "0")
				{
					$("#IMG_"+id).fadeOut(function(){
						$(this).find('span').html(inputValue);
						$(this).fadeIn();
					});			
					swal("Guardado", "Se guardaron los cambios exitosamente.", "success");
				}
				else
					swal("Error", data, "error");
			});		  								
		});
	}
            
</script>