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
            # code...
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
					'
                        <div class="col l4 s12 dataproductos">
		                    
                                
                                    <div class="card " >
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <img class="activator" src="/sinhco/recursos/img/proyect.jpg">
                                        </div>
                                        
                                        <div class="card-content">
                                            <span style="margin-bottom:50px" class="card-title activator grey-text text-darken-4">'.$row["nombre"].'</span>  
                                            <h6>'.$row["Pnombre"].'</h6>            
                                        </div>
                                        <div class="card-action" style="position:relative" >
                                            <a href="#"><i class="material-icons left">mode_edit</i>Editar</a>
                                            <a href="#"><i class="material-icons ">delete</i>Borrar </a>
                                            
                                        </div>
                                        
                                        <div class="card-reveal"  style="margin-top:15px">
                                            <span class="card-title grey-text text-darken-4">'.$row["nombre"].'<i class="material-icons right">close</i></span>
                                            <p>'.$row["Cnombre"].'</p>
                                            <p>'.$row["descripcion"].'</p>
                                            
                                        </div>
                                        
                                    </div>
                                
                            
                         </div>
                    
          
					';
				}
            break;
        case 2://Insert
            $Nombre      = $_POST["txtNombre"];
            $Descripcion = $_POST["txtDescripcion"];
            $Categorias  = $_POST["cbCategorias"];
            $Proveedor = $_POST["txtProveedor"];
			
            
            $stmt = $mysqli->insert("productos",
                [
                    "nombre"    	=> $Nombre,
                    "descripcion"     => $Descripcion,
                    "idcategoria"     => $Categorias,
                    "idproveedor" => $Proveedor
                ]);
                
                     
            if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
				break;
        
        default:
            echo "aa";
            break;
    } 
    