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
		$stmt = $mysqli->select("modulos",
		[
			"idmodulo","modulo","tipo","contenido"
		],
		[
			"idmodulo" => $editID
		]);
		if( CheckDBError($mysqli) ) return;
		
		if(!$stmt)
		{
			echo "<h2>Modulo no encontrado</h2>";
			return;
		}				
		$row = $stmt[0];
		
		if($row["tipo"] != 0)
		{
			echo "<h2>El modulo no es de contenido estatico</h2>";
			return;			
		}
	}
?>

<?php require_once("recursos/froalaeditor/editor.php"); ?>
<nav>
	<div class="nav-wrapper">
		<div class="col s12">
		<a href="<?php echo GetURL("dashboard/modulos")?>" class="breadcrumb">Modulos</a>
		<a class="breadcrumb"><?php echo ($editID != "") ? $row["idmodulo"] : "Nuevo Modulo"?></a>
		</div>
	</div>
</nav>
<div class="container" style="width:85%">
<div class="card-content">
	<h3><?php echo ($editID != "") ? "Editar":"Crear"?> modulo estatico</h3>
	<div title="Crear modulo estatico">
		<form id="frmModulo" action="javascript:<?php echo ($editID != "") ? "Editar()":"Agregar()"?>">
			<div class="input-field col s12">
				<label for="txtCodigo">Codigo</label>
				<input id="txtCodigo" type="text" class="validate" <?php echo ($editID != "") ? "disabled":""?> required pattern="\S+" title="Sin espacios" maxlength="20" length="20" value="<?php echo ($editID != "") ? $row["idmodulo"]:""?>">		
			</div>			
			<div class="input-field col s12">
				<label for="txtTitulo">Titulo</label>
				<input id="txtTitulo" type="text" class="validate" required value="<?php echo ($editID != "") ? $row["modulo"]:""?>">		
			</div>
			<input type="submit" style="display:none">
			<label>Contenido:</label>
			<textarea id='edit' placeholder="Escriba algun texto..."><?php echo ($editID != "") ? $row["contenido"]:""?></textarea>
		</form>
	</div>
	<!--div class="card-action">
		<button id="btnCrear" class="btn waves-effect waves-light" onclick="$('#frmModulo').find(':submit').click();"><?php echo ($editID != "") ? "<i class=\"material-icons left\">save</i>Guardar":"<i class=\"material-icons left\">library_add</i>Crear Modulo"?></button>
	</div-->
</div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
	<a id="crearProyecto" href="crearproyecto" onclick="$('#frmModulo').find(':submit').click();" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Guardar">
		<i class="large material-icons">save</i>
	</a>      
</div>

<script>	
	$(function(){
		$('#edit')
			.on('froalaEditor.initialized', function (e, editor) {
				/*
				$('#edit').parents('form').on('submit', function () {
					console.log($('#edit').val());
					return false;
				})
				*/
			})
			.froalaEditor({enter: $.FroalaEditor.ENTER_P, placeholderText: null,toolbarStickyOffset: 64,zIndex: 999,language: 'es'})
	});
	
	//Functions	
	function Agregar()
	{
		var idmodulo  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		//var contenido = tinymce.activeEditor.getContent();
		var contenido = $("#edit").val();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");
			
		//Check first if form is valid.
		if (!$("#frmModulo")[0].checkValidity()) 		
		{
			$("#frmModulo").find(':submit').click()
			return;
		}			
				
		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modcrearmodulo/servicecrearmodulo.php?accion=2")?>",
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
					location.href="<?php echo GetURL('dashboard/modulos')?>";
				});				
			}				
			else
				swal("Error", data, "error");
		});					
	}
	
	function Editar()
	{
		var idmodulo  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		//var contenido = tinymce.activeEditor.getContent();
		var contenido = $("#edit").val();
		
		if(contenido == "")
			return swal("Error", "Contenido no puede ir en blanco", "error");

		//Check first if form is valid.
		if (!$("#frmModulo")[0].checkValidity()) 		
		{
			$("#frmModulo").find(':submit').click()
			return;
		}				
		
		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modcrearmodulo/servicecrearmodulo.php?accion=3")?>",
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
					location.href="<?php echo GetURL('dashboard/modulos')?>";
				});				
			}				
			else
				swal("Error", data, "error");
		});					
	}
</script>
