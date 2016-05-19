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
                                 <img  class="responsive-img"  style="height:120px;width:100%" src="/sinhco/recursos/img/proyect.jpg">
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
            $Nombre      = $_POST["Nombre"];
            $Descripcion = $_POST["Descripcion"];
           
           
           $last_id = $mysqli->insert("productos",
                [
                    "nombre"    => $Nombre,
                    "descripcion"     => $Descripcion                    
                   
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
                
               
            $mysqli->action(function($mysqli)
				{				
					$idproducto = $_POST['idproducto'];				
					$newnombre = $_POST['nombre-producto'];
                    $newdescripcion = $_POST['descripcion-producto'];
                    $newcategoria = $_POST['categoria-producto'];
                    $newproveedor = $_POST['proveedores-producto'];
                   
								
				
					
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
				echo $idproducto;      
                });
            
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
    
    
    
    