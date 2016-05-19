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
    
    $accion = $_GET["accion"];
	switch ($accion) {
        
        
        case 1://Select
            
                
  
            
            $stmt = $mysqli->select("productos",
                [
                    "[><]categoria_producto"=>"idcategoria",
                    "[><]proveedores"=>"idproveedor"
                    
                ],
                [
                    "productos.idproducto",
                    "productos.nombre",
                    "productos.estado",
                    "productos.precio",
                    "productos.descripcion",
                    "productos.idproveedor",
                    "productos.idcategoria",
                    "categoria_producto.nombre(Cnombre)",
                    "proveedores.nombre(Pnombre)"
                    
                ],                
                [   
                   
                    "ORDER" => "idproducto ASC"
                ]);
              /*  
                // para ver el contenido de la consulta
                echo"<pre>";
                var_dump($stmt);
                 echo "</pre>";
            */
                if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
                
                foreach($stmt as $row){
                    echo 
                                        
                    '<li id="Card_'.$row["idproducto"].'">
                        <a href="crearproducto/'.$row["idproducto"].'">';                                             
                       
                        echo ' 
                        <div class="col s12 m4 l4"> 
                        <div class="card custom-small">
                            
                            <div class="card-image">
                                <img id="ProyectImage" class="responsive-img" style="height:120px;width:100%; object-fit:cover" src="'.GetProductImagePath($row["idproducto"], true).'">
                            </div>
                        
                            <div class="card-content-custom">                          
                                 <div class="black-text card-title-small">'.$row["nombre"].'</div>
                                 <div class="grey-text card-subtitle-small">'.$row["descripcion"].'</div>                     
                            </div>
                            
                        </div>
                        </div>
                            </a>
                    </li>
              ';
				}
                
                 
            break;
        case 2://Insert
           		
			$newnombre = $_POST['nombre-producto'];
            $newdescripcion = $_POST['descripcion-producto'];
            $newcategoria = $_POST['categoria-producto'];
            $newproveedor = $_POST['proveedores-producto'];
           
           
           $last_id = $mysqli->insert("productos",
                [
                    "nombre" => $newnombre,
                     "descripcion"  => $newdescripcion,
                     "idcategoria" => $newcategoria,
                     "idproveedor" => $newproveedor                 
                   
                ]);
                
                     
            if(!$last_id)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
                echo $last_id;
				break;
        case 3:  //update
                
               
          
            break;
            
            
        case 4:// delete
            $mysqli->action(function($mysqli)
				{
					$IdProductos = $_POST["IdProductos"];
				

					$mysqli->delete("productos",
					[
						"AND" => 
						[
							"idproducto" => $IdProductos
							
						]	
					]
					);										
					if( CheckDBError($mysqli) ) return false;				
					
																			
					echo "0";					
				});
            break;
        default:
            echo "aa";
            break;
       
       
     
    } 
    
    
    
    