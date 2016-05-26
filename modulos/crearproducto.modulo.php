



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
		echo "producto no encontrado";
		return;
	}
	
	$idproducto = URLParam(2);	
    //echo $idproducto;
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	
		
	//Get proyect info

    
     $stmt = $mysqli->select("productos",
                [
                    "[><]categoria_producto"=>"idcategoria",
                    "[><]proveedores"=>"idproveedor"
                    
                ],
                [
                    "productos.idproducto",
                    "productos.nombre",
                    "productos.descripcion",
                    "categoria_producto.nombre(Cnombre)",
                    "proveedores.nombre(Pnombre)"
                    
                ],
                [
                    "idproducto" => $idproducto            
                ]
                );
                
               
	if(!$stmt)
	{
		if($mysqli->error()[2] != "")
			echo "Error:".$mysqli->error()[2];
		
		return;
	}	



    
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
<input type="hidden" id="idproducto" value="<?php echo $idproducto ?>">
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
                                    "contenido" => "Editar producto"
                                ),
                                array
                                (
                                    "href" 		=> "javascript:eliminar('%id')",
                                    "icon" 		=> "",
                                    "contenido" => "Eliminar producto"
                                )
                            );		
                        }
                        echo 
                        "
                            <img id=".$idproducto." class=\"image-header\" style=\"width:100%;height:auto\" src=\"".GetProductImagePath($idproducto)."\">
                            <div style=\"font-size:2.3rem\" class=\"menu-panel white-text\">"
                                    .GetDropDownSettingsRow($idproducto,GetMenuArray())."
                            </div> 
                        ";
                        
                        $stmtImg = $mysqli->select("productos_img",
                        [
                            "[><]imagenes"=>"idimagen"                    
                        ],
                        [
                            "idimagen","ruta"                    
                        ],
                        [
                            "idproducto" => $idproducto,
                            "GROUP" => "idimagen"
                            //,"ORDER" => "orden ASC"
                        ]);   
            
                        
                    ?>   
                <input style="display:none" type = "file" id = "imagen" name = "imagen"/>
                <div class="description">
                    <h6 id="hope"class="white-text light" style=" display:none;margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $idproducto ?></h6>
                    <h5 id="sidename" class="white-text " style="overflow:hidden;margin:0px; padding-left:4%"><?php echo $stmt[0]["nombre"] ?></h5>
                    <h6 id="sideplace" class="white-text light" style="margin-top:2%; padding-left:4%;padding-bottom:1%"><span id="TotalImgs"><?php echo count($stmtImg) ?></span> <?php echo ( (count($stmtImg) > 1 ) ? "imágenes" : "imagen") . " en este producto" ?></h6>
                    <ul id="CoverThumbnails" style="padding-left:4%;list-style-type: none; margin: auto;">                    
                    <?php
                        foreach ($stmtImg as $key => $row)                         
                        {
                            echo '<li id="CImg_'.$row["idimagen"].'" style="opacity:0;"><img src="'.$row["ruta"].'" class="circle"></li>';    
                        }                    
                    ?>
                    </ul>
                    <h6 id="sidecontent" class="white-text medium" style="margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $stmt[0]["descripcion"] ?></h6>
                    <h6 id="sidecategoria" class="white-text medium" style="margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $stmt[0]["Cnombre"] ?></h6>
                    <h6 id="sideproveedor" class="white-text medium" style="margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $stmt[0]["Pnombre"] ?></h6>
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
                <a id="crearproducto" onclick="ItemModal()" data-target="frmagregar" class="btn-floating btn-large blue-grey darken-2 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Agregar imagen">
                                <i class="large material-icons">add</i>
                </a>                 
            </div> 
        </div>
    </div>
</div>


<!-------------------------------------------- MODAL AGREGAR IMAGEN AL producto ------------------------------->
 <div id="modalFrmAdd" class="modal modal-fixed-footer custom-item">
        <div id="top-content" class="modal-content">            
            <h5 class="light">Agregar una imagen</h5>
            <div id="contentUploads">				
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
                    <div id="imgpreview-loader"></div>
                        <span class="right grey-text">Tamaño maximo: <?php echo ini_get('upload_max_filesize') ?></span>
                        <input id="InitImage" type="hidden" value="">
                    <div id="ColImgs" class="collection" style="border-style: none;"></div>
                    <div class="input-field col s12">
                        <input id="img-title" length="50" name="img-title" type="text" class="validate"> 
                        <label for="img-title">Título de la imagen</label>
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
<!-------------------------------------------- MODAL AGREGAR IMAGEN AL producto ------------------------------->


<!-------------------------------------------- MODAL EDITAR INFO producto ------------------------------------->
<div    id="custom-producto" class="modal modal-fixed-footer custom-item">
    <div class="modal-content no-padding">
        <form id="frmcustomproyect" autocomplete="off" method="POST" enctype="multipart/form-data" action="javascript:editar()">
            <a class="" action="">
            <div id="proyectimg" class="card-image">
                <?php               
                    echo "<img id=\"Proyect-Image\" class=\"image-header\" style=\"height:auto;width:100%\" src=\"".GetProductImagePath($idproducto)."\">";
                ?>
                <input style="display:none" type="file" name="imagen-producto" id="FileInput2" accept=".png,.jpg"/>
            </div>           
            <span><a id="" onclick="$('#proyectimg').find('#FileInput2').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
            </a>
            <div class="description">
                <div class="row card-content">   
                                
                    <div class="input-field col s12">
                        <input id="nombre-producto" length="50" name="nombre-producto" type="text" class="validate" required value="<?php echo $stmt[0]["nombre"] ?>"> 
                        <label for="nombre-producto">Producto</label>
                    </div>
                    <div class="input-field col s12">
                         <input type="hidden" id="idproducto" value="<?php echo $idproducto ?>">
                        <textarea id="descripcion-producto" name="descripcion-producto" length="750" class="materialize-textarea"><?php echo $stmt[0]["descripcion"] ?></textarea>
                        <label for="descripcion-producto">Descripcion</label>
                    </div> 
                    <div class="input-field col s12">
						<!-- <i class="material-icons prefix">assignment_ind</i> -->	
                        <select id="categoria-producto" name="categoria-producto" required>
                            <option value="" href="" disabled selected>Elija la categoria</option>
                            <?php
                            
                                $stmt = $mysqli->select("categoria_producto",
                                [
                                    "idcategoria","nombre"
                                ]);
                                
                                if($stmt)
                                {
                                    foreach($stmt as $row)
                                        echo '<option value="'.$row["idcategoria"].'">'.$row["nombre"].'</option>';
                                }
                                                                          					
                            ?>				
                        </select>
                        <label for="categoria-producto">Categorias</label>
				    	</div>
						
						<div class="input-field col s12">
						<!--<i class="material-icons prefix">assignment_ind</i> -->	
                        <select id="proveedor-producto" name="proveedor-producto" required> 
                            <option value="" href="" disabled selected>Elija el Proveedor</option>
                            <?php
                            
                                $stmt = $mysqli->select("proveedores",
                                [
                                    "idproveedor","nombre"
                                ]);
                                
                                if($stmt)
                                {
                                    foreach($stmt as $row)
                                        echo '<option value="'.$row["idproveedor"].'">'.$row["nombre"].'</option>';
                                }
                                                                          					
                            ?>				
                        </select>
                        <label for="proveedor-producto">Proveedores</label>
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
<!-------------------------------------------- MODAL EDITAR INFO producto ------------------------------------->


<script>
    
    Materialize.showStaggeredList("#CoverThumbnails");

   
   
    $(document).ready(function(){
        
         $("#FileInput").change(handleFileSelect);
        //UPDATE INPUTS
        Materialize.updateTextFields();        
        
        
        //GET DATA
        IDproducto = $("#hope").text();
        $("#img-loader").append(HTMLLoader);

        ajax_request = $.ajax({
		url:"<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=1") ?>",
		method: "POST",
		data: {IDproducto:IDproducto}		
        }).done(
            function(data){
                $("#project-list").append(data);	
                $("#img-loader").hide();
                Materialize.showStaggeredList("#project-list");
            }
        );
    });

    //FOR IMAGE PREVIEW
    function readURL(input) 
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#proyect-img').attr('src', e.target.result);
                    //$('#proyect-img').show();
                }
                                        
                reader.readAsDataURL(input.files[0]);
            }
        }
    
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
            $("#img-title").val( $("#IMG_"+id).find('.card-title').text() );
            $("#guardar").text('Editar');
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
    
     //Check for filezise
    function handleFileSelect(evt) 
    {
      var files = evt.target.files; // FileList object
      var max_size = $("#maxsize").val(); // Max file size

      // files is a FileList of File objects. List some properties.
      var output = [];
      for (var i = 0, f; f = files[i]; i++) 
      {
        //console.log("FileSize->"+f.size);
        if(f.size > max_size) 
        { // Check if file size is larger than max_size
          //Reset preview
          $("#modalFrmAdd").find("img").attr('src',$("#InitImage").attr('src'));
          //Clear input:file
          $(this).val('');
          //Notify          
          alert("Error: La imagen sobrepasa el tamaño maximo.\nTamaño maximo: " + bytesToSize(max_size) + ".\nTamaño de su imagen: "+bytesToSize(f.size));          
          return false;
        }
      }
      
      //Set preview.
      readURL(this);
    }
    
    function Agregar2()
    {
        var formData = new FormData($('#frmUpload')[0]);
        
        formData.append("idproducto",$("#idproducto").val());
       
        ShowLoadingSwal();
        
        $.ajax({
                url: "<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=2")?>",
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
            swal.close();
        });		      
    } 
    
    //OPEN EDIT MODAL
    function OpenModal(idproducto)
    { 	
          if(!idproducto){
              //
          }
          else{
              $( "#update-yes" ).unbind('click').click(function() {
                    editar(idproducto);							
               });
              }
              
        $( "#update-no" ).click(function(){ 
            $("#custom-producto").closeModal();                                
           // location.href= "crearproducto/"+idproducto; 						
        });
        
        $('#custom-producto').openModal({
            complete: function() { 
                document.getElementById("custom-producto").reset();                                
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
           url:"<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=3")?>",
            method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false            
        }).done(function(data){
            
            Materialize.toast('Guardando...', 3000);
            $("#custom-producto").closeModal();
                 
               
                    
        });
    }
    
    
	
	function DeleteImage2(id)
    {
        var idproducto = $("#idproducto").val();
               
        ConfirmDelete("Borrar imagen","¿Esta seguro de borrar la imagen?","",
        function()
        {
            //Show loading animation
            ShowLoadingSwal();        
            
            $.ajax({
                url:"<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=11")?>",
                method: "POST",
                data: {idproducto:idproducto,IDImagen:id}
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
                                        
                    swal("Borrado", "Se borro exitosamente.", "success");
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
        
        formData.append("idproducto",$("#idproducto").val());
        formData.append("IDImagen",id);        
        
        //Show loading animation
        ShowLoadingSwal();
        
        $.ajax({
                url: "<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=14")?>",
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
    
    function eliminar(idproducto){        
        ConfirmDelete("Borrar Producto","Esta seguro que quiere eliminar este producto","Seguro?",
        function(){
            $.ajax({
				    url:"<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=4") ?>",
				    method: "POST",
				    data: {idproducto:idproducto}
			    }).done(function(data){
                            if(data=="0"){
                                location.href="../adminproductos"
                            }
                            else{
                                alert(data);
                            }
                        }
                    );
        }
        );   
    } 	
</script>
