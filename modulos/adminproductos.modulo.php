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

<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Productos</h3>
            <p class="center light">Cree y organice los productos.</p>            
        </div>
        <!--END Module Title-->
        
        <!--Module Data-->
        <div class="">
            <ul id="productocard" class="fixed-drop no-margin"></ul>
        </div>
        <!--END Module Data-->
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="crearproducto" onclick="mostrarfrmagregar()" data-target="frmagregar" class="btn-floating btn-large blue-grey darken-2 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Nuevo producto">
                <i class="large material-icons">add</i>
            </a>               
        </div>
        <!--END Module Action Button-->
    </div>
</div>

<!--CREATE PROYECT MODAL-->
<div id="nuevo-producto" class="modal create-item">
    <div class="modal-content">
        <h5>Crear un Producto</h5>
        
        <form id="frmnewproyect" autocomplete="off" >
            <div class="row card-content">               
                <div class="input-field col s12">
                    <input id="Nombre" name="Nombre" type="text" class="validate" length ="50">
                    <label for="Nombre">Nombre</label>
                </div>
                <div class="input-field col s12">
                    <input id="Descripcion" name="Descripcion" type="text" class="validate" length="750">
                    <label for="Descripcion">Descripcion</label>
                </div>               
                
            </div>           
        </form>       
        
    </div>
    
    <div class="modal-footer">
        <a id="guardar" onclick="javascript:OpenModal()"  class="disabled modal-action  btn-flat  waves-effect waves-light">Crear</a>
        
        <a id="cancel" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div>        

</div>
<!--END CREATE PROYECT MODAL-->

<!-------------------------------------------- MODAL EDITAR INFO producto ------------------------------------->
<div    id="custom-producto" class="modal modal-fixed-footer custom-item">
    <div class="modal-content no-padding">
        <form id="frmcustomproducto" autocomplete="off" method="POST" enctype="multipart/form-data" action="javascript:CrearProducto()">
            <a class="" action="">
            <div id="proyectimg" class="card-image">
                <?php               
                    echo "<img id=\"Proyect-Image\" class=\"image-header\" style=\"height:auto;width:100%\" src=\"".GetProductImagePath(0)."\">";
                ?>
                <input style="display:none" type="file" name="imagen" id="FileInput" accept=".png,.jpg"/>
            </div>           
            <span><a id="" onclick="$('#proyectimg').find('#FileInput').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
                <input type="hidden" id="id-producto" name="idproducto">
            </a>
            <div class="description">
                <div class="row card-content">               
                    <div class="input-field col s12">
                        <input id="nombre-producto" length="50" name="nombre-producto" type="text" class="validate" > 
                        <label for="nombre-producto">Producto</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="descripcion-producto" length="750" name="descripcion-producto" type="text" class="validate"  >
                        <label for="descripcion-producto">Descripcion</label>
                    </div>
			
                    <div class="input-field col s12">
						<!-- <i class="material-icons prefix">assignment_ind</i> -->	
                        <select id="categoria-producto" name="categoria-producto">
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
                        <select id="proveedores-producto" name="proveedores-producto">
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
                        <label for="proveedores-producto">Proveedores</label>
				    	</div>
                    <input  type="submit" style="display:none">
                </div> 
            </div>
        </form>       
    </div>
    <div class="modal-footer">
           <a id="update-yes" onclick="$('#frmcustomproducto').find(':submit').click();" class="btn-flat blue-text text-darken-1 waves-effect ">Salvar<i class="material-icons right"></i></a>
           <a id="update-no"  class="btn-flat modal-action modal-close  waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
        </div>        
</div>
<!-------------------------------------------- MODAL EDITAR INFO producto ------------------------------------->

    

<script>
 
 $(document).ready(function(){
      $('.slider').slider({full_width: true});
	   $('select').material_select();
        $.ajax({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=1") ?>"
		}).done(
			function(data){
				$("#productocard").append(data);
				
			}
		);
		
		 //FOR IMAGE PREVIEW
        function readURL(input) 
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#Proyect-Image').attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#FileInput").change(function(){
              readURL(this);
        });
		
		 //toggle submit button in modal
         $('#Nombre').keyup(function() {

            var empty = false;
            $('#Nombre').each(function() {
                if ($(this).val().length == 0) {
                    empty = true;
                }
            });

            if (empty) {
                $('#guardar').addClass("disabled");
                $('#guardar').removeClass("modal-close");
                $('#guardar').removeClass("blue-text");
              
            } else {
                $('#guardar').removeClass("disabled");
                $('#guardar').addClass("modal-close");
                $('#guardar').addClass("blue-text");
             
            }
        });
        
        //end toggle
		
    }); 
    

  
function CrearProducto (){
        var formData = new FormData($('#frmcustomproducto')[0]);
        
             $.ajax({
                url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=2") ?>",
                method: 'POST',
                data:formData,
                cache: false,
                contentType: false,
                processData: false
              }).done(function(last_id){                 
                 Materialize.toast('Creando el producto...', 3000);
                 $("#custom-producto").closeModal();
                 if(last_id != "0"){
                   location.href= "crearproducto/"+last_id;
                 }
                 else{
                     Materialize.toast('Hubo un error al crear el producto...', 3000);
                 }
                                      
              });
    } //end creating
	
	//Opening new Proyect modal
function mostrarfrmagregar (){
        document.getElementById("frmnewproyect").reset();                
        Materialize.updateTextFields(); 
        $('#guardar').addClass("disabled");
        $('#guardar').removeClass("modal-close");
        $('#guardar').removeClass("blue-text");
        
        $("#nuevo-producto").openModal({                    
            complete: function() { 
                document.getElementById("frmnewproyect").reset();                
                Materialize.updateTextFields();  
                $('#guardar').addClass("disabled");
                $('#guardar').removeClass("modal-close");
                $('#guardar').removeClass("blue-text");
            }
        });
    }
    
 //Open edit modal
 function OpenModal()
    { 	
        $("#nuevo-producto").closeModal(); 
        
        
        $( "#update-no" ).click(function() {
           $("#custom-producto").closeModal();						
        });
        
         $('#custom-producto').openModal({
            dismissible: false,
            ready: function() {
               $("#nombre-producto").val($("#Nombre").val());
               $("#descripcion-producto").val($("#Descripcion").val());
                Materialize.updateTextFields();
            },
            complete: function() { 
                document.getElementById("custom-producto").reset(); 
                document.getElementById("frmnewproyect").reset();                
                Materialize.updateTextFields();                      
            }
        });
    }
     

</script>