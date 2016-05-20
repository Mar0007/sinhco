<?php
	require_once("../../config.php");
	require_once("../../funciones.php");	
	inicio_sesion();
	
	if(!login_check($mysqli))
	{
		echo "<h2>Acceso denegado</h2>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<h2>No tiene permisos para ver este modulo.</h2>";
		return;
	}
	
	//1 = Consulta; 2 = Insertar; 3 = Actualizar; 4 = Eliminar;
	$accion = $_GET["accion"];
	switch($accion)
	{
		case 1: // Consulta
				$IDproducto = $_POST['IDproducto'];																
				ProyectCard($mysqli,$IDproducto);												
				break;		
		case 2: // Insertar				
            $nombre      	= $_POST["nombre"];
            $descripcion   	    = $_POST["descripcion"];
            $idcategoria    =$_POST["categoria"];
            $idproveedor   =$_POST["proveedor"];
            
            
            $stmt = $mysqli->insert("productos",
                [
                    "nombre"    => $nombre,
                    "descripcion"     => $descripcion,
                    "idcategoria" => $idcategoria,
                    "idproveedor" => $idproveedor
                    
                ]);
                
                     
            if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
				break;
		case 3: //Actualizar 
            $mysqli->action(function($mysqli)
				{				
					$idproducto = $_POST['idproducto'];				
					$newnombre = $_POST['nombre-producto'];
                    $newdescripcion = $_POST['descripcion-producto'];
                    $newcategoria = $_POST['categoria-producto'];
                    $newproveedor = $_POST['proveedor-producto'];
                    $imagen		= $_FILES['imagen-producto']['tmp_name'];
					
				if($imagen != "")
				{
					$target_dir = "../../uploads/images/productos/";
					$imageFileType = pathinfo($_FILES['imagen-producto']['name'],PATHINFO_EXTENSION);  										
					$target_file = $target_dir.$idproducto.".".$imageFileType;
					//echo "Imagen->".$target_file."<br>";
					if(!move_uploaded_file($imagen,$target_file))
					{
						echo "<h5> Imagen no fue actualizada </h5>";
					}
					else
					{
						foreach(glob("../../uploads/images/productos/".$idproducto.".*") as $Img)
						{
							if($Img != $target_file)
								unlink($Img);
						}
					}
				}					
				
					
					$mysqli->update("productos",
						[
                            "nombre" => $newnombre,
                            "descripcion"  => $newdescripcion,
                            "idcategoria" => $newcategoria,
                            "idproveedor" => $newproveedor
                          
                        ],[
							"AND" => 
							[
								"idproducto" => $idproducto
								
							]
						]);
						
						if( CheckDBError($mysqli) ) return false;
				     echo "0"; 
                });
            
            break;
								
		case 4: //Eliminar	
            $IDproducto = $_POST["idproducto"];
			
            $mysqli->delete("productos",
            [
				"AND" =>
            [
				"idproducto" => $IDproducto					
			]
			]);			
                
           if( CheckDBError($mysqli) ) return false;
           echo "0" ;
												
				break;
        case 10: //Insertar Imagen
                $IMGDescripcion = $_POST['img-descripcion'];
                $sourcePath = $_FILES['file']['tmp_name'];
				$targetExt  = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$targetPath = "uploads/images/productos/". uniqid('Producto-', true) . $targetExt;
            	$targetName = basename($_POST['img-title'] , $targetExt);
//				$targetName = basename($_FILES['file']['name'] , $targetExt);
				move_uploaded_file($sourcePath,"../../" . $targetPath);
								
				$last_id = $mysqli->insert("imagenes",
				[
					"img"  => $targetName,
					"ruta" => GetURL($targetPath),
					"categoria" => "Producto",
                    "descripcion" => $IMGDescripcion
				]
				);
				if(CheckDBError($mysqli)) return;
				echo "<a id=\"IMG_".$last_id."\" value=\"".$last_id."\" class=\"uploaded-img no-padding collection-item col s2\" style=\"width:100%;height:auto;\">
						<i class=\"secondary-menu menu-btn material-icons center\" onclick=\"DeleteImage(".$last_id.")\" style=\"position:absolute;cursor:pointer;\">close</i>
						<div class=\"center-align\ style=\"display:none\">
							<img src=\"".GetURL($targetPath)."\" style=\"width:100%;height:auto;\">									
							<span style=\"display:none\" class=\"truncate\">".$targetName."</span>
						</div>
						</a>";	
				break;
		case 11: //Eliminar Imagen
				$IDImagen = $_POST["IDImagen"];
				$Ruta = $mysqli->get("imagenes","ruta",["idimagen" => $IDImagen]);
				
				if(CheckDBError($mysqli)) return;
								
				$mysqli->delete("imagenes",
					[
						"AND" => 
						[
							"idimagen" => $IDImagen
							
						]	
					]
					);			
				
				//array_map('unlink', glob("some/dir/*.txt"));
				@unlink($Ruta);								
				echo $IDImagen;
				break;
		case 12: //Actualizar Imagen
				$IDImagen 	= $_POST["IDImagen"];
				$Imagen 	= $_POST["Imagen"];

				$strSQL = "UPDATE sliderimgs SET imagen = ? WHERE idimagen = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('si',$Imagen,$IDImagen);
					$stmt->execute();
					if($stmt->errno != 0)
					{
						echo $stmt->errno . " : " . $mysqli->error;
						return;
					}
				}
				else
				{
					echo "Error en la consulta: " . $mysqli->error;
					return;
				}
				
				echo "0";
				break;	
        case 13: //Add IMG
            $mysqli->action(function($mysqli)
				{									
					$IDImagen = $_POST["IDImagen"];
					$IDproducto = $_POST["IDproducto"];	                    
					//$IDImgInit  = ((isset($_POST['IDImgInit'])) ? $_POST['IDImgInit'] : $IDImagen);
					
															
					
						$mysqli->insert("productos_img",[
                            "idproducto" => $IDproducto,
                            "idimagen" => $IDImagen
                        ]);
						if(CheckDBError($mysqli)) return false;													
					
					
					
					ProyectCard($mysqli,$IDproducto, $IDImagen);												
						
				});
				break;
		
    
	}
function ProyectCard($mysqli, $IDproducto, $IDImagen = null)
	{
		
		$strSQL = 				
		"SELECT i.idimagen,i.img,i.ruta, i.descripcion
		FROM productos_img s join imagenes i on s.idimagen = i.idimagen 
		WHERE idproducto = " . $mysqli->quote($IDproducto) . ((is_null($IDImagen)) ? "" : " and s.idimagen = ".$mysqli->quote($IDImagen) )."
		GROUP BY idimagen ORDER BY idimagen DESC;";
																		
		$stmt = $mysqli->query($strSQL);								
		if(CheckDBError($mysqli) || !$stmt) return;												
		$stmt = $stmt->fetchAll();
		
		foreach ($stmt as $row) 
		{
			echo "
        <li id=\"IMG_".$row["idimagen"]."\" class=\"dataproductos col s12 m6 l8\">
							<div class=\"card hoverable\">
                                <div class=\"card-image waves-effect waves-block waves-light\">
                                    <img class=\"responsive-img\" src=\"".$row["ruta"]."\">      
                                    <span class=\"card-title\">".$row["img"]."</span>
                                </div>                                
                                <div class=\"card-content\">                                    
                                   <p class=\"\">".$row["descripcion"]."</p>
                                </div>
                                <div class=\"card-action\">
                                  <a style=\"cursor:pointer;\" onclick=\"DeleteImage(".$row["idimagen"].")\">eliminar</a>
                                </div>
                            </div>           
						</li>
           ";		
					
				
		}
		
	}
?>

