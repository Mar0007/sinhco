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

	echo "<h3>$titulo</h3>";
	echo "<p>$mensaje</p>"; 
?>

<form action="login.php" method="POST" onsubmit="javascript:encriptarpassw()" name="loginform">
	<div class="input-field col s12">
		<i class="material-icons prefix">account_circle</i>
		<input type="text" placeholder="Usuario" name="idusuario" id="idusuario" />
		<label for="idusuario">Usuario</label>
	</div>
	<div class="input-field col s12">
		<i class="material-icons prefix">vpn_key</i>
		<input type="password" placeholder="Contraseña" name="txtpassw" id="txtpassw"/>
		<label for="password">Password</label>
	</div>
	<input type="hidden" name="passw" id="passw" value=""/>
	<!--input type="submit" value="Ingresar"/-->
	<button class="btn waves-effect waves-light" type="submit">Ingresar
		<i class="material-icons right">send</i>
	</button>	
</form>
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