<?php
	global $mysqli;
	$mensaje = "";
	$titulo  = "Inicio de Sesion";
	if( isset($_POST['idusuario'], $_POST['passw']) )
	{
		$idusuario = $_POST['idusuario'];
		$password = $_POST['passw']; //Password Encriptado
		
		if( !login($idusuario, $password, $mysqli) )
		{
			$mensaje = "<i class=\"material-icons left\">error</i>Error al iniciar sesion, Compruebe su usuario y contraseña";
		}
	}
	
	if( login_check($mysqli) )
	{
		header("Location: dashboard");
        return;
	}		

	//echo "<h3>$titulo</h3>";
	echo "<p>$mensaje</p>"; 
?>
<div class="row center">
    <?php
						echo "<img id=\"UserImage\" class=\"circle responsive-img\" style=\"width:128px;height:auto\" src=\"".GetUserImagePath(0)."\">";
					?>
    
<form id="loginform" action="login.php" method="POST" onsubmit="javascript:encriptarpassw()" autocomplete="off" name="loginform">
	<div class="input-field col s12">		
		<input type="text" name="idusuario" id="idusuario" />
		<label for="idusuario">Usuario</label>
	</div>
	<div class="input-field col s12">		
		<input type="password" name="txtpassw" id="txtpassw"/>
		<label for="password">Contraseña</label>
	</div>
	<input type="hidden" name="passw" id="passw" value=""/>
	<input type="submit"  value="Ingresar" style="display:none"/>
	
    <a class="btn-floating btn-large right right-top-margin blue darken-1 waves-effect"   onclick="$('#loginform').find(':submit').click();">
        <i class="material-icons">send</i>
    </a>	
</form>
    </div>
<!-- Import SHA512 functions -->
<script src="recursos/sha512.js"></script>
<script>		
	
	$(document).ready(function() {
		<?php
			if($mensaje != "")
				echo "LoginFrm();";
		?>					            
	});	
	
	function encriptarpassw()
	{				
		var passwenc = hex_sha512($("#txtpassw").val());
		$("#txtpassw").val("");
		$("#passw").val(passwenc);
	}
</script>