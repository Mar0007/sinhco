<?php
	global $mysqli;
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1 || !login_check($mysqli))
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	
	
	$editID = ( isset($_GET["idmodulo"]) ) ? $_GET["idmodulo"] : "";

	if($editID != "")
	{
		$strSQL = "SELECT idmodulo,modulo,tipo,contenido FROM modulos WHERE idmodulo = ?";
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('s',$editID);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($idmodulo,$modulo,$tipo,$contenido);										
			
			if(!$stmt->fetch())
			{ 
				echo "<h2>Modulo no encontrado</h2>";
				return;
			}
			
			if($tipo != 0)
			{
				echo "<h2>El modulo no es de contenido estatico</h2>";
				return;
			}
		}		
	}
?>

<script src="recursos/tinymce/tinymce.min.js"></script>
<nav>
	<div class="nav-wrapper">
		<div class="col s12">
		<a href="index.php?mod=modulos" class="breadcrumb">Modulos</a>
		<a class="breadcrumb"><?php echo ($editID != "") ? $idmodulo:"Nuevo Modulo"?></a>
		</div>
	</div>
</nav>
<div class="card-content">
	<h3><?php echo ($editID != "") ? "Editar":"Crear"?> modulo estatico</h3>
	<div title="Crear modulo estatico">
		<form id="frmModulo" action="javascript:<?php echo ($editID != "") ? "Editar()":"Agregar()"?>">
			<div class="input-field col s12">
				<label for="txtCodigo">Codigo</label>
				<input id="txtCodigo" type="text" class="validate" <?php echo ($editID != "") ? "disabled":""?> required pattern="\S+" title="Sin espacios" maxlength="20" length="20" value="<?php echo ($editID != "") ? $idmodulo:""?>">		
			</div>
			
			<div class="input-field col s12">
				<label for="txtTitulo">Titulo</label>
				<input id="txtTitulo" type="text" class="validate" required value="<?php echo ($editID != "") ? $modulo:""?>">		
			</div>
			<input type="submit" style="display:none">
			<label>Contenido:</label>
			<textarea><?php echo ($editID != "") ? $contenido:""?></textarea>
		</form>
	</div>
	<div class="card-action">
		<button id="btnCrear" class="btn waves-effect waves-light" onclick="$('#frmModulo').find(':submit').click();"><?php echo ($editID != "") ? "<i class=\"material-icons left\">save</i>Guardar":"<i class=\"material-icons left\">library_add</i>Crear Modulo"?></button>
	</div>
</div>

<script>	
	tinymce.init({
		selector: "textarea",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste imagetools"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | fullscreen",
		height : 300	
	});
	
	//Main
	$(document).ready(function(){					
	});	
	
	//Functions	
	function Agregar()
	{
		var idmodulo  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		var contenido = tinymce.activeEditor.getContent();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");
			
		//Check first if form is valid.
		if (!$("#frmModulo")[0].checkValidity()) 		
		{
			$("#frmModulo").find(':submit').click()
			return;
		}			
				
		$.ajax
		({
			url:"modulos/modcrearmodulo/servicecrearmodulo.php?accion=2",
			method: "POST",
			data: {idmodulo:idmodulo,titulo:titulo,contenido:contenido}
		}).done(function(data){
			if(data == "0")
			{
				swal({
					title:"Guardado", 
					text:"Los datos se han almacenado satisfactoriamente.", 
					type:"success"
				},
				function(){
					location.href='index.php?mod=modulos';
				});				
				//setTimeout(function(){location.href='index.php?mod=modulos';}, 3000);
			}				
			else
				swal("Error", data, "error");
		});					
	}
	
	function Editar()
	{
		var idmodulo  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		var contenido = tinymce.activeEditor.getContent();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");

		//Check first if form is valid.
		if (!$("#frmModulo")[0].checkValidity()) 		
		{
			$("#frmModulo").find(':submit').click()
			return;
		}				
		
		$.ajax
		({
			url:"modulos/modcrearmodulo/servicecrearmodulo.php?accion=3",
			method: "POST",
			data: {idmodulo:idmodulo,titulo:titulo,contenido:contenido}
		}).done(function(data){
			if(data == "0")
			{
				swal({
					title:"Guardado", 
					text:"Los datos se han almacenado satisfactoriamente.", 
					type:"success"
				},
				function(){
					location.href='index.php?mod=modulos';
				});
				
				//setTimeout(function(){location.href='index.php?mod=modulos';}, 3000);
			}				
			else
				swal("Error", data, "error");
		});					
	}
</script>
