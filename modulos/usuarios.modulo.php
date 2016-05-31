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
			
?>

<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Usuarios</h3>
            <p class="center light">Cree, edite y organice los usuarios.</p>
            <div class="divider3"></div>
        </div>
        
        <!--Module Data-->
        <ul id="datacontainer" class="">
			
		</ul>
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="btnCrear" class="btn-floating btn-large blue-grey darken-2 tooltipped"  onclick="OpenModal()" data-position="left" data-delay="50" data-tooltip="Crear usuario">
                <i class="large material-icons">add</i>
            </a>
        </div>   
    </div>
</div>


<div id="modalFrmAdd" class="modal new-user modal-fixed-footer">
	<div class="modal-content no-padding">
		
        <div id="user-backimg" class="" style="background-image:url()">
            <img  class="user-cover" style="" src="<?php echo GetCoverImagePath(0)?>">
            <input style="display:none" type="file" name="user-cover-img" id="FileInput2" accept=".png,.jpg"/>
            <span style="visibility:hidden"><a id="" onclick="$('#user-backimg').find('#FileInput2').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
    </div>
        <div id="user-rndimg" class="center">
            <img  id="" class="user-img" src="<?php echo GetUserImagePath(0)?>"> 
            <input style="display:none" type="file" name="user-cover-img" id="FileInputRndImg" accept=".png,.jpg"/>
            <span style="visibility:hidden"><a id="" onclick="$('#user-rndimg').find('#FileInputRndImg').click();" class="waves-effect waves-circle user-img-input img-input-btn  white-text"><i class="material-icons" style="padding:11px">camera_alt</i></a></span>
        </div>        
		<form id="frmagregar" class="description" autocomplete="off" action="javascript:Agregar()">
			<div class="row">                	
                <div class="input-field col s12 m6 l6">			
                    <input id="nombre" type="text" class="validate" required>
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field col s12 m6 l6">			
                    <input id="apellido" type="text" class="validate" >
                    <label for="apellido">Apellido</label>
                </div>
            </div>
			<div class="row">
                <div class="input-field col s12 m6 l6">			
                    <input id="email" type="email" class="validate" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-field col s12 m6 l6">			
                    <input id="idusuario" type="text" class="validate" maxlength="20" required>
                    <label for="idusuario">Usuario</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select id="ckactivo">
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>                      
                    </select>
                    <label>Estado del usuario</label>
                </div>
            </div>
            <div class="row">                
                <div class="input-field col s12 m6 l6">			
                    <input id="txtpassword" type="password" class="validate" required>
                    <label for="txtpassword">Contraseña</label>
                </div>		
                <div class="input-field col s12 m6 l6">			
                    <input id="confirmpassword" type="password" class="validate" required>
                    <label for="confirmpassword">Confirmar Contraseña</label>
                </div>			
            </div>
			<input type="submit" value="Guardar" style="display:none">  						
		</form>
	</div>
     <div class="modal-footer">
            <a id="btnSaveDialogUsr" class="btn blue darken-1 waves-effect " onclick="$('#modalFrmAdd').find('form').find(':submit').click()">Crear<i class="material-icons right"></i></a>
            <a id="btnCancelDialogUsr" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div> 
</div>

<!-- Import SHA512 functions -->
<script src="<?php echo GetURL("recursos/sha512.js")?>"></script>

<script>
	
	//Main
	$(document).ready(function(){	
        $("#FileInput2").change(handleFileSelect);
		//Get data
		$.ajax({
			url:"<?php echo GetURL("modulos/modusuarios/serviceusuarios.php?accion=1") ?>"
		}).done(
			function(data){
				$("#datacontainer").append(data);
				InitDropdown();
				$(".dataitems").fadeIn();
			}
		);		
	});
		
	function Agregar()
	{														
		if($("#txtpassword").val() != $("#confirmpassword").val())		
		{
			swal("Error", "Contraseñas no concuerdan", "error");
			return;
		}				
		
		var idusuario 	= $("#idusuario").val();
		var nombre 		= $("#nombre").val();
        var apellido	= $("#apellido").val();
		var email 		= $("#email").val();
		var estado 		= $("#ckactivo").val();
		var password 	= hex_sha512($("#txtpassword").val());										
		
		ShowLoadingSwal();
																			
		$.ajax(
			{
			url:"<?php echo GetURL("modulos/modusuarios/serviceusuarios.php?accion=2")?>",
			method: "POST",
			data: {idusuario:idusuario,nombre:nombre,apellido:apellido,email:email,estado:estado,password:password}
		}).done(function(data){
			$("#modalFrmAdd").closeModal();
			if(data.indexOf("<tr") > -1)
			{
				swal.close();			
				$("#datacontainer").append(data);
				InitDropdown();
				$("#"+idusuario).fadeIn();
			}
			else
				swal("Error", data, "error");
		});								
	}

	function Eliminar(idusuario)
	{
                
        ConfirmDelete("Eliminar usuario","¿Está seguro que quiere eliminar este usuario?","",
        function(){
             
            $.ajax({
				    url:"<?php echo GetURL("modulos/modusuarios/serviceusuarios.php?accion=4") ?>",
				    method: "POST",
				    data: {idusuario:idusuario}
			    }).done(function(data){
                            if(data=="0"){
                                $("#"+idusuario).fadeOut(function(){
                                $(this).remove();
                                    });
                                Materialize.toast('Usuario eliminado', 3000);
                            }
                            else{
                                alert(data);
                            }
                        }
                    );
        }
        );
            
	}
	
	function OpenModal()
	{
		var frm = $('#modalFrmAdd').find('form');
		frm.trigger('reset');
							
		//At last open it.
		$('#modalFrmAdd').openModal();
		$('#idperfil').focus();	  
	}			

</script>