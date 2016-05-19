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
            "nombre","descripcion"
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
        $('#custom-producto').openModal();	
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
            url:"<?php echo GetURL("modulos/modcrearproducto/servicecrearproducto.php?accion=13")?>",
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
           url:"<?php echo GetURL("modulos/modcrearproducto/servicecrearproducto.php?accion=3")?>",
            method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false            
        }).done(function(data){
            
            Materialize.toast('Guardando...', 3000);
            $("#custom-producto").closeModal();
                 
               // Materialize.toast('Se guardó el producto.', 3000);
              
                var cells = $(".description").children();
                cells[1].innerText= $("#nombre-producto").val();    
                cells[2].innerText= $("#descripcion-producto").val()+' - '+$("#fecha-producto").val();
                cells[3].innerText= $("#contenido-producto").val();       
                
               
                    
        });
    }
    
    function AgregarImagen()
	{
     
		
		$("#img-preview").hide();
        $("#imgpreview-loader").append(HTMLLoader);
        
		var formData = new FormData($('#frmUpload')[0]);
        
		$.ajax({
				url: "<?php echo GetURL("modulos/modcrearproducto/servicecrearproducto.php?accion=10")?>",
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
					url:"<?php echo GetURL("modulos/modcrearproducto/servicecrearproducto.php?accion=11") ?>",
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
				    url:"<?php echo GetURL("modulos/modcrearproducto/servicecrearproducto.php?accion=4") ?>",
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
