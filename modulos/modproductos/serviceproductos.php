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
        
        
       case 1:
          $Proveedor = $_POST['Proveedor'];
          $Categoria = $_POST['Categoria'];
          
           $stmt = $mysqli->select("productos",[
                    "[><]categoria_producto"=>"idcategoria",
                    "[><]proveedores"=>"idproveedor"
                    
                ],
                                [
                                    "productos.idproducto",                    
                                    "productos.nombre",
                                    "productos.descripcion",
                                    "productos.idcategoria",
                                    "productos.idproveedor"
                                    
                                ],
                                
                                ["ORDER" => "productos.idproducto DESC",
                                "LIMIT"=> 4,
                                "AND"=>[
                                     "proveedores.nombre"=>$Proveedor,
                                    "categoria_producto.nombre"=>$Categoria
                                    
                                ]
                                ]);
                                
                                if(!$stmt)
                                {
                                    if($mysqli->error()[2] != "")
                                        echo "Error:".$mysqli->error()[2];
                                    return;
                                }

                                foreach($stmt as $row){
                                    $content=substr(strip_tags($row["descripcion"]), 0, 150) . "...";
                                    echo 
                                    '
                                        <li id="'.$row["idproducto"].'" class="dataproductos col s12 m6 l6">
                                            <div class="card medium z-depth-1 ">
                                                <div class="card-image waves-effect waves-block waves-light" style="object-fit:cover">
                                                    <img class="responsive-img"  src="'.GetProductImagePath($row["idproducto"], true).'">      
                                                    
                                                </div>
                                                <div class="card-content">
                                                    
                                                    <span class="card-title activator">'.$row["nombre"].'<i class="material-icons right">more_vert</i></span>
                                                </div>
                                                <div class="card-reveal">
                                                    <span class="card-title">'.$row["nombre"].'<i class="material-icons right">close</i></span>                            
                                                    <p class="flow-text">'.$content.'</p>
                                                    <div class="card-action">
                                                <a href="productview/'.$row["idproducto"].'">VER producto</a>
                                                </div>
                                                </div>
                                            
                                            </div>           
                                        </li>
                                    ';
                                }
           break;        
    }
    
?>