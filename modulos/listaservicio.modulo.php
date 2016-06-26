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

	if( !URLParam(2) )
	{
		throw new Exception("Servicio no encontrado");
		return;
	}
	
	$IDTipoServicio = URLParam(2);

    //Check service category exist.
    $stmt = $mysqli->select("tipo_servicio",
    [
        "nombre","descripcion"
    ],
    [
        "idtiposervicio" => $IDTipoServicio
    ]);

    if(empty($stmt))
    {    
        throw new Exception("Servicio no encontrado:".$mysqli->error()[2]);
        return;
    }

    AddHistory("Servicios",GetURL("dashboard/adminservicios"),true);
	AddHistory($stmt[0]["nombre"],"");    
?>


<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3"><?php echo $stmt[0]["nombre"] ?></h3>
            <p class="center light"><?php echo $stmt[0]["descripcion"] ?></p>
            <div class="divider3"></div>
        </div>		
        
        <!--Module Data-->
        <ul id="datacontainer" class="collection fixed-drop no-margin" style="margin-bottom:100px">
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
<div id="modalFrmAdd" class="modal modal-fixed-footer create-item">
    <div class="modal-content no-padding">        
        <form id="frmUpload" autocomplete="off" method="POST" enctype="multipart/form-data" action="javascript:CrearServicio()">
            <div class="description">
                <div class="row card-content">
                    <div class="input-field col s12">               
                        <h5>Crear un servicio</h5>
                    </div>
                    <div class="input-field col s12">
                        <input id="txttitulo" length="100" maxlength="100" name="titulo" type="text" class="validate" required> 
                        <label for="txttitulo">Servicio</label>
                    </div>
                    <input  type="submit" style="display:none">
                </div> 
            </div>
            <input type="hidden" name="idcat" value="<?php echo $IDTipoServicio ?>">
        </form>       
    </div>
    <div class="modal-footer">
           <a id="update-yes" onclick="$(this).parents().find(':submit').click();" class="btn-flat blue-text text-darken-1 waves-effect ">Salvar<i class="material-icons right"></i></a>
           <a id="update-no"  class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div>        
</div>
<!-- MODAL EDITAR INFO Servicio -->

<script>
    const IDTipoService = '<?php echo $IDTipoServicio ?>';

    $(document).ready(function(){                  
        //Get data
        GetAjaxData();                        
    }); //end document ready

    var ajax_request;
    function GetAjaxData()
    {         
        //Prevent parallel execution of ajax.
        if(ajax_request) ajax_request.abort();

        //Get data
        ajax_request = $.post("<?php echo GetURL("modulos/modlistaservicio/servicelistaservicio.php?accion=1")?>",
                              {idcat:IDTipoService},null,"json");
                
        ajax_request.done
        (
            function(data)
            {
                if(data["status"] == 200)
                {                
                    $("#datacontainer").html(data["html"]);
                    InitDropdown();
                    $(".dataitems").fadeIn();
                }
            }
        );
        
        ajax_request.fail(function(AjaxObject){
            Materialize.toast('Error interno del servidor', 3000,"red");
            console.error("ErrorJSON->GetAjaxData(): " + AjaxObject.responseText);
        });                      	  
    }

    function OpenModal(EditID)
    {
        var MID = "#modalFrmAdd";
        var FrmAction = 'javascript:CrearServicio()';
        var Titulo = 'Crear un servicio';
        $(MID).find("form").trigger("reset");

        if(EditID)
        {
            var item = $("#Serv_" + EditID);
            //Set nombre
            $("#txttitulo").val($.trim(item.find(".content").text()));
            //Set Action
            FrmAction = 'javascript:EditarServicio('+EditID+')';

            var Titulo = 'Editar un servicio';       
        }

        $(MID).find('h5').text(Titulo);
        $(MID).find("form").attr('action',FrmAction);
        //Fix inputs placeholder bug
        Materialize.updateTextFields();
        //Open modal
        $(MID).openModal();
    }


    function CrearServicio()
    {
        var formData = $('#frmUpload').serialize();

        //Get data
        ajax_request = $.post("<?php echo GetURL("modulos/modlistaservicio/servicelistaservicio.php?accion=2")?>",
                              formData,null,"json");
                
        ajax_request.done
        (
            function(data)
            {
                //Close loading swal.
                swal.close();
                
                if(data["status"] == 200)
                {                
                    //Close modal
                    $("#modalFrmAdd").closeModal();
           
                    $("#datacontainer").append(data["html"]);
                    InitDropdown();
                    $(".dataitems").fadeIn();
                }
            }                                
        );
        
        ajax_request.fail(function(AjaxObject){
            Materialize.toast('Error interno del servidor', 3000,"red");
            console.error("ErrorJSON->CrearServicio(): " + AjaxObject.responseText);
        });                  
    }

    function EditarServicio(id)
    {
        var formData = $('#frmUpload').serialize() + '&idser=' + id;

        //Get data
        ajax_request = $.post("<?php echo GetURL("modulos/modlistaservicio/servicelistaservicio.php?accion=3")?>",
                              formData, null, "json");
                
        ajax_request.done
        (
            function(data)
            {
                //Close loading swal.
                swal.close();
                
                if(data["status"] == 200)
                {                
                    //Close modal
                    $("#modalFrmAdd").closeModal();
                    var item = $("#Serv_"+id);
                    item.fadeOut(function()
                    {
                        $(this).find('.content').text($("#txttitulo").val());
                        $(this).fadeIn();
                    });
                }
            }                                
        );
        
        ajax_request.fail(function(AjaxObject){
            Materialize.toast('Error interno del servidor', 3000,"red");
            console.error("ErrorJSON->CrearServicio(): " + AjaxObject.responseText);
        });                  
    }    

    function Eliminar(id)
    {
        //Get data
        ajax_request = $.post("<?php echo GetURL("modulos/modlistaservicio/servicelistaservicio.php?accion=4")?>",
                              {idser:id}, null, "json");
                
        ajax_request.done
        (
            function(data)
            {
                //Close loading swal.
                swal.close();
                
                if(data["status"] == 200)
                {                
                    //Close modal
                    $("#modalFrmAdd").closeModal();
                    var item = $("#Serv_"+id);
                    item.fadeOut(function()
                    {
                        $(this).remove();
                    });
                }
            }                                
        );
        
        ajax_request.fail(function(AjaxObject){
            Materialize.toast('Error interno del servidor', 3000,"red");
            console.error("ErrorJSON->EliminarServicio(): " + AjaxObject.responseText);
        });                  
    }        
</script>