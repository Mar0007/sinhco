<?php
	require_once("../../config.php");
	require_once("../../funciones.php");	
	inicio_sesion();	
	
	$accion = $_GET["accion"];
	switch($accion)
	{
		case 1: //Consulta
			   	$LastID = $_POST['LastID'];
				$bAdmin = login_check($mysqli) && esadmin($mysqli);

				$strSQL = 
				"SELECT idarticulo, titulo, contenido, fecha, idusuario, tags
				FROM mod_articulos 
				WHERE estado = 1". (($LastID != -1) ? " and idarticulo < ?" : "") ."
				ORDER BY fecha DESC LIMIT 2";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					if($LastID != -1)
						$stmt->bind_param('i',$LastID);
						
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($IDArticulo,$Titulo,$Contenido,$Fecha,$IDUsuario,$Tags);
					while ( $stmt->fetch() )
					{                  
						echo "<div id=\"Atr_$IDArticulo\" dbid=\"$IDArticulo\" class=\"row\"><div class=\"card hoverable\">";
						//Content image
						$SrcImage = GetFirstImage($Contenido);
						if($SrcImage != "")
						{
							echo "<div class=\"card-image center\"><img src=\"$SrcImage\" style=\"filter: blur(25px);-webkit-filter: blur(25px);\"></div>";
							echo "<div class=\"center\" style=\"margin-top:-190px; \"><img class=\"responsive-img\" src=\"$SrcImage\" style=\"position:relative;height:200px;z-index: 2;padding: 5px 5px\"></div>";
						}
						
						//Content Text
						echo "<div class=\"card-content\"><span class=\"card-title black-text\"><a href=\"index.php?mod=articulos&idarticulo=$IDArticulo\">$Titulo</a></span>
							<p></p>".limit_text(strip_tags($Contenido),100)."</div>";
							
						//Author
						echo "<div class=\"card-author chip\"><img src=\"".GetUserImagePath($IDUsuario)."\" alt=\"\">$IDUsuario</div>";
						echo "<p class=\"\" style=\"font-size:13px;font-weight:500;color:rgba(0,0,0,0.6);margin-left:15px;margin-top:-5px\">$Fecha</p>";	
						
						//Tags            
						echo "<div class=\"card-action\"><a><i class=\"material-icons\">collections_bookmark</i>Tags:</a>";            
						foreach(explode(",",$Tags) as $tag)
							echo "<div class=\"chip\">$tag</div>";
							
						//Buttons		
						echo "<br><button class=\"btn waves-effect waves-light blue-grey\" onclick=\"location.href='index.php?mod=articulos&idarticulo=$IDArticulo'\" style=\"margin-top:15px;margin-right:5px\">Leer Mas+
								<i class=\"material-icons right\">open_in_browser</i>
							</button>";
							
						if($bAdmin)
							echo "<button class=\"btn waves-effect waves-light\" onclick=\"location.href='index.php?mod=creararticulo&idarticulo=$IDArticulo'\" style=\"margin-top:15px;\">Editar
									<i class=\"material-icons right\">edit</i>
								</button>";
							
						//End Card-Action
						echo "</div>";
						
						//End Row
						echo "</div></div>";
					}
					
					if( $stmt->num_rows == 0 )
						echo 'no_more';
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
					
			   break;	
		case 2: //Insertar		
		case 3: //Actualizar
		case 4: //Eliminar												
	}	
?>