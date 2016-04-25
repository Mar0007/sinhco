<?php
	global $mysqli;	
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1 || !login_check($mysqli))
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}
		
	if( !isset($_GET["idusuario"]) )
	{
		echo "Usuario no valido.";
		return;
	}
	
	$idusuario = $_GET["idusuario"];	
	if(!esadmin($mysqli) && $idusuario != $_SESSION['idusuario'])
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	
		
	$strSQL = "SELECT nombre,email,estado FROM usuarios WHERE idusuario = ?";
	if( $stmt = $mysqli->prepare($strSQL) )
	{
		$stmt->bind_param('s',$idusuario);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($usuario,$email,$estado);										
		
		if(!$stmt->fetch())
		{ 
			echo "Usuario no encontrado";
			return;
		}
	}
    else 
    {
        echo "Error en consulta:" . $mysqli->error;
        return;
    }	   		
?>				

<div class="card-content">
	<div class="col s12">							
		<div title="Perfil del Usuario">
			<form id="frmusuario" action="javascript:ValidarDatos()" method="POST" enctype="multipart/form-data">
				<div class="center-align">
					<div class="input-field col s12">
					<?php
						echo "<img id=\"UserImage\" class=\"circle\" style=\"width:128px;height:128px\" src=\"".GetUserImagePath($idusuario)."\">";
					?>
					</div>
					<br>
					<label>Escoger Imagen: </label>
					<br>
					<input type="file" name="imagen" id="inputimagen" accept=".png,.jpg"/>
				</div>					
				<div class="input-field col s12">
				<i class="material-icons prefix">assignment_ind</i>
				<input id="idusuario" type="text" class="validate" length="20" disabled value="<?php echo $idusuario ?>">
				<input type="hidden" value="<?php echo $idusuario ?>" name="idusuario">
				<label for="idusuario">Usuario</label>
				</div>		
				<div class="input-field col s12">
				<i class="material-icons prefix">perm_identity</i>
				<input id="nombre" name="nombre" type="text" class="validate" required value="<?php echo $usuario ?>">
				<label for="nombre">Nombre</label>
				</div>		
				<div class="input-field col s12">
				<i class="material-icons prefix">email</i>
				<input id="email" name="email" type="email" class="validate" required value="<?php echo $email ?>">
				<label for="email">Email</label>
				</div>		
															
				<div class="input-field col s6">
				<i class="material-icons prefix">lock</i>
				<input id="txtpassword" name="password" type="password" class="validate" >
				<label for="txtpassword">Contraseña</label>
				</div>		
				<div class="input-field col s6">
				<i class="material-icons prefix">lock_outline</i>
				<input id="confirmpassword" name="confirmpassword" type="password" class="validate">
				<label for="confirmpassword">Confirmar</label>
				</div>
										
				<div class="col s3">
				<input type="checkbox" id="ckactivo" name="estado" <?php echo ($estado) ? "checked" : "" ?>/>
				<label for="ckactivo">Activo</label>
				</div>					
				<input type="submit" value="Guardar" style="display:none;">											
			</form>							
		</div>
	</div>
</div>
<button id="btnagregar" class="btn waves-effect waves-light input-field col s12" onclick="$('#frmusuario').find(':submit').click();">
	Guardar
</button>

<!-- Import SHA512 functions -->
<script src="recursos/sha512.js"></script>

<script>
	$(document).ready(function(){				
		$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year
			format: 'yyyy-mm-dd'
		});		        
	});	
	
	function readURL(input) 
	{
		if (input.files && input.files[0]) {
			var reader = new FileReader();
	
			reader.onload = function (e) {
				$('#UserImage').attr('src', e.target.result);
			}
	
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	$("#inputimagen").change(function(){
		readURL(this);
	});
	
	//Functions		
	function ValidarDatos()
	{									
		if($("#txtpassword").val() != $("#confirmpassword").val())
			return swal("Error","Contraseñas no concuerdan",'error');
						
		if($("#txtpassword").val() != "")
		{
			$("#txtpassword").val(hex_sha512($("#txtpassword").val()));
			$("#confirmpassword").val("");
		}
		
		ShowLoadingSwal();
		var formData = new FormData($('#frmusuario')[0]);
		
		$.ajax(
			{
			url:"modulos/modusuarioperfil/serviceusuarioperfil.php?accion=3",
			method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			if(data == "0")
			{
				swal({
					title:"Guardado", 
					text:"Los datos se han almacenado satisfactoriamente.", 
					type:"success"
				},
				function(){
					location.href="index.php";
				});
			}				
			else
				swal("Error", data, "error");
		});					
	}
				
</script>