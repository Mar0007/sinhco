<?php
	global $mysqli;
	//Seguridad, para asegurar que se esta llamando desde el index.
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
	
	$editID = ( isset($_GET["idarticulo"]) ) ? $_GET["idarticulo"] : "";
	if($editID != "")
	{
		$strSQL = "SELECT titulo,estado,tags,contenido FROM mod_articulos WHERE idarticulo = ?";
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('s',$editID);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($titulo,$estado,$tags,$contenido);										
			
			if(!$stmt->fetch())
			{ 
				echo "<h2>Articulo no encontrado</h2>";
				return;
			}			
		}		
	}
?>

<script src="recursos/tinymce/tinymce.min.js"></script>

<div class="card-content">
	<h3 class><?php echo ($editID != "") ? "Editar":"Crear"?> articulo</h3>
	<div title="Modificacion de articulo">
		<div class="row">
			<form id="frmArticulo" action="javascript:<?php echo ($editID != "") ? "Editar()":"Agregar()"?>">
				<input type="hidden" id="idarticulo" value="<?php echo ($editID != "") ? $editID : ""?>"/>
				<div class="input-field col s8 m9 l10">
					<label for="txtTitulo">Titulo</label>
					<input id="txtTitulo" type="text" class="validate" required value="<?php echo ($editID != "") ? $titulo : ""?>">
				</div>
				<div class="input-field col s2">
					<input type="checkbox" id="ckactivo" <?php echo ( $editID != "" && $estado) ? "checked" : (($editID == "") ? "checked" : "") ?> />
					<label for="ckactivo">Activo</label>
				</div>  				
				<div class="input-field col s12">
					<label for="txtEtiquetas">Etiquetas</label>
					<input id="txtEtiquetas" placeholder="Palabras clave separadas por coma." type="text" class="validate" required value="<?php echo ($editID != "") ? $tags : ""?>">		
				</div>
				<input type="submit" style="display:none">		
			</form>	
		</div>
		
		<label>Contenido:</label>
		<textarea><?php echo ($editID != "") ? $contenido:""?></textarea>
	</div>
	<div class="card-action">
		<button id="btnCrear" class="btn waves-effect waves-light" onclick="$('#frmArticulo').find(':submit').click();"><?php echo ($editID != "") ? "<i class=\"material-icons left\">save</i>Guardar":"<i class=\"material-icons left\">note_add</i>Crear Articulo"?></button>
	</div>
</div>

<script>	
	tinymce.init({
		selector: "textarea",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste imagetools responsivefilemanager"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | fullscreen | responsivefilemanager ",
		
		image_advtab: true ,		
		external_filemanager_path:"recursos/responsive_filemanager/filemanager/",
		filemanager_title:"Filemanager",
		external_plugins: { "filemanager" : "../responsive_filemanager/filemanager/plugin.min.js"},						
		height : 400	
	});
	
	//Main
	$(document).ready(function(){				
	});	
	
	//Functions	
	function Agregar()
	{
		var titulo  	= $("#txtTitulo").val();
		var estado  	= $("#ckactivo").is(':checked') | 0;
		var tags	  	= $("#txtEtiquetas").val();
		var contenido 	= tinymce.activeEditor.getContent();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");
			
		//Check first if form is valid.
		if (!$("#frmArticulo")[0].checkValidity()) 		
		{
			$("#frmArticulo").find(':submit').click()
			return;
		}			
				
		$.ajax
		({
			url:"modulos/modcreararticulo/servicecreararticulo.php?accion=2",
			method: "POST",
			data: {titulo:titulo,estado:estado,tags:tags,contenido:contenido}
		}).done(function(data){
			if(data == "0")
			{
				swal({
					title:"Guardado", 
					text:"Los datos se han almacenado satisfactoriamente.", 
					type:"success"
				},
				function(){
					location.href='index.php?mod=adminarticulos';
				});
			}				
			else
				swal("Error", data, "error");
		});					
	}
	
	function Editar()
	{
		var idarticulo 	= $("#idarticulo").val();
		var titulo  	= $("#txtTitulo").val();
		var estado  	= $("#ckactivo").is(':checked') | 0;
		var tags	  	= $("#txtEtiquetas").val();
		var contenido 	= tinymce.activeEditor.getContent();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");

		//Check first if form is valid.
		if (!$("#frmArticulo")[0].checkValidity()) 		
		{
			$("#frmArticulo").find(':submit').click()
			return;
		}						
		
		$.ajax
		({
			url:"modulos/modcreararticulo/servicecreararticulo.php?accion=3",
			method: "POST",
			data: {idarticulo:idarticulo,titulo:titulo,estado:estado,tags:tags,contenido:contenido}
		}).done(function(data){
			if(data == "0")
			{
				swal({
					title:"Guardado", 
					text:"Los datos se han almacenado satisfactoriamente.", 
					type:"success"
				},
				function(){
					location.href='index.php?mod=adminarticulos';
				});				
			}				
			else
				swal("Error", data, "error");
		});					
	}
</script>
