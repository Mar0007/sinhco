<?php
	global $mysqli;
	global $OnDashboard;
	
	if($OnDashboard != 1 || !login_check($mysqli))
	{
		echo "<div class=\"row\">
                <div class=\"col s12 m12\">
                    <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                            <span class=\"card-title\">Warning!</span>
                                <p>Login in if you want to see this information. You have to be an administrator in order to make changes and/or visualize this information.</p>
                        </div>
                    <div class=\"card-action\">
                        <a class=\"modal-trigger\" href=\"#modal1\">Sign in</a>
                    </div>
                </div>
            </div>
        </div>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<div class=\"row\">
                <div class=\"col s12 m12\">
                    <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                            <span class=\"card-title\">Warning!</span>
                                <p>You need administration access to view this information.</p>
                        </div>
                    <div class=\"card-action\">
                        <a class=\"modal-trigger\" href=\"#\">Sign in</a>
                    </div>
                </div>
            </div>
        </div>";
		return;
	}    
    
?>

<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Servicios</h3>
            <p class="center light">Cree, edite y organice los servicios por categoria.</p>
            <div class="divider3"></div>
        </div>		
        
        <!--Module Data-->
        <ul id="datacontainer" class="fixed-drop no-margin" style="margin-bottom:100px">
		</ul>
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="btnCrear" class="btn-floating btn-large blue-grey darken-2 tooltipped"  onclick="OpenModal()" data-position="left" data-delay="50" data-tooltip="Crear servicio">
                <i class="large material-icons">mode_edit</i>
            </a>
        </div>   
    </div>
</div>

<!-- MODAL EDITAR/AGREGAR INFO Servicio -->
<div id="modalFrmAdd" class="modal modal-fixed-footer custom-item">
    <div class="modal-content no-padding">
        <form id="frmUpload" autocomplete="off" method="POST" enctype="multipart/form-data" action="javascript:CrearServicio()">
            <div id="service_img" class="card-image">
                <img id="service-img" src="<?php echo GetProyectImagePath(-1) ?>" style="width:100%; object-fit:cover; height:220px;" class="responsive-img">
                <input style="display:none" type="file" name="imagen" id="FileInput" accept=".png,.jpg"/>
            </div>           
            <span><a id="" onclick="$('#service_img').find('#FileInput').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
            <div class="description">
                <div class="row card-content">               
                    <div class="input-field col s12">
                        <input id="txtnombre" length="50" maxlength="50" name="nombre" type="text" class="validate" required> 
                        <label for="txtnombre">Servicio</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="txtcontenido" name="descripcion" maxlength="100" length="100" class="materialize-textarea" required></textarea>
                        <label for="txtcontenido">Descripción</label>
                    </div> 
                    <input  type="submit" style="display:none">
                </div> 
            </div>
        </form>       
    </div>
    <div class="modal-footer">
           <a id="update-yes" onclick="$(this).parents().find(':submit').click();" class="btn-flat blue-text text-darken-1 waves-effect ">Salvar<i class="material-icons right"></i></a>
           <a id="update-no"  class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div>        
</div>
<!-- MODAL EDITAR INFO Servicio -->


<script>
        
    $(document).ready(function(){  
                
        //IMAGE PREVIEW
        $(":file").change(handleFileSelect);
        //Get data
        GetAjaxData();                
        
    }); //end document ready

    var ajax_request;
    function GetAjaxData()
    {
        //Prevent parallel execution of ajax.
        if(ajax_request) ajax_request.abort();

        //Get data
        ajax_request = $.get("<?php echo GetURL("modulos/modadminservicios/serviceadminservicios.php?accion=1")?>");
                
        ajax_request.done
        (
            function(data)
            {
                $("#datacontainer").html(data);
                InitDropdown();
                $(".dataitems").fadeIn();
            }
        );			  
    }       

    function OpenModal(EditID)
    {
        var MID = "#modalFrmAdd";
        var Image = "<?php echo GetProyectImagePath(-1) ?>"
        var FrmAction = 'javascript:CrearServicio()';
        $(MID).find("form").trigger("reset");

        //Editar
        if(EditID)
        {
            var Card = $("#Card_" + EditID);
            //Set image
            Image = $(Card).find("img").attr('src');
            //Set nombre
            $("#txtnombre").val($.trim(Card.find(".card-title-small").text()));
            //Set Descripcion
            $("#txtcontenido").val($.trim(Card.find(".card-subtitle-small").text()));
            //Set Action
            FrmAction = 'javascript:EditarServicio('+EditID+')';
        }
        
        $(MID).find("form").attr('action',FrmAction);
        $("#service-img").attr('src',Image);
        $("#InitImage").attr('src',Image);

        //Fix inputs placeholder bug
        Materialize.updateTextFields();
        //Open modal
        $(MID).openModal();
        //Fix textarea materialize
        $(MID).find('textarea').trigger("keyup");
    }

    function CrearServicio()
    {
        var formData = new FormData($('#frmUpload')[0]);
        
        //Show loading animation
        ShowLoadingSwal();
        
        $.ajax({
                url: "<?php echo GetURL("modulos/modadminservicios/serviceadminservicios.php?accion=2")?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false            
        }).done(function(data)
        {                
            //Close loading swal.
            swal.close();
            
            if(data.indexOf("<li") > -1)
            {
                //Close modal
                $("#modalFrmAdd").closeModal();                                
                
                //Add data                
                $("#datacontainer").append(data);

                //Init data
                InitDropdown();
                $(".dataitems").fadeIn();                                
            }        
            else
            {
                Materialize.toast('Error, no se pudo agregar categoria.', 3000,"red");
                console.error("Error->CrearServicio(): "+data);
            }            
        });		      
    }

    function EditarServicio(id)
    {
        var formData = new FormData($('#frmUpload')[0]);
        formData.append("id",id);
        
        //Show loading animation
        ShowLoadingSwal();
        
        var EditAjax = $.ajax({
                url: "<?php echo GetURL("modulos/modadminservicios/serviceadminservicios.php?accion=3")?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json"
        });

        EditAjax.done(function(data)
        {                
            //Close loading swal.
            swal.close();
            
            if(data["status"] = 200)
            {
                //Close modal
                $("#modalFrmAdd").closeModal();                                
                
                //update data
                var Card = $("#Card_" + id);

                Card.fadeOut(function(){
                    //Set nombre
                    Card.find(".card-title-small").text($("#txtnombre").val());
                    //Set Descripcion
                    Card.find(".card-subtitle-small").text($("#txtcontenido").val());

                    if(data["imgurl"])
                        Card.find("img").attr("src",data["imgurl"]);

                    $(this).fadeIn();
                });
                return;
            }        

            Materialize.toast('Error, no se pudo actualizar categoria.', 3000,"red");
            console.error("Error->EditarServicio(): "+data);
        });

        EditAjax.fail(function(AjaxObject){
            Materialize.toast('Error, no se pudo actualizar categoria.', 3000,"red");
            console.error("ErrorJSON->EditarServicio(): " + AjaxObject.responseText);
        });              
    }

    function Eliminar(id)
    {
        ConfirmDelete("Eliminar categoria de servicio","¿Estás seguro de eliminar toda esta categoria?","",
        function()
        {             
            var AjaxEliminar = $.post("<?php echo GetURL("modulos/modadminservicios/serviceadminservicios.php?accion=4") ?>",{id:id});
            
            AjaxEliminar.done(function(data)
            {
                if(data == "0")
                {
                    $("#Card_"+id).fadeOut(function(){$(this).remove()});
                    Materialize.toast('Categoria del servicio eliminada', 3000);
                }
                else
                {
                    Materialize.toast('No se pudo eliminar la categoria', 4000);
                    console.error("Error->Eliminar():"+data);
                }
            });

        });        
    }

</script>