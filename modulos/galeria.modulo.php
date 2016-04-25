<?php
	global $mysqli;		
?>
  
  <div class="row">  
<?php

	if(!isset($_GET['idalbum']))
	{
		//Get Images cards
		$strSQL = 
		"SELECT idalbum,descripcion,portada, (SELECT COUNT(*) FROM mod_galeria_albumesdetalle x WHERE x.idalbum = a.idalbum) as ContImg
		FROM mod_galeria_albumes a";
		
		$bAdmin = login_check($mysqli) && esadmin($mysqli); 
			
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($IDImagen,$Descripcion,$Portada, $Cont);										
			while ( $stmt->fetch() )
			{
				echo "<div id=\"$IDImagen\" class=\"col s12 m6\"><div class=\"card\" style=\"position:relative\"><div class=\"card-image waves-effect waves-block waves-light\">";
				echo "<img src=\"$Portada\" onclick=\"location.href='index.php?mod=galeria&idalbum=$IDImagen'\"></div><div class=\"card-content\">";
				
				if($bAdmin)
					echo "<span class=\"card-title activator grey-text text-darken-4 truncate\"><i class=\"AlbumTitle\">$Descripcion</i><i class=\"material-icons right\">more_vert</i></span>";
				else
					echo "<span class=\"card-title grey-text text-darken-4 AlbumTitle truncate\">$Descripcion</span>";
				
				echo "<p><i class=\"material-icons left\">camera_roll</i>$Cont</p></div>";
				echo "<div class=\"card-reveal\"><span class=\"card-title grey-text text-darken-4\"><i class=\"AlbumTitle\">$Descripcion</i><i class=\"material-icons right\">close</i></span>";
				
				if($bAdmin)
				{
					echo "<span>Opciones de Administrador</span>
							<div class=\"collection\">
								<a href=\"javascript:EliminarAlbum($IDImagen)\" class=\"collection-item\">Eliminar Album</a>
								<a href=\"javascript:EditarAlbum($IDImagen)\" class=\"collection-item\">Modificar Titulo</a>
							</div>";
				}
				echo "</div></div></div>";
			}
		}
		else
		{
			echo "Error en la consulta: " . $mysqli->error;
		}					
	}
	else
	{
		$IDAlbum = $_GET['idalbum'];
		
		//Send it to client so he can use it later.		
		echo "<input id=\"AlbumID\" type=\"hidden\" value=\"$IDAlbum\" >";
				
		
		//Get Title of Album
		$strSQL = "SELECT descripcion FROM mod_galeria_albumes WHERE idalbum = ?";		
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('i',$IDAlbum);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($AlbumDescripcion);										
			
			if(!$stmt->fetch())
			{
				echo "<h5>No existe el album</h5>";
			}
		}
		
		echo "<br><a class=\"btn-floating btn-large waves-effect waves-light\" href=\"index.php?mod=galeria\"><i class=\"material-icons\">arrow_back</i></a>";
		//echo "<div class=\"divider\"></div>";
		echo "<h4>Galeria: $AlbumDescripcion</h4>";
		
		
		//Get Images cards
		$strSQL = 
		"SELECT idimagen, descripcion, archivo FROM mod_galeria_albumesdetalle WHERE idalbum = ?";		
		$bAdmin = login_check($mysqli) && esadmin($mysqli);
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('i',$IDAlbum);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($IDImagen,$Descripcion,$Archivo);										
			while ( $stmt->fetch() )
			{
				echo "<div id=\"$IDImagen\" class=\"col s12 m6\"><div class=\"card\" style=\"position:relative\"><div class=\"card-image waves-effect waves-block waves-light\">";
				echo "<img src=\"$Archivo\" class=\"materialboxed\"></div><div class=\"card-content\">";
				
				if($bAdmin)
					echo "<span class=\"card-title activator grey-text text-darken-4 truncate\"><i class=\"AlbumTitle\">$Descripcion</i><i class=\"material-icons right\">more_vert</i></span>";
				else
					echo "<span class=\"card-title grey-text text-darken-4 AlbumTitle truncate\">$Descripcion</span>";				
				
                echo "</div>";
                				
				if($bAdmin)
				{
                    echo "<div class=\"card-reveal\"><span class=\"card-title grey-text text-darken-4\"><i class=\"AlbumTitle\">$Descripcion</i><i class=\"material-icons right\">close</i></span>";
					echo "<span>Opciones de Administrador</span>
							<div class=\"collection\">
								<a href=\"javascript:EliminarImagen($IDImagen)\" class=\"collection-item\">Eliminar Imagen</a>
								<a href=\"javascript:EditarImagen($IDImagen)\" class=\"collection-item\">Modificar Titulo</a>
							</div></div>";
				}
				echo "</div></div>";
			}
		}
		else
		{
			echo "Error en la consulta: " . $mysqli->error;
		}							
	}
?>
</div>


<script>	
	
	function EliminarAlbum(id)
	{				
		swal({
			title:  "¿Eliminar album seleccionado?" ,
			text: "¿Esta seguro que desea eliminar el album seleccionado?",
			type: "warning",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
			},
			function(){
			$.ajax({
				url:"modulos/modgaleria/servicegaleria.php?accion=4",
				method: "POST",
				data: {IDAlbum:id}
			}).done(function(data){
				if(data == "0")
				{
					$("#"+id).fadeOut(function(){
						$(this).remove();
					});
					swal("Borrado", "Se borro exitosamente.", "success");					
				}
				else
					swal("Error", data, "error");
			});				
		});		
	}
	
	function EditarAlbum(id)
	{		
		swal({
			title: "Editar Titulo",
			type: "input",
			inputValue: $("#"+id).find('.AlbumTitle').html(),		
			imageUrl: 	encodeURI($("#"+id).find('img').attr('src')),
			showCancelButton: true,
			closeOnConfirm: false,
			inputPlaceholder: "Titulo del album"
			},
			function(inputValue){
			if (inputValue === false) return false;
			
			if (inputValue === "") {
				swal.showInputError("El album necesita tener un titulo valido.");
				return false
			}
			
			ShowLoadingSwal();
			
			$.ajax({
				url:"modulos/modgaleria/servicegaleria.php?accion=5",
				method: "POST",
				data: {IDAlbum:id,Titulo:inputValue}
			}).done(function(data){
				if(data == "0")
				{
					$("#"+id).fadeOut(function(){
						$('#' + id +' .AlbumTitle').html(inputValue);
						$(this).fadeIn();
					});			
					swal("Guardado", "Se guardaron los cambios exitosamente.", "success");
				}
				else
					swal("Error", data, "error");
			});		  								
		});		
	}
	
	
	function EliminarImagen(id)
	{				
		var IDAlbum = $('#AlbumID').val();
		swal({
			title:  "¿Eliminar la imagen seleccionado?" ,
			text: "¿Esta seguro que desea eliminar la imagen seleccionado?",
			type: "warning",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
			},
			function(){
			$.ajax({
				url:"modulos/modgaleria/servicegaleria.php?accion=6",
				method: "POST",
				data: {IDAlbum:IDAlbum,IDImagen:id}
			}).done(function(data){
				if(data == "0")
				{
					$("#"+id).fadeOut(function(){
						$(this).remove();
					});
					swal("Borrado", "Se borro exitosamente.", "success");					
				}
				else
					swal("Error", data, "error");
			});				
		});		
	}
	
	function EditarImagen(id)
	{
		var IDAlbum = $('#AlbumID').val();
		swal({
			title: "Editar Titulo",
			type: "input",
			inputValue: $("#"+id).find('.AlbumTitle').html(),		
			imageUrl: 	encodeURI($("#"+id).find('img').attr('src')),
			showCancelButton: true,
			closeOnConfirm: false,
			inputPlaceholder: "Titulo del album"
			},
			function(inputValue){
			if (inputValue === false) return false;
			
			if (inputValue === "") {
				swal.showInputError("La imagen necesita tener un titulo valido.");
				return false
			}
			
			ShowLoadingSwal();
			
			$.ajax({
				url:"modulos/modgaleria/servicegaleria.php?accion=7",
				method: "POST",
				data: {IDAlbum:IDAlbum,Titulo:inputValue,IDImagen:id}
			}).done(function(data){
				if(data == "0")
				{
					$("#"+id).fadeOut(function(){
						$('#' + id +' .AlbumTitle').html(inputValue);
						$(this).fadeIn();
					});			
					swal("Guardado", "Se guardaron los cambios exitosamente.", "success");
				}
				else
					swal("Error", data, "error");
			});		  								
		});		
	}	
	
</script>