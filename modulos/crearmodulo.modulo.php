<?php
	global $mysqli;
	global $OnDashboard;
	global $Navigation;
	
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
			"idmodulo","modulo","tipo","contenido","descripcion"
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
	else
	{
		header('Location:'.GetURL("dashboard/modulos"));
		die();
	}
	
	AddHistory("Modulos",GetURL("dashboard/modulos"),true);
	AddHistory($row["idmodulo"],"");
?>
<style>
@media only screen and (max-width: 992px) {
	.side-nav {
		z-index: 1000;		
	}
}

body {
	background: white
}	
</style>

<?php require_once("recursos/froalaeditor/editor.php"); ?>

<div id="modMain" class="container" style="width:95%;display:none">
	<div class="card-content">
		<h3 class="light center blue-grey-text text-darken-3">Editar modulo</h3>
		<div class="divider" style="margin-bottom:30px"></div>
		<div>
			<br>
			<textarea id='edit'><?php echo $row["contenido"] ?></textarea>
		</div>
	</div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px; z-index:999">
	<a id="btnGuardar" onclick="OpenModal()" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Guardar">
		<i class="large material-icons">save</i>
	</a>      
</div>

<!--Module data MODAL-->
<div id="datamodal" class="modal create-item modal-fixed-footer">
    <div class="modal-content">
        <h5 style="margin-top:-10px">Editar modulo</h5>        
		<form id="frmModal" autocomplete="off" action="javascript:<?php echo ($editID != "") ? "Editar()":"Agregar()"?>">
			<div class="row card-content">				
				<div class="input-field col s12">
					<label for="txtCodigo">Codigo</label>
					<input id="txtCodigo" type="text" class="validate" disabled required pattern="\S+" title="Sin espacios" maxlength="20" length="20" value="<?php echo $row["idmodulo"] ?>">		
				</div>			
				<div class="input-field col s12">
					<label for="txtTitulo">Titulo</label>
					<input id="txtTitulo" type="text" class="validate" required value="<?php echo $row["modulo"]?>">		
				</div>
				<div class="input-field col s12">
					<label for="txtDescripcion">Descripcion</label>
					<input id="txtDescripcion" type="text" class="validate" required value="<?php echo $row["modulo"]?>">		
				</div>
			</div>			
			<input id="hCodigo" type="hidden" value="<?php echo $row["idmodulo"] ?>">
			<input id="hTitulo" type="hidden" value="<?php echo $row["modulo"] ?>">
			<input id="hDescripcion" type="hidden" value="<?php echo $row["descripcion"] ?>">
			<input id="txtInit" type="hidden" value="<?php echo $editID ?>">
			<input type="submit" style="display:none">
		</form>          
    </div>
    
    <div class="modal-footer">
        <a id="guardar" onclick="$('#frmModal').find(':submit').click();"  class="modal-action btn-flat waves-effect waves-light">Editar</a>        
        <a id="cancel" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div>        

</div>
<!--END Module data MODAL -->

<script>	
	$(function(){
		$('#edit').froalaEditor({
				enter: $.FroalaEditor.ENTER_P, 
				placeholderText: "Escriba algun texto...",
				toolbarInline: false,
				toolbarVisibleWithoutSelection: true,
				zIndex: 999,
				language: 'es',
				imageManagerLoadURL: '<?php echo GetURL("editorutils.php?action=1&id=$editID&prefix=M") ?>',
				imageUploadURL: '<?php echo GetURL("editorutils.php?action=2&id=$editID&prefix=M") ?>',
				imageManagerDeleteURL: '<?php echo GetURL("editorutils.php?action=3&id=$editID&prefix=M")?>'				
			});
		
		$("#modMain").fadeIn();
		$('#edit').froalaEditor('placeholder.refresh');
	});
	
	function Editar()
	{
		var idinit    = $("#txtInit").val();
		var idmodulo  = $("#txtCodigo").val();
		var titulo	  = $("#txtTitulo").val();
		var descripcion = $("#txtDescripcion").val();
		var contenido = $("#edit").val();
		
		if(contenido == "")
			return Materialize.toast('Error contenido no puede ir en blanco', 3000,"red");

		//Check first if form is valid.
		if (!$("#frmModal")[0].checkValidity()) 		
		{
			$("#frmModal").find(':submit').click()
			return;
		}				
		
		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modcrearmodulo/servicecrearmodulo.php?accion=3")?>",
			method: "POST",
			data: {idmodulo:idmodulo,titulo:titulo,contenido:contenido,idinit:idinit,descripcion:descripcion}
		}).done(function(data){			
			//Close animation
			swal.close();
			if(data == "0")
			{
				$('#datamodal').closeModal();
				Materialize.toast('Se edito exitosamente', 3000,"green");
				location.href="<?php echo GetURL('dashboard/modulos')?>";
			}				
			else
			{
				if(data == "104")
					Materialize.toast('Codigo ya existe', 3000,"red");
				else
					Materialize.toast('Error al guardar los datos', 3000,"red");
				
				console.error("Agregar->" + data);				
			}				
		});
		
	}

    //OPEN EDIT MODAL
    function OpenModal()
    { 	
		//Reset
		$("#txtCodigo").val($("#hCodigo").val());
		$("#txtTitulo").val($("#hTitulo").val());
		$("#txtDescripcion").val($("#hDescripcion").val());
						
		Materialize.updateTextFields();
		$('#datamodal').openModal();		
	}							
</script>
