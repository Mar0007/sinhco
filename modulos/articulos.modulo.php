<?php
	global $mysqli;
	global $SEGURIDAD;
	
	if($SEGURIDAD != 1)
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}
	
	
	if(isset($_GET['idarticulo']))
	{
		$IDArticulo = $_GET['idarticulo'];
		$bAdmin = login_check($mysqli) && esadmin($mysqli);

		$strSQL = 
		"SELECT titulo, contenido, fecha, idusuario, tags, estado
		FROM mod_articulos 
		WHERE idarticulo = ?
		ORDER BY fecha";
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('i',$IDArticulo);				
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($Titulo,$Contenido,$Fecha,$IDUsuario,$Tags,$Estado);
			if(!$stmt->fetch())
			{
				echo "<h5>404: No existe el articulo solicitado.</h5>";
				return;
			}
			
			if($Estado == 0 && !$bAdmin)
			{
				echo "<h5>Acceso Denegado. No tiene permiso para ver este Articulo</h5>";
				return;
			}
		}				
		
		$Contenido = AddAttributeToTag($Contenido,'img','class','responsive-img materialboxed');
		
		//Start Post
		echo '<div class="Post card">';		
		
		$SrcImage = GetFirstImage($Contenido,true);
		//var_dump(getimagesize($SrcImage));
		if($SrcImage != "")
		{
			echo '<div class="card-image"><img src="'.$SrcImage.'" style="height:250px;filter: blur(25px);-webkit-filter: blur(25px);"></div>';
			echo "<div class=\"center\" style=\"margin-top:-230px; margin-bottom:5px; \"><img class=\"responsive-img\" src=\"$SrcImage\" style=\"position:relative;height:200px;z-index: 2;padding: 5px 5px\"></div>";
		}
		
		echo '<a href="index.php?mod=articulos" class="btn-floating btn waves-effect waves-light tooltipped blue" style="margin-top:10px;margin-bottom:-30px;margin-left:5px" data-tooltip="Regresar"><i class="material-icons">arrow_back</i></a>';
		
		echo '<div class="card-content">					
					<h4 class="header"><a>'.$Titulo.'</a></h4>';
		echo '<div class="divider"></div><br>';
		echo $Contenido .
			 '</div>';
			 
		
		//Author
		echo "<div class=\"card-author chip\"><img src=\"".GetUserImagePath($IDUsuario)."\" alt=\"\">$IDUsuario</div>";
		echo "<p class=\"\" style=\"font-size:13px;font-weight:500;color:rgba(0,0,0,0.6);margin-left:15px;margin-top:-5px\">$Fecha</p>";		
		
		echo "<div class=\"card-action\"><a><i class=\"material-icons\">collections_bookmark</i>Tags:</a>";
		foreach(explode(",",$Tags) as $tag)
			echo "<div class=\"chip\">$tag</div>";
		
		if($bAdmin)
		{
			//Buttons			
			echo "<br><button class=\"btn waves-effect waves-light\" onclick=\"location.href='index.php?mod=creararticulo&idarticulo=$IDArticulo'\" style=\"margin-top:15px;margin-right:5px\">Editar
						<i class=\"material-icons right\">edit</i>
					</button>";
					
			echo "<button class=\"btn waves-effect waves-light red\" onclick=\"Eliminar('$IDArticulo')\" style=\"margin-top:15px;\">Eliminar
					<i class=\"material-icons right\">delete</i>
				</button>";
				
		}
				
		echo "</div></div>";
		?>
		<script>
		//Functions			
		function Eliminar(id)
		{		
			swal({
				title:  "¿Eliminar Articulo?" ,
				text: "¿Esta seguro que desea eliminar este articulo?",
				type: "warning",
				showCancelButton: true,
				closeOnConfirm: false,
				showLoaderOnConfirm: true,
				},
				function(){
				$.ajax({
					url:"modulos/modadminarticulos/serviceadminarticulos.php?accion=4",
					method: "POST",
					data: {idarticulo:id}
				}).done(function(data){
					if(data == "0")
					{
						$("#"+id).fadeOut(function(){
							$(this).remove();
						});
						swal({title:"Borrado",text:"Se borro exitosamente.",type:"success"},
						function(){
							location.href = "index.php?mod=articulos";
						});
					}
					else
						swal("Error", data, "error");
				});				
			});							
		}	
		</script>
		<?php
		return;
	}
?>			

<h1 class="blue-text text-darken-1"><i class="material-icons medium left">local_library</i>Articulos</h1>
<div id="MainArticles">	
</div>

<script>
  //Loader
  var HTMLLoader = 
	"<div class=\"col s12 center TabLoader\" style=\"margin-top: 1%\">" +
	"<div class=\"preloader-wrapper big active\">"+
	"<div class=\"spinner-layer spinner-blue-only\">"+
	"<div class=\"circle-clipper left\">"+
	"<div class=\"circle\"></div>"+
	"</div><div class=\"gap-patch\">"+
	"<div class=\"circle\"></div>"+
	"</div><div class=\"circle-clipper right\">"+
	"<div class=\"circle\"></div>"+
	"</div></div></div></div>";	
	
	
	$(document).ready(function(){
		$(document).scrollTop(1);
		GetArticulos(-1);
	});
		
	function GetArticulos(LastID)
	{
		//Insert Loader animation
		$('#MainArticles').append(HTMLLoader);
		
		//Request data
		$.ajax({
				url:"modulos/modarticulos/servicearticulos.php?accion=1",
				method: "POST",
				data: {LastID:LastID}
		}).done(function(data){
				//Remove Loader
				$('#MainArticles').find('.TabLoader').remove();
				
				if(data == "no_more")
					return;
				
				if(data.indexOf("<div") > -1)
				{					
					$('#MainArticles').append(data);
					//Materialize.toast('LastID='+$('#MainArticles').children().last().attr('dbid'), 5000);
					
					var DataLastID = $('#MainArticles').children().last().attr('dbid');
					var options = [
						{selector: '#Atr_'+DataLastID, offset: 500, callback: 'GetArticulos("'+DataLastID+'")'}
					];
					Materialize.scrollFire(options);					
				}
				else
				{
					Materialize.toast('Error al obtener articulos!', 5000);
					console.error(data);					
				}
		});				
	}
</script>