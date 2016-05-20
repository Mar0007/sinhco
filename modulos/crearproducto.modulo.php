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
                    ?>   
                <input style="display:none" type = "file" id = "imagen" name = "imagen"/>
                <div class="description">
                    <h6 id="hope"class="white-text light" style=" display:none;margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $idproducto ?></h6>
                    <h5 id="sidename" class="white-text " style="overflow:hidden;margin:0px; padding-left:4%"><?php echo $stmt[0]["nombre"] ?></h5>
                    
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
                <a id="crearproducto" onclick="ModalAdd()" data-target="frmagregar" class="btn-floating btn-large blue-grey darken-2 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Agregar imagen">
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
                    <div id="img-preview">
                        <img id="proyect-img" style="width:100%;object-fit:cover; height:220px;" class="responsive-img" ></img>
                    </div>
                    <div id="imgpreview-loader"></div>
                    <div id="ColImgs" class="collection" style="border-style: none;">
                    </div>
                    <div class="input-field col s12">
                        <input id="img-title" length="50" name="img-title" type="text" class="validate"> 
                        <label for="img-title">Título de la imagen</label>
                    </div>
                    <div class="input-field col s12 top-content-text">
                        <textarea id="img-descripcion" name="img-descripcion" length= "140" placeholder="Descripción de la imagen" style="max-height:120px" id="proveedor-producto" class="materialize-textarea"></textarea>
                    </div> 
                    <div class="file-field" style="display:none">
                        <div class="btn waves-effect waves-light blue darken">                            
                            <span><i class="material-icons left">camera_alt</i>Buscar</span>
                            <input id="FileInput" name="file" type="file" accept=".jpg,.png">
                        </div>
                    </div>
                    <div id="img-preview">
                <img id="proyect-img" style="width:100%;height:auto" class="responsive-img" ></img>
            </div>
            <div id="imgpreview-loader"></div>
            <div id="ColImgs" class="collection" style="border-style: none;">
            </div>
                </form>
                <button id="btnUpload" style="display:none" onclick="AgregarImagen()">
                                <i class="material-icons">file_upload</i>                            
                </button>
            </div>
            
        </div>
       
        <div id="botones" class="" style="position:absolute; bottom:10%; padding-bottom:25%">
            <a id="input-img" style="bottom:10%;position:absolute" onclick="$('#frmUpload').find('#FileInput').click();" class="btn-floating btn-large transparent z-depth-0 waves-effect waves-circle">
                <i class="material-icons grey-text">camera_alt</i>
            </a> 
            <div style="position:initial;margin-left:50px">
                <a id="input-img" style="bottom:10%;position:absolute; padding-right:5%" onclick="$('#contentUploads').find('#btnUpload').click();" class="btn-floating btn-large transparent z-depth-0 waves-effect waves-circle">
                <i class="material-icons grey-text">file_upload</i>
            </a> 
            </div>
        </div>
        
        <div class="modal-footer">
            <a id="guardar" onclick="AgregarImagen()" class="btn blue darken-1 waves-effect ">Agregar<i class="material-icons right"></i></a>
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
                <input type="hidden" id="id-producto" name="idproducto" required value="<?php echo $idproducto ?>">
            </a>
            <div class="description">
                <div class="row card-content">               
                    <div class="input-field col s12">
                        <input id="nombre-producto" length="50" name="nombre-producto" type="text" class="validate" required value="<?php echo $stmt[0]["nombre"] ?>"> 
                        <label for="nombre-producto">Producto</label>
                    </div>
                    <div class="input-field col s12">
                         
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

<!-------------------------------------------- Confirm Delete Modal ------------------------------------------->
    <div id="confirmar-eliminar" class="modal">
        <div class="modal-content">
            <h4>Borrar el producto</h4>
            <p class="flow-text">Si borras un producto, esta acción no se puede deshacer. </p>
            <p>
              <input type="checkbox" id="chkbx-confirmar"/>
              <label for="chkbx-confirmar">Si borras un producto, también se borran todas sus fotos.</label>
            </p>
        </div>
        <div class="modal-footer">
            <button type="submit" value="SI" id="delete-yes"  class="disabled modal-action modal-close btn-flat waves-effect waves-light">borrar</button>
            <button type="submit" value="NO" id="delete-no"  class=" modal-action modal-close btn-flat waves-effect waves-light">cancelar</button>
        </div>        
    </div>
<!-------------------------------------------- Confirm Delete Modal ------------------------------------------->

<!-------------------------------------------- Confirm Delete ITEM Modal ------------------------------------------->
    <div id="eliminar-item" class="modal delete-item">
        <div class="modal-content">
            <h5>Eliminar foto</h5>
            <p class="">¿Estás seguro de que quieres borrar la foto?</p>            
        </div>
        <div class="modal-footer">
            <button type="submit" value="SI" id="delete-img-yes"  class="disabled modal-action modal-close btn-flat waves-effect blue-text text-darken-2 waves-light">eliminar</button>
            <button type="submit" value="NO" id="delete-img-no"  class=" modal-action modal-close btn-flat waves-effect waves-light">cancelar</button>
        </div>        
    </div>
<!-------------------------------------------- Confirm Delete ITEM Modal ------------------------------------------->


<script>

    $('input:checkbox').change(function(){
    if($(this).is(":checked")) {
        $('#delete-yes').removeClass("disabled");
    } else {
        $('#delete-yes').addClass("disabled");
    }
});
   
    $(document).ready(function(){
        
        
        //UPDATE INPUTS
        Materialize.updateTextFields();        
        
        //FOR IMAGE PREVIEW
      function readURL(input) 
        {
            if (input.files && input.files[0]) {
                var reader1 = new FileReader();
                var reader2 = new FileReader();

                reader1.onload = function (e) {
                    $('#proyect-img').attr('src', e.target.result);

                }
                 reader2.onload = function (e) {
                    $('#Proyect-Image').attr('src', e.target.result);

                }

                reader1.readAsDataURL(input.files[0]);
                reader2.readAsDataURL(input.files[0]);
            }
        }
        $("#FileInput").change(function(){
              readURL(this);
        });
         $("#FileInput2").change(function(){
              readURL(this);
        });
        
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
      
    var HTMLLoader = 
  "<div class=\"col s12 center TabLoader\" style=\"margin-top: 10%\">" +
  "<div class=\"preloader-wrapper active\">"+
  "<div class=\"spinner-layer spinner-blue-only\">"+
  "<div class=\"circle-clipper left\">"+
  "<div class=\"circle\"></div>"+
  "</div><div class=\"gap-patch\">"+
  "<div class=\"circle\"></div>"+
  "</div><div class=\"circle-clipper right\">"+
  "<div class=\"circle\"></div>"+
  "</div></div></div></div>";
    
    function Agregar(){		
        IDImagen = $(".uploaded-img").attr('value');
        IDproducto = $("#hope").text();                


        $.ajax({
            url:"<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=13")?>",
            method: "POST",
            data: {IDImagen:IDImagen,IDproducto:IDproducto}                   
        }).done(function(data){
            $("#modalFrmAdd").closeModal();		
            if(data.indexOf("<li") > -1)
            {			
                 $("#project-list").prepend(data);
                  $("#frmUpload").trigger("reset");
                $('#proyect-img').removeAttr('src');
                    $("#img-preview").show();
            }
            
        });					 
   }

    function editar (idproducto){        
        
                 
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
                 
               // Materialize.toast('Se guardó el producto.', 3000);
            /*  
                var cells = $(".description").children();
                cells[1].innerText= $("#nombre-producto").val();    
                cells[2].innerText= $("#descripcion-producto").val()+' - '+$("#categoria-producto").val();
                cells[3].innerText= $("#proveedor-producto").val();       
              */
               
                    
        });
    }
    
    function AgregarImagen()
	{
     
		
		$("#img-preview").hide();
        $("#imgpreview-loader").append(HTMLLoader);
        
		var formData = new FormData($('#frmUpload')[0]);
        
		$.ajax({
				url: "<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=10")?>",
				type: "POST",
				data: new FormData($(frmUpload)[0]),
				contentType: false,
				cache: false,
				processData:false
		}).done(function(data){
			if(data.indexOf("<a") > -1)
			{
				
                //$("#TabImg").find('.TabLoader').remove();
                $("#ColImgs").hide();
				$('#ColImgs').append(data);
                 $("#imgpreview-loader").hide();
				$('.collection-item').unbind('click').click(function()
				{
					$(".collection-item").not(this).removeClass("active");
					$(this).toggleClass("active");
				});	
                
				//$("#frmUpload").trigger('reset');
//               $("#imgpreview-loader").hide();
				//$("#ColImgs").show();
				//$("#img-preview").hide();
				Materialize.toast('Imagen cargada', 3000);  
                Agregar();
                var cells2 = $("#img-preview").children();
                var cells = $(".image-header").setAttribute('src',(cells2[0].getAttribute('src')));
                 
                
			}
            
			else
				swal("Error", data, "error");
		});		
	}
	
	function DeleteImage(id)
	{
        
        $("#eliminar-item").openModal();	
        
        $( "#delete-img-yes" ).click(function() {

				$.ajax({
					url:"<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=11") ?>",
					method: "POST",
					data: {IDImagen:id}
				}).done(function(IDImagen){
					
					
						$("#IMG_"+ IDImagen).fadeOut(function(){
							$(this).remove();                            
						});		
                        
						Materialize.toast("Image eliminada", 3000);                
					
					
						
				});	
            });
        $( "#delete-img-no" ).click(function() {
                 $("#eliminar-item").closeModal();
        });
		}		  		
	
		
    
    function eliminar(idproducto){              
        $("#confirmar-eliminar").openModal();
        $( "#delete-yes" ).click(function() {
                $.ajax({
				    url:"<?php echo GetURL("modulos/modcrearproductos/servicecrearproducto.php?accion=4") ?>",
				    method: "POST",
				    data: {idproducto:idproducto}
			    }).done(function(data){
                            if(data=="0"){
                                //location.href="dashboard/adminproductos"
                            }
                            else{
                                alert(data);
                            }
                        }
                    );
  
});
        $( "#delete-no" ).click(function() {
                 $("#confirmar-eliminar").closeModal();
        });
   
       
    } 
     
	
</script>
