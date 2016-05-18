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
                            <img id=".$idproyecto." class=\"image-header\" style=\"width:100%;height:auto\" src=\"".GetProyectImagePath($idproyecto)."\">
                            <div style=\"font-size:2.3rem\" class=\"menu-panel white-text\">"
                                    .GetDropDownSettingsRow($idproyecto,GetMenuArray())."
                            </div> 
                        ";
                    ?>   
                <input style="display:none" type = "file" id = "imagen" name = "imagen"/>
                <div class="description">
                    <h6 id="hope"class="white-text light" style=" display:none;margin-top:4%; padding-left:4%;padding-bottom:1%"><?php echo $idproyecto ?></h6>
                    <h5 id="sidename" class="white-text " style="overflow:hidden;margin:0px; padding-left:4%"><?php echo $stmt[0]["nombre"] ?></h5>
                    <h6 id="sideplace" class="white-text light" style="margin-top:2%; padding-left:4%;padding-bottom:1%"><?php echo $stmt[0]["lugar"] ?> - <?php echo date("j F Y", $date) ?> </h6>
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
                <a id="crearProyecto" onclick="ModalAdd()" data-target="frmagregar" class="btn-floating btn-large blue-grey darken-2 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Agregar imagen">
                                <i class="large material-icons">add</i>
                </a>                 
            </div> 
        </div>
    </div>
</div>


<!-------------------------------------------- MODAL AGREGAR IMAGEN AL PROYECTO ------------------------------->
 <div id="modalFrmAdd" class="modal modal-fixed-footer custom-item">
        <div id="top-content" class="modal-content">            
            <h5 class="light">Agregar una imagen</h5>
            <div id="contentUploads">				
                <form id="frmUpload" method="post" enctype="multipart/form-data" style="max-height:120px">
                    <div id="img-preview">
                        <img id="proyect-img" style="width:100%;height:auto" class="responsive-img" ></img>
                    </div>
                    <div id="imgpreview-loader"></div>
                    <div id="ColImgs" class="collection" style="border-style: none;">
                    </div>
                    <div class="input-field col s12">
                        <input id="img-title" length="50" name="img-title" type="text" class="validate"> 
                        <label for="img-title">Título de la imagen</label>
                    </div>
                    <div class="input-field col s12 top-content-text">
                        <textarea id="img-descripcion" name="img-descripcion" length= "140" placeholder="Descripción de la imagen" style="max-height:120px" id="contenido-proyecto" class="materialize-textarea"></textarea>
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
                <input style="display:none" type="file" name="imagen-proyecto" id="FileInput" accept=".png,.jpg"/>
            </div>           
            <span><a id="" onclick="$('#proyectimg').find('#FileInput').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
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

<!-------------------------------------------- Confirm Delete Modal ------------------------------------------->
    <div id="confirmar-eliminar" class="modal">
        <div class="modal-content">
            <h4>Borrar el proyecto</h4>
            <p class="flow-text">Si borras un proyecto, esta acción no se puede deshacer. </p>
            <p>
              <input type="checkbox" id="chkbx-confirmar"/>
              <label for="chkbx-confirmar">Si borras un proyecto, también se borran todas sus fotos.</label>
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
        //INITIALIZE DATEPICKER
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd'    
        });
        
        //UPDATE INPUTS
        Materialize.updateTextFields();        
        
        //FOR IMAGE PREVIEW
        function readURL(input) 
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#proyect-img').attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#FileInput").change(function(){
              readURL(this);
        });
        
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
        $('#custom-proyecto').openModal();	
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
        IDProyecto = $("#hope").text();                


        $.ajax({
            url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=13")?>",
            method: "POST",
            data: {IDImagen:IDImagen,IDProyecto:IDProyecto}                   
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

    function editar (idproyecto){        
        
                 
        var formData = new FormData($('#frmcustomproyect')[0]);
        
        $.ajax({
           url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=3")?>",
            method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false            
        }).done(function(data){
            Materialize.toast('Guardando...', 3000);
            $("#custom-proyecto").closeModal();
            if(data.indexOf("<") > -1){                
               // Materialize.toast('Se guardó el proyecto.', 3000);
                          
            }
			
        });
    }
    
    function AgregarImagen()
	{
     
		
		$("#img-preview").hide();
        $("#imgpreview-loader").append(HTMLLoader);
        
		var formData = new FormData($('#frmUpload')[0]);
        
		$.ajax({
				url: "<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=10")?>",
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
					url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=11") ?>",
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
	
		
    
    function eliminar(idproyecto){              
        $("#confirmar-eliminar").openModal();
        
        $( "#delete-yes" ).click(function() {
                $.ajax({
				    url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=4") ?>",
				    method: "POST",
				    data: {idproyecto:idproyecto}
			    }).done(function(data){
                            if(data=="0"){
                                
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
