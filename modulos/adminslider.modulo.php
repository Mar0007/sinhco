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

/*    
	if( !URLParam(1) )
	{
		echo "Proyecto no encontrado";
		return;
	}
    
    $IDSlider = URLParam(1);        
*/
    
    //Set to "Slider Principal"
    $IDSlider = 0;
    
	//Get proyect info
	$stmtSlider = $mysqli->select("Slider",["nombre"],["idslider" => $IDSlider])[0];    
    if( CheckDBError($mysqli) ) return;
?>

<style>
    
    .CornerShadow 
    {
        position:absolute;
        top:0;
        right:0;
        width:156px;
        height:40px;
        background:linear-gradient(
                15deg,
                transparent 0%,
                transparent 50%,
                rgba(0, 0, 0, 0.3)70%,
                rgba(0, 0, 0, 0.71)100%
            )
            
      /*
       Original
       background:linear-gradient(15deg,transparent 0%,transparent 45%,rgba(0,0,0,.12)70%,rgba(0,0,0,.33)100%)
      */
    }
    
    #CoverThumbnails li
    {
        display: inline-block;
    }
    
    #CoverThumbnails img 
    {
        width:32px;
        height:32px;
        margin-right:5px
    }
    
</style>
<!-- Vars -->
<input type="hidden" id="IDSlider" value="<?php echo $IDSlider ?>">
<input type="hidden" id="maxsize" value="<?php echo parse_size(ini_get('upload_max_filesize')) ?>">

<!-- SideBar -->
<div class="sidebar-left blue darken-2  ">
    <div class="no-padding" style="">
        <div class="" style="height:100%;position:relative">            
            <div id="profile-header" class="content" >
                <?php                                                         
                    echo 
                    "
                        <img id=CSlider_".$IDSlider." class=\"image-header\" style=\"width:100%;\" src=\"".GetProyectImagePath("CoverSlider-".$IDSlider)."\">
                    ";
        
                    $stmtImg = $mysqli->select("slider_img_mod",
                    [
                        "[><]imagenes"=>"idimagen"                    
                    ],
                    [
                        "idimagen","ruta"                    
                    ],
                    [
                        "idslider" => $IDSlider,
                        "GROUP" => "idimagen",
                        "ORDER" => "orden ASC"
                    ]);                                        
                ?>   
                <div class="description">
                    <h5 id="sidename" class="white-text " style="overflow:hidden;margin:0px; padding-left:4%"><?php echo $stmtSlider["nombre"] ?></h5>
                    <h6 id="sideplace" class="white-text light" style="margin-top:2%; padding-left:4%;padding-bottom:1%"><span id="TotalImgs"><?php echo count($stmtImg) ?></span> <?php echo ( (count($stmtImg) > 1 ) ? "imágenes" : "imagen") . " en este slider" ?></h6>
                    <ul id="CoverThumbnails" style="padding-left:4%;list-style-type: none; margin: auto;">                    
                    <?php
                        foreach ($stmtImg as $key => $row)                         
                            echo '<li id="CImg_'.$row["idimagen"].'" data-id="'.$row["idimagen"].'" style="opacity:0;"><img src="'.$row["ruta"].'" class="circle"></li>';    
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>    
</div>
<!-- /End SideBar -->

<div style="postion:relative">
    <div class="content-right" style="">
        <div class="row">
            <!-- Data Container -->            
            <ul id="data-list"></ul>            
            <!-- Fixed action button -->
            <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a id="creatItem" onclick="ItemModal()" data-target="frmagregar" class="btn-floating btn-large blue-grey darken-2 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Agregar imagen">
                    <i class="large material-icons">add</i>
                </a>                 
            </div> 
        </div>
    </div>
</div>


<!-------------------------------------------- MODAL AGREGAR IMAGEN AL PROYECTO ------------------------------->
 <div id="modalFrmAdd" class="modal modal-fixed-footer custom-item" style="width:474px">
        <div id="top-content" class="modal-content">
            <h5 class="light">Agregar una imagen</h5>
            
            <div class="col s12">
                <ul class="tabs" style="overflow:hidden">
                    <li class="tab col s3"><a class="active" href="#TabImg">Img</a></li>
                    <li class="tab col s3"><a href="#TabModulos">Modulos</a></li>
                </ul>
            </div>             
            <br>
            <!-- Tab 1 -->           
            <div id="TabImg">				
                <form id="frmUpload" method="post" enctype="multipart/form-data" style="max-height:120px">
                    <div style="position:relative">
                        <img id="proyect-img" src="<?php echo GetURL("uploads/covers/camerabg.png")?>" style="width:100%; object-fit:cover; height:220px;" class="responsive-img"></img>
                        <div class="CornerShadow">
                            <div class="btn-floating btn-small transparent z-depth-0 waves-effect waves-circle file-field input-field" style="position:absolute;right:2px;top:-15px">
                                <i class="material-icons white-text">camera_alt</i>
                                <input id="FileInput" required name="file" type="file" accept=".jpg,.png">
                            </div>                        
                        </div>
                    </div>
                    <span class="right grey-text">Tamaño maximo: <?php echo ini_get('upload_max_filesize') ?></span>
                    <input id="InitImage" type="hidden" value="">
                    <div class="input-field col s12">
                        <input id="img-title" length="50" name="img-title" type="text" class="validate"> 
                        <label for="img-title">Título de la imagen</label>
                    </div>
                    
                    <label>Alineacion del Texto</label><br>
                    <input name="TextAlign" type="radio" checked id="RLeft" value="Left"/>
                    <label for="RLeft">Izquierda</label>
                    <input name="TextAlign" type="radio" id="RRight" value="Right"/>
                    <label for="RRight">Derecha</label>
                    <input name="TextAlign" type="radio" id="RCenter" value="Center"/>
                    <label for="RCenter">Centro</label>                    
                    
                    <input type="submit" style="display:none">                    
                </form>
            </div>
            <!-- /Tab 1 -->
            <!-- Tab 2 -->
            <div id="TabModulos">
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
            <!-- /Tab 2 -->    
        </div>
                
        <div class="modal-footer">
            <a id="guardar" class="btn blue darken-1 waves-effect ">Agregar<i class="material-icons right"></i></a>
            <a id="cancel" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
        </div>        
</div>
<!-------------------------------------------- MODAL AGREGAR IMAGEN AL PROYECTO ------------------------------->


<script>
    //Main
    $(document).ready(function(){        
        
        $("#data-list").append(HTMLLoader);        
        var IDSlider = $("#IDSlider").val();
        
        Materialize.showStaggeredList("#CoverThumbnails");
        
        //Add event to FileInput
        $("#FileInput").change(handleFileSelect);
        
        $.ajax(
        {
            url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=1")?>",
            method: "POST",
            data: {IDSlider:IDSlider}		
        }).done(
        function(data)
        {
            $("#data-list .TabLoader").remove();
            $("#data-list").append(data);	
            Materialize.showStaggeredList("#data-list");
        });
        
        $("#CoverThumbnails").sortable({		
            helper: 'clone',
            tolerance: "pointer",
            start: function(event, ui)
            {
                pre = ui.item.index();
            },
            stop: function(event, ui) 
            {
                lst = $(this).attr('id');
                post = ui.item.index();
                other = 'data-list'                
                if (post > pre) 
                    $('#'+other+ ' li:eq(' +pre+ ')').insertAfter('#'+other+ ' li:eq(' +post+ ')');
                else
                    $('#'+other+ ' li:eq(' +pre+ ')').insertBefore('#'+other+ ' li:eq(' +post+ ')');
            },                          		
            update: function(event, ui) 
            {
                UpdateOrder();
            }        
        });	        
    });
    
    function UpdateOrder()
    {
        var data = $("#CoverThumbnails").sortable('serialize') + "&IDSlider=" + $("#IDSlider").val();
        $.ajax({
            url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=6") ?>",
            method: "POST",
            data: data
        }).done(function(data)
        {
            if(data != "0")
            {
                Materialize.toast('<i class="material-icons left">highlight_off</i>Error al guardar las posiciones.', 4000,"red");
                console.error(data);
            }
            else
                Materialize.toast('<i class="material-icons left">check_circle</i> Guardado', 1000,"green");
        });			                  
    }
    
    
    function ItemModal(id)
    {
        //Reset Form
        $("#modalFrmAdd").find("form").trigger("reset");
        
        //Agregar
        if(!id)
        {
            $("#modalFrmAdd").find("img").attr('src','<?php echo GetURL("uploads/covers/camerabg.png")?>');
            $("#InitImage").attr('src','<?php echo GetURL("uploads/covers/camerabg.png")?>');
            $("#guardar").text('Agregar');
        }
        else 
        {
        //Editar
            $("#modalFrmAdd").find("img").attr('src', $("#IMG_"+id).find('img').attr('src') );
            $("#InitImage").attr('src',$("#IMG_"+id).find('img').attr('src'));
            $("#img-title").val( $("#IMG_"+id).find('.card-title').text() );
            $("#guardar").text('Editar');
        }
        
        
        //Set Action on btnSaveDialog
        $("#guardar").unbind('click').click(function()
        {
            if (!$("#frmUpload")[0].checkValidity() && !id)
            {
                $('ul.tabs').tabs('select_tab', 'TabImg');
                $("#frmUpload").find(':submit').click();
                Materialize.toast('<i class="material-icons left">error_outline</i>La imagen es requerida.', 3000,"red");
                return;
            }			
                                    
            if($('#ModulosAsignados tbody').html() == "")
            {
                $('ul.tabs').tabs('select_tab', 'TabModulos');
                Materialize.toast('<i class="material-icons left">error_outline</i>Asigne al menos 1 modulo.', 3000,"red");
                return;
            }
            
            if(!id)
            {
                Agregar();
                return;
            }
            
            Editar(id);                        
        });
        
        LoadModulos(id);
        Materialize.updateTextFields();
        $("#modalFrmAdd").openModal();
        $('ul.tabs').tabs('select_tab', 'TabImg');                
    }
    
    function Agregar()
    {
        var formData = new FormData($('#frmUpload')[0]);
        formData.append("DataAdd",Changes[0].toString());
        formData.append("IDSlider",$("#IDSlider").val());
        
        //Debug FormData
        //console.table(Array.from(formData.entries()));
        
        //Show loading animation
        ShowLoadingSwal();
        
        $.ajax({
                url: "<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=2")?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false            
        }).done(function(data)
        {                
            if(data.indexOf("<li") > -1)
            {
                //Close modal
                $("#modalFrmAdd").closeModal();                                
                
                //Add data                
                $("#data-list").prepend(data);
                
                var IncomingID = $(data).attr("data-id");
                
                $("#IMG_" + IncomingID ).css({
                    "display": "none",
                    "opacity": "1"
                });                
                
                //Add to Thumbnails
                $("#CoverThumbnails").prepend(
                    '<li id="CImg_'+IncomingID+'" style="display: none;"><img src="'+$(data).find('img').attr('src')+'" class="circle"></li>'
                );
                
                //Renumber imgs
                $("#TotalImgs").text($("#CoverThumbnails li").length);
                
                //Show them.
                $("#CImg_" + IncomingID).fadeIn();
                $("#IMG_"  + IncomingID).fadeIn();                                                            
            }        
            else
            {
                Materialize.toast('<i class="material-icons left">highlight_off</i>Error, no se pudo agregar la imagen.', 3000,"red");
                console.error("Error->Agregar(): "+data);
            }
            
            //Close loading swal.
            swal.close();
        });		      
    }            
    
    function Editar(id)
    {
        var formData = new FormData($('#frmUpload')[0]);
        formData.append("DataAdd",Changes[0].toString());
        formData.append("DataRemove",Changes[1].toString());
        formData.append("IDSlider",$("#IDSlider").val());
        formData.append("IDImagen",id);        
        
        //Show loading animation
        ShowLoadingSwal();
        
        $.ajax({
                url: "<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=3")?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false            
        }).done(function(data)
        {                
            if(data.indexOf("<li") > -1)
            {
                //Close modal
                $("#modalFrmAdd").closeModal();
                
                //Update cover Thumbnails
                $("#CImg_"+id).fadeOut(function(){                                        
                    $(this).find('img').attr('src',$(data).find('img').attr('src'));
                    $(this).fadeIn();
                });
                
                //Add data                
                $("#IMG_"+id).fadeOut(function(){
                    //Insert before the faded row.
                    $(data).insertBefore($(this));
                    $(this).remove();
                    
                    $("#IMG_"+id).css({
                        "display": "none",
                        "opacity": "1"
                    });
                    
                    $("#IMG_"+id).fadeIn();                    
                });			                            
            }        
            else
            {
                //Handle error
                Materialize.toast('<i class="material-icons left">highlight_off</i>Error, no se pudo editar la imagen.', 3000,"red");
                console.error("Error->Editar():"+data);
            }
            
            //Close loading swal.
            swal.close();
        });		      
    }
    
    
    function DeleteImage(id)
    {
        var IDSlider = $("#IDSlider").val();
               
        ConfirmDelete("Borrar imagen","¿Esta seguro de borrar la imagen?","",
        function()
        {
            //Show loading animation
            ShowLoadingSwal();        
            
            $.ajax({
                url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=4")?>",
                method: "POST",
                data: {IDSlider:IDSlider,IDImagen:id}
            }).done(function(data){
                //Close loading animation
                swal.close();
                
                if(data == "0")
                {
                    $("#IMG_"+id).fadeOut(function(){
                        $(this).remove();
                    });
                    
                    $("#CImg_"+id).fadeOut(function(){
                        $(this).remove();
                        //Renumber imgs
                        $("#TotalImgs").text($("#CoverThumbnails li").length);	                    		  				                        
                    });
                                        
                    Materialize.toast('<i class="material-icons left">check_circle</i>La imagen se borro exitosamente', 4000,"green");
                }
                else
                {
                    Materialize.toast('<i class="material-icons left">highlight_off</i>Error al tratar de borrar la imagen', 4000,"red");
                    console.error("Error->DeleteImage():"+data);
                }
            });            
        });
    }    
    
	//Global Var
	//2D Array -> 1 for inserts, 2 for delete
	var ajax_request;
    var Changes = [[],[]];	
	function LoadModulos(id)
	{
		$('#ModulosDisponibles tbody').empty();
		$('#ModulosAsignados tbody').empty();
		CleanChanges();
		
		if($("#TabModulos .TabLoader").length < 0);
			$("#TabModulos").append(HTMLLoader);
		
		var IDImage = (id ? id : -1);	
		var IDSlider = $("#IDSlider").val();
		
		if(ajax_request) ajax_request.abort();
		
		ajax_request = $.ajax({
			url:"<?php echo GetURL("modulos/modadminslider/serviceadminslider.php?accion=5")?>",
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
									
			$("#TabModulos").find('.TabLoader').remove();
			$(".modaldata").fadeIn();
			$('.modal-content').scrollTop(1);			
		});
		
		ajax_request.fail(function(AjaxObject)
		{
            Materialize.toast('<i class="material-icons left">error_outline</i>Error al obtener modulos del perfil.', 3000,"red");
			console.error("JSON-Error->LoadModulos(): "+AjaxObject.responseText);
		});		
	}
		
    function agregarmod(idmodulo){
        var tr=$("#mod_"+idmodulo),
            tbody = $('#ModulosAsignados tbody');
        
		//Checks if it's already marked for deletion
		if(!CheckForChanges(idmodulo,1,true) && Changes[0].indexOf(idmodulo) == -1)
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
			
		if(!CheckForChanges(idmodulo,0,true) && Changes[1].indexOf(idmodulo) == -1)
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