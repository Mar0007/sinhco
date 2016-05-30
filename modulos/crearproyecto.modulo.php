<?php
	global $mysqli;	
	global $OnDashboard;
	
	if($OnDashboard != 1 || !login_check($mysqli))
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}
		
	if( !URLParam(2) )
	{
		echo "Proyecto no encontrado";
		return;
	}
	
	$idproyecto = URLParam(2);	
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	
		
	//Get proyect info
	$stmt = $mysqli->select("proyectos",
		[
            "nombre","lugar","contenido", "fecha"
        ],
		[
            "idproyecto" => $idproyecto            
        ]
                            
	);
    $date = strtotime($stmt[0]["fecha"]);

	if(!$stmt)
	{
		if($mysqli->error()[2] != "")
			echo "Error:".$mysqli->error()[2];
		
		return;
	}	
?>	

    <input type="hidden" id="maxsize" value="<?php echo parse_size(ini_get('upload_max_filesize')) ?>">
    <div class="sidebar-left blue darken-2  ">
        <div class="no-padding" style="">
            <div class="" style="height:100%;position:relative">            
               <div id="profile-header" class="content" >
                   <?php
                       function GetMenuArray()
                        {
                            //Datarow menu
                            return array(
                                array
                                (
                                    "href" 		=> "javascript:OpenModal('%id')",
                                    "icon" 		=> "",
                                    "contenido" => "Editar proyecto"
                                ),
                                array
                                (
                                    "href" 		=> "javascript:eliminar('%id')",
                                    "icon" 		=> "",
                                    "contenido" => "Eliminar proyecto"
                                )
                            );		
                        }
                        echo 
                        "
                            <img id=".$idproyecto." class=\"image-header\" style=\"width:100%;\" src=\"".GetProyectImagePath($idproyecto)."\">
                            <div style=\"font-size:2.3rem\" class=\"menu-panel white-text\">"
                                    .GetDropDownSettingsRow($idproyecto,GetMenuArray())."
                            </div> 
                        ";
                        
                        setlocale(LC_ALL,"es_ES");
                    ?>   
                <input style="display:none" type = "file" id = "imagen" name = "imagen"/>
                <div class="description">
                    <h6 id="hope"class="white-text light" style=" display:none;margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $idproyecto ?></h6>
                    <h5 id="sidename" class="white-text " style="overflow:hidden;margin:0px; padding-left:4%"><?php echo $stmt[0]["nombre"] ?></h5>
                    <h6 id="sideplace" class="white-text light" style="margin-top:2%; padding-left:4%;padding-bottom:1%"><?php echo $stmt[0]["lugar"] ?> - <?php echo date("F j, Y", $date) ?> </h6>
                    <h6 id="sidecontent" class="white-text medium" style="margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $stmt[0]["contenido"] ?></h6>
                </div>

                </div>
            </div>
        </div>
        
    </div>

<div class="" style="postion:relative">
    <div class="content-right" style="">
        <div class="row">
            <div class="">
                <ul id="project-list"></ul>
                <div id="img-loader"></div>
            </div>
            <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a id="crearProyecto" onclick="ItemModal()" data-target="frmagregar" class="btn-floating btn-large blue-grey darken-2 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Agregar imagen">
                                <i class="large material-icons">add</i>
                </a>                 
            </div> 
        </div>
    </div>
</div>


<!-------------------------------------------- MODAL AGREGAR IMAGEN AL PROYECTO ------------------------------->
 <div id="modalFrmAdd" class="modal modal-fixed-footer custom-item">
        <div id="top-content" class="modal-content">            
            <h5 id="modal-title" class="light">Agregar una imagen</h5>
            <div id="contentUploads">	
                <form id="frmUpload" method="post" enctype="multipart/form-data" style="max-height:120px">
                    <div style="position:relative">
                        <img id="proyect-img" src="<?php echo GetURL("uploads/covers/camerabg.png")?>" style="width:100%; object-fit:cover; height:220px;" class="responsive-img"></img>                    
                        <div class="input-secondary-menu circle">
                            <div class="input-secondary-menu circle btn-floating btn-small transparent z-depth-0 waves-effect waves-circle file-field input-field" style="position:absolute;right:2px;top:-17px">
                                <i class="material-icons white-text">camera_alt</i>
                                <input id="FileInput" required name="file" type="file" accept=".jpg,.png">
                            </div>                        
                        </div>
                    </div>
                    <div id="imgpreview-loader"></div>
                        <span class="right grey-text">Tamaño maximo: <?php echo ini_get('upload_max_filesize') ?></span>
                        <input id="InitImage" type="hidden" value="">
                    <div id="ColImgs" class="collection" style="border-style: none;"></div>
                   <div class="row">
                        <div class="input-field col s12">
                        <input id="img-title" length="50" name="img-title" type="text" class="validate"> 
                        <label for="img-title">Título de la imagen</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="img-descripcion" length="1440" name="img-descripcion" type="text" class="materialize-textarea validate" ></textarea>  
                        <label for="img-descripcion">Descripción de la imagen</label>
                    </div>
                </div>
                    <input type="submit" style="display:none">
                </form>            
            </div>
        </div>

        <div class="modal-footer">
            <a id="guardar" class="btn blue darken-1 waves-effect ">Agregar<i class="material-icons right"></i></a>
            <a id="cancel" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
        </div>        
</div>
<!-------------------------------------------- MODAL AGREGAR IMAGEN AL PROYECTO ------------------------------->


<!-------------------------------------------- MODAL EDITAR INFO PROYECTO ------------------------------------->
<div    id="custom-proyecto" class="modal modal-fixed-footer custom-item">
    <div class="modal-content no-padding">
        <form id="frmcustomproyect" autocomplete="off" method="POST" enctype="multipart/form-data" action="javascript:editar()">
            <a class="" action="">
            <div id="proyectimg" class="card-image">
                <?php               
                    echo "<img id=\"Proyect-Image\" class=\"image-header\" style=\"height:auto;width:100%\" src=\"".GetProyectImagePath($idproyecto)."\">";
                ?>
                <input style="display:none" type="file" name="imagen-proyecto" id="FileInput2" accept=".png,.jpg"/>
            </div>           
            <span><a id="" onclick="$('#proyectimg').find('#FileInput2').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
                <input type="hidden" id="id-proyecto" name="idproyecto" required value="<?php echo $idproyecto ?>">
            </a>
            <div class="description">
                <div class="row card-content">               
                    <div class="input-field col s12">
                        <input id="nombre-proyecto" length="50" name="nombre-proyecto" type="text" class="validate" required value="<?php echo $stmt[0]["nombre"] ?>"> 
                        <label for="nombre-proyecto">Proyecto</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="lugar-proyecto" length="25" name="lugar-proyecto" type="text" class="validate" required value="<?php echo $stmt[0]["lugar"] ?>" >     
                        <label for="lugar-proyecto">Lugar</label>
                    </div> 
                    <div class="input-field col s12">
                        <input id="fecha-proyecto" name="fecha-proyecto" type="date"  class=" datepicker validate" required value="<?php echo $stmt[0]["fecha"] ?>"  >
                        <label class="active" for="fecha-proyecto">Fecha</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="contenido-proyecto" name="contenido-proyecto" length="300" class="materialize-textarea"><?php echo $stmt[0]["contenido"] ?></textarea>
                        <label for="contenido-proyecto">Descripción</label>
                    </div> 
                    <input  type="submit" style="display:none">
                </div> 
            </div>
        </form>       
    </div>
    <div class="modal-footer">
           <a id="update-yes" onclick="$('#frmcustomproyect').find(':submit').click();" class="btn-flat blue-text text-darken-1 waves-effect ">Guardar<i class="material-icons right"></i></a>
           <a id="update-no"  class="btn-flat modal-action modal-close  waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
        </div>        
</div>
<!-------------------------------------------- MODAL EDITAR INFO PROYECTO ------------------------------------->




<script>

    $('input:checkbox').change(function(){
        if($(this).is(":checked")) {
            $('#delete-yes').removeClass("disabled");        
        } else {
            $('#delete-yes').addClass("disabled");        
        }
    });
   
    $(document).ready(function(){
        //INITIALIZE DATEPICKER
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd'    
        });
        
        $(":file").change(handleFileSelect);
        //UPDATE INPUTS
        Materialize.updateTextFields();        
        
        //GET DATA
        IDProyecto = $("#hope").text();
        $("#img-loader").append(HTMLLoader);

        ajax_request = $.ajax({
		url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=1") ?>",
		method: "POST",
		data: {IDProyecto:IDProyecto}		
        }).done(
            function(data){
                $("#project-list").append(data);	
                $("#img-loader").hide();
                Materialize.showStaggeredList("#project-list");
            }
        );
    });

    
     function ItemModal(id)
    {
        $("#modalFrmAdd").find("form").trigger("reset");
        if(!id)
        {
            $("#modalFrmAdd").find("img").attr('src','<?php echo GetURL("uploads/covers/camerabg.png")?>');
            $("#InitImage").attr('src','<?php echo GetURL("uploads/covers/camerabg.png")?>');
            $("#guardar").text('Agregar');
        }
        else 
        {
            $("#modalFrmAdd").find("img").attr('src', $("#IMG_"+id).find('img').attr('src') );
            $("#InitImage").attr('src',$("#IMG_"+id).find('img').attr('src'));
            $("#modal-title").text('Editar imagen');
            $("#img-title").val( $("#IMG_"+id).find('.card-title').text() );
            $("#img-descripcion").val( $("#IMG_"+id).find('.card-content').text() );
            $("#guardar").text('Guardar');
        }
        
        
        //Set Action on btnSaveDialog
        $("#guardar").unbind('click').click(function()
        {
            if (!$("#frmUpload")[0].checkValidity() && !id)
            {
                $("#frmUpload").find(':submit').click();
                Materialize.toast('La imagen es requerida.', 3000,"red");
                return;
            }			         
            
            if(!id)
            {
                Agregar2();
                return;
            }
            
            Editar2(id);                        
        });
        
       
        Materialize.updateTextFields();
        $("#modalFrmAdd").openModal();
                  
    }
	var ajax_request;	
    

    
    function Agregar2()
    {
        var formData = new FormData($('#frmUpload')[0]);
        
        formData.append("idproyecto",$("#hope").text());
       
        //ShowLoadingSwal();
        
        $.ajax({
                url: "<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=10")?>",
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
                $("#project-list").prepend(data);
                
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
                Materialize.toast('Error, no se pudo agregar la imagen.', 3000,"red");
                console.error("Error en Agregar()->"+data);
            }
            
            //Close loading swal.
          //  swal.close();
        });		      
    } 
    
    //OPEN EDIT MODAL
    function OpenModal(idproyecto)
    { 	
          if(!idproyecto){
              //
          }
          else{
              $( "#update-yes" ).unbind('click').click(function() {
                    editar(idproyecto);							
               });
              }
              
        $( "#update-no" ).click(function(){ 
            $("#custom-proyecto").closeModal();                                
           // location.href= "crearproducto/"+idproducto; 						
        });
        
        $('#custom-proyecto').openModal({
            complete: function() { 
                //document.getElementById("custom-proyecto").reset();                                
                Materialize.updateTextFields();                      
            }
        })
    }
    
    function ModalAdd(){
        $('#modalFrmAdd').openModal();
          
    }

    
   

    function editar(idproducto){        
        
                 
        var formData = new FormData($('#frmcustomproyect')[0]);
        
        $.ajax({
           url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=3")?>",
            method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false            
        }).done(function(data){
            if(data == "0")
            {
                $("#sidename").text($("#nombre-proyecto").val());
                $("#sidecontent").text($("#contenido-proyecto").val());
                
                var Lugar = $("#lugar-proyecto").val();
                var Fecha = CustomParseDate($("#fecha-proyecto").val());
                
                $("#sideplace").text(Lugar + " - " + Fecha);
                
                Materialize.toast('Guardado', 3000,"green");
                $("#custom-proyecto").closeModal();                                                                    
            }
            else
            {
                Materialize.toast('<i class="material-icons">highlight_off</i> Error al guardar', 4000,"red");
                console.error("Error->Editar():"+data);
            }                        
        });
    }
    
    
	
	function DeleteImage2(id)
    {
        var idproyecto = $("#idproyecto").val();
               
        ConfirmDelete("Borrar imagen","¿Está seguro de borrar la imagen?","",
        function()
        {
            //Show loading animation
            ShowLoadingSwal();        
            
            $.ajax({
                url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=11")?>",
                method: "POST",
                data: {idproyecto:idproyecto,IDImagen:id}
            }).done(function(data){
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
                                        
                   // swal("Borrado", "Se borro exitosamente.", "success");
                }
                else
                {
                    swal("Error", data, "error");
                    console.error("Error->"+data);
                }
            });            
        });
    }	
    
    
     function Editar2(id)
    {
        var formData = new FormData($('#frmUpload')[0]);
        
        formData.append("idproyecto",$("#hope").text());
        formData.append("IDImagen",id);        
        
        //Show loading animation
        ShowLoadingSwal();
        
        $.ajax({
                url: "<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=12")?>",
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
                Materialize.toast('Error, no se pudo editar la imagen.', 3000,"red");
                console.error("Error en Editar()->"+data);
            }
            
            //Close loading swal.
            swal.close();
        });		      
    }
    
    function eliminar(idproyecto){        
        ConfirmDelete("Borrar proyecto","¿Está seguro que quiere eliminar este proyecto?","",
        function(){
            $.ajax({
				    url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=4") ?>",
				    method: "POST",
				    data: {idproyecto:idproyecto}
			    }).done(function(data){
                            if(data=="0"){
                                location.href="../adminproyectos"
                            }
                            else{
                                //alert(data);
                            }
                        }
                    );
        }
        );   
    } 	
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
    
     
	
</script>
