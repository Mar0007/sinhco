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
		echo "Usuario no valido.";
		return;
	}
	
	$idusuario = URLParam(2);	
	if(!esadmin($mysqli) && $idusuario != $_SESSION['idusuario'])
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	
		
    if($_SESSION['idusuario'] == $idusuario || $_SESSION['idusuario'] == "admin"){
        echo '
            <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="btnCrear" class="btn-floating btn-large light-blue accent-4 tooltipped"  onclick="OpenModal()" data-position="left" data-delay="50" data-tooltip="Editar información">
                <i class="large material-icons">mode_edit</i>
            </a>
        </div>
        ';
    }
	//Get user info
	$stmt = $mysqli->select("usuarios",
		["nombre","apellido","email","estado"],
		["idusuario" => $idusuario]
	);	

	if(!$stmt)
	{
		if($mysqli->error()[2] != "")
			echo "Error:".$mysqli->error()[2];
		
		return;
	}
    
    AddHistory("Usuarios",GetURL("dashboard/usuarios"),true);
	AddHistory(($idusuario != "") ? $stmt[0]["nombre"] : "Nuevo usuario","");
?>				
<input type="hidden" id="maxsize" value="<?php echo parse_size(ini_get('upload_max_filesize')) ?>">
<div id="profile-card" class="container">
	<div class="row">
        <div class="card s12 m6">
            <div id="user-coverimg" class="" style="background-image:url()">
                <img id="user-setcover" class="user-cover" style="max-height: 245.6px;
height: 240px; cursor:auto" src="<?php echo GetCoverImagePath($idusuario)?>">
            </div>
            
            <div id="user-displayimg" class="center">
                <img  id="user-setimg" class="user-img" style="cursor:auto" src="<?php echo GetUserImagePath($idusuario)?>">                 
            </div>
            
            <div class="card-content center">
                <h4 id="user-wholename" class=""><join id="user-name" ><?php echo $stmt[0]["nombre"]?></join> <join id="user-lastname"><?php echo $stmt[0]["apellido"]?></join></h4>
                
                <p id="user-username" class="grey-text"><?php echo $idusuario ?></p>
                <p id="user-email" class="grey-text"><?php echo $stmt[0]["email"] ?></p>
                <p id="user-state" class="grey-text"><?php echo "Usuario ".(($stmt[0]["estado"] == 1 ) ? "activo" : "inactivo") ?></p>
            </div>                
        </div>
        
        <?php
            if($_SESSION['idusuario'] == $idusuario || $_SESSION['idusuario'] == "admin"){
                echo
                    '
                        <div class="divider"></div>
                        <div class="">
                            <ul class="collection" style="border:none !important">
                                <li class="collection-item avatar" style="background-color:transparent">
                                      <i class="material-icons circle blue darken-2">security</i>
                                      <span class="title medium">Cambiar contraseña</span>
                                      <p class="grey-text">Elige una contraseña segura. Al cambiar de contraseña, saldrás de la cuenta.</p>
                                      <a style="cursor:pointer" onclick="javascript:OpenChangePass()">CAMBIAR CONTRASEÑA</a>
                                </li>
                            </ul>                
                        </div>	
                    ';
            }
        ?>
            						
		
	</div>
</div>

<div id="modalFrmAdd" class="modal new-user modal-fixed-footer">
    <div class="modal-content no-padding">
        <form id="frmusuario" class="disable-enter" autocomplete="off" method="POST" enctype="multipart/form-data" action="javascript:Editar()">
            <div id="user-backimg" class="" style="background-image:url();">
                <img id="user-cover" class="user-cover" style="max-height: 245.6px;
height: 240px;" src="<?php echo GetURL("uploads/covers/cover-small.jpg")?>">
                <input style="display:none" type="file" name="user-cover-img" id="FileInput2" accept=".png,.jpg"/>
                <span style="visibility:hidden"><a id="" onclick="$('#user-backimg').find('#FileInput2').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
                <input id="InitImage" type="hidden" value="">
            </div>
            
            <div id="user-rndimg" class="center">
                <img  id="user-img" class="user-img" src="<?php echo GetUserImagePath($idusuario)?>"> 
                <input style="display:none" type="file" name="user-img" id="FileInputRndImg" accept=".png,.jpg"/>
                <span style="visibility:hidden"><a id="" onclick="$('#user-rndimg').find('#FileInputRndImg').click();" class="waves-effect waves-circle user-img-input img-input-btn  white-text"><i class="material-icons" style="padding:11px">camera_alt</i></a></span>
            </div>        
            
            <div class="description">
                <div class="input-field col s12 m6 l6" style="display:none">			
                        <input id="idusuario" name="idusuario"  type="text" class="validate" length="20" maxlength="20" required value="<?php echo $idusuario ?>" >
                        <label for="idusuario">Usuario</label>
                    </div>
                <div class="row">                    		
                    <div class="input-field col s6">			
                        <input id="usuario-nombre" name="nombre" type="text" class="validate" required  >
                        <label for="usuario-nombre">Nombre</label>
                    </div>
                    <div class="input-field col s6">			
                        <input id="usuario-apellido" name="apellido" type="text" class="validate"  value="<?php echo $stmt[0]["apellido"] ?>" >
                        <label for="usuario-apellido">Apellido</label>
                    </div>	
                </div>
                
                <div class="row">
                    <div class="input-field col s12 m6 l6">			
                        <input id="usuario-email" name="email" type="email" class="validate" required  >
                        <label for="usuario-email">Email</label>
                    </div>	
                    <div class="input-field col s12 m6 l6">
                        <select id="ckactivo" name="estado">
                            <option <?php if ($stmt[0]["estado"] == 1 ) echo 'selected' ; ?>value="1">Activo</option>
                            <option <?php if ($stmt[0]["estado"] == 0 ) echo 'selected' ; ?>value="0">Inactivo</option>                      
                        </select>
                        <label>Estado del usuario</label>
                    </div>
                </div>
                <input type="submit" value="Guardar" style="display:none">
            </div>
		</form>
	</div>
     <div class="modal-footer">
            <a id="btnSaveDialogUsr" class="btn blue darken-1 waves-effect ">Guardar<i class="material-icons right"></i></a>
            <a id="btnCancelDialogUsr" class="btn-flat modal-action modal-close  waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div> 
</div>

<!--CHANGE PASS MODAL-->
<div id="change-pass" class="modal create-item" style="min-height:70%">
    <div class="modal-content">
        <h5>Cambiar contraseña</h5>
        
        <form id="frmchangepass" autocomplete="off">
            <div class="row card-content">    
                <div class="input-field col s12 m6 l6" style="display:none">			
                        <input id="idusuario" name="idusuario"  type="text" class="validate" length="20" maxlength="20" required value="<?php echo $idusuario ?>" >
                        <label for="idusuario">Usuario</label>
                    </div>
                <div class="input-field col s12">
                    <input id="currentpass" name="currentpass" type="password" class="validate"  maxlength="50">
                    <label for="currentpass">Contraseña actual</label>
                </div>
                <div class="input-field col s12">
                    <input id="newpass" name="newpass" type="password" class="validate" pattern=".{8,}"  maxlength="50" required title="Utiliza 8 caracteres como mínimo.">
                    <label for="newpass">Contraseña nueva</label>
                </div>
                <div class="input-field col s12">
                    <input id="confirmpass" name="confrimpass" type="password" class="validate" pattern=".{8,}"  maxlength="50">
                    <label for="confirmpass">Confirmar la contraseña nueva</label>
                </div>               
               <!-- <input  id="sendForm" type="submit" style="visibility:hidden" disabled="disabled">-->
            </div> 
            
        </form>       
        
    </div>
    
    <div class="modal-footer">
        <a id="guardar" onclick="javascript:ChangePass()"  class="disabled modal-action  btn-flat  waves-effect waves-light">Cambiar</a>
        
        <a id="cancel" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div>        

</div>
<!--END CHANGE PASS MODAL-->

<!-- Import SHA512 functions -->
<script src="<?php echo GetURL("recursos/sha512.js")?>"></script>

<script>
	$(document).ready(function(){	
        $("#FileInput2").change(handleFileSelect);
        $("#FileInputRndImg").change(handleFileSelect);
        
		$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year
			format: 'yyyy-mm-dd',
            max: true,
		});	
        //toggle submit button in modal
         $('#newpass').keyup(function() {

            var empty = false;
            $('#newpass').each(function() {
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
	
    function OpenModal()
	{
		$( "#btnSaveDialogUsr" ).unbind('click').click(function() {
          if (!$("#frmusuario")[0].checkValidity())
            {
                $("#frmusuario").find(':submit').click();
                Materialize.toast('Todos los campos son requeridos', 4000);
                return;
            }
            OpenSwal();
       });
        
		//Reset inputs.
        $("#modalFrmAdd").find("form").trigger("reset");   
        //Get cover image.
        $("#modalFrmAdd").find("#user-cover").attr('src', $("#profile-card").find("#user-setcover").attr('src'));
        //Get profile image.
        $("#modalFrmAdd").find("#user-img").attr('src', $("#profile-card").find("#user-setimg").attr('src'));
        //Fill inputs
        $("#usuario-nombre").val($("#user-wholename").find('#user-name').text());    
        $("#usuario-apellido").val($("#user-wholename").find('#user-lastname').text());    
        $("#usuario-email").val($("#profile-card").find('#user-email').text());
            
        Materialize.updateTextFields();
        //Open Modal.
		$('#modalFrmAdd').openModal({
            dismissible: false            
        });
       // Materialize.updateTextFields();		
	}
    function OpenChangePass()
	{
		var frm = $('#change-pass').find('form');
		frm.trigger('reset');
							
		//At last open it.
		$('#change-pass').openModal();
        Materialize.updateTextFields();		
	}	
	
	function ChangePass()
    {
        if($("#newpass").val() != $("#confirmpass").val())
			return swal("Error","Contraseñas no concuerdan",'error');
						
		else{
            ShowLoadingSwal();
            
            var formData = new FormData($('#frmchangepass')[0]);
            
            formData.set("newpass", hex_sha512(formData.get("newpass")));
            formData.set("currentpass", hex_sha512(formData.get("currentpass")));		
            
            $.ajax(
                {
                url:"<?php echo GetURL("modulos/modusuarioperfil/serviceusuarioperfil.php?accion=5") ?>",
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(data){
                if(data == "0")
                {

                    Materialize.toast('Contraseña actualizada', 3000);
                    $("#modalFrmAdd").closeModal();
                }				
                else
                    if(data == "1"){
                        Materialize.toast('Contraseña actual no concuerda', 3000);
                    }
                    else
                        swal("Error", data, "error");
            });	
            swal.close();
        }
    }
	//Functions		
	function Editar()
	{									
		
		ShowLoadingSwal();
		var formData = new FormData($('#frmusuario')[0]);
		
		$.ajax(
			{
			url:"<?php echo GetURL("modulos/modusuarioperfil/serviceusuarioperfil.php?accion=3") ?>",
			method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
            switch(data){
                case "0":
                    var nombre   = $("#usuario-nombre").val();
                    var apellido = $("#usuario-apellido").val();

                    //Update Info
                    $("#user-name").text(nombre);                                
                    $("#user-lastname").text(apellido);
                    $("#user-email").text($("#usuario-email").val());

                    //UPDATE User cover
                    if ($("#FileInput2").val() != ""){
                        var extention = $("#FileInput2").val().substr($("#FileInput2").val().lastIndexOf('.')+1);
                    $("#user-coverimg .user-cover").attr("src","/uploads/covers/Cover-"+$("#idusuario").val()+"."+extention+"?"+(new Date()).getTime());

                    }

                    //UPDATE User image
                    if ($("#FileInputRndImg").val() != ""){
                        var extention = $("#FileInputRndImg").val().substr($("#FileInputRndImg").val().lastIndexOf('.')+1);
                        
                        $("#user-displayimg .user-img").attr("src","/uploads/avatars/"+$("#idusuario").val()+"."+extention+"?"+(new Date()).getTime());
                    }

                    Materialize.toast('Usuario actualizado', 3000);
                    $("#modalFrmAdd").closeModal();
                    
                    break;
                case "1":
                    swal("Error", "Otra persona ya está usando este correo electrónico.", "error");
                    
                    break;
                default:
                    swal("Error", data, "error");
                    break;                
            }
			
			swal.close();
		});					
	}
    
    function OpenSwal()
    {
        swal({
          title: "Escribe tu contraseña",
          html: "Por tu seguridad debes de escribir tu contraseña para poder continuar.",
          input: "password",
          closeOnConfirm: false,
        }).then( function (inputValue) {
          if (inputValue === false) return false;
          if (inputValue === "") {
            swal.showInputError("Debes ingresar tu contraseña para continuar.");
            return false
          }
            CheckPassword(inputValue);         
        });
    }
    
    function CheckPassword (password)
    {
        var password = hex_sha512(password);
        var idusuario = $("#idusuario").val();
        $.ajax(
			{
			url:"<?php echo GetURL("modulos/modusuarioperfil/serviceusuarioperfil.php?accion=6") ?>",
			method: "POST",
			data: {password:password, idusuario:idusuario}			
		}).done(function(data){
			if(data == "0")
			{
				swal.close();
                Editar();                
			}				
			else
                if(data == "1"){
                    swal.showInputError("Contraseña actual no concuerda");
                    return false                   
                }
                else
                    swal("Error", data, "error");
		});
    }
				
</script>