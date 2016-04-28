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
	
	$editID = ( !URLParam(0) ) ? "" : URLParam(2);

	if($editID != "")
	{
		$stmt = $mysqli->select("bloques",
		[
			"idbloque","bloque","tipo","contenido"
		],
		[
			"idbloque" => $editID
		]);
		if( CheckDBError($mysqli) ) return;
		
		if(!$stmt)
		{
			echo "<h2>Bloque no encontrado</h2>";
			return;
		}				
		$row = $stmt[0];
		
		if($row["tipo"] != 0)
		{
			echo "<h2>El bloque no es de contenido estatico</h2>";
			return;			
		}
	}
?>

<script src="<?php echo GetURL("recursos/tinymce/tinymce.min.js") ?>"></script>
<nav>
	<div class="nav-wrapper">
		<div class="col s12">
		<a href="<?php echo GetURL("dashboard/bloques")?>" class="breadcrumb">Bloques</a>
		<a class="breadcrumb"><?php echo ($editID != "") ? $row["idbloque"] : "Nuevo Bloque"?></a>
		</div>
	</div>
</nav>
<div class="card-content">
	<h3><?php echo ($editID != "") ? "Editar":"Crear"?> bloque estatico</h3>
	<div title="Crear bloque estatico">
		<form id="frmBloque" action="javascript:<?php echo ($editID != "") ? "Editar()":"Agregar()"?>">
			<div class="input-field col s12">
				<label for="txtCodigo">Codigo</label>
				<input id="txtCodigo" type="text" class="validate" <?php echo ($editID != "") ? "disabled":""?> required pattern="\S+" title="Sin espacios" maxlength="20" length="20" value="<?php echo ($editID != "") ? $row["idbloque"]:""?>">		
			</div>			
			<div class="input-field col s12">
				<label for="txtTitulo">Titulo</label>
				<input id="txtTitulo" type="text" class="validate" required value="<?php echo ($editID != "") ? $row["bloque"]:""?>">		
			</div>
			<input type="submit" style="display:none">
			<label>Contenido:</label>
			<textarea><?php echo ($editID != "") ? $row["contenido"]:""?></textarea>
		</form>
	</div>
	<div class="card-action">
		<button id="btnCrear" class="btn waves-effect waves-light" onclick="$('#frmBloque').find(':submit').click();"><?php echo ($editID != "") ? "<i class=\"material-icons left\">save</i>Guardar":"<i class=\"material-icons left\">library_add</i>Crear Bloque"?></button>
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
		var idbloque  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		var contenido = tinymce.activeEditor.getContent();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");
			
		//Check first if form is valid.
		if (!$("#frmBloque")[0].checkValidity()) 		
		{
			$("#frmBloque").find(':submit').click()
			return;
		}			
				
		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modcrearbloque/servicecrearbloque.php?accion=2")?>",
			method: "POST",
			data: {idbloque:idbloque,titulo:titulo,contenido:contenido}
		}).done(function(data){
			if(data == "0")
			{
				swal({
					title:"Guardado", 
					text:"Los datos se han almacenado satisfactoriamente.", 
					type:"success"
				},
				function(){
					location.href="<?php echo GetURL('dashboard/bloques')?>";
				});				
			}				
			else
				swal("Error", data, "error");
		});					
	}
	
	function Editar()
	{
		var idbloque  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		var contenido = tinymce.activeEditor.getContent();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");

		//Check first if form is valid.
		if (!$("#frmBloque")[0].checkValidity()) 		
		{
			$("#frmBloque").find(':submit').click()
			return;
		}				
		
		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modcrearbloque/servicecrearbloque.php?accion=3")?>",
			method: "POST",
			data: {idbloque:idbloque,titulo:titulo,contenido:contenido}
		}).done(function(data){
			if(data == "0")
			{
				swal({
					title:"Guardado", 
					text:"Los datos se han almacenado satisfactoriamente.", 
					type:"success"
				},
				function(){
					location.href="<?php echo GetURL('dashboard/bloques')?>";
				});				
			}				
			else
				swal("Error", data, "error");
		});					
	}
</script>
