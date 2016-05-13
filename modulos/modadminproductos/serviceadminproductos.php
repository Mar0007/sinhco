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
        case 0: //paginacion
            # code...
             $abc = $mysqli->select("productos",
            [
                "productos.idproducto",
                    "productos.nombre"
            ],
            [
                "LIMIT"=>[6,1] ,
                 "ORDER" => "idproducto ASC"
            ]);
            
              
                // para ver el contenido de la consulta
                echo"<pre>";
                var_dump($abc);
                 echo "</pre>";
            break;
        case 1://Select
            # code...
            /*
            $abc = $mysqli->select("productos",
            [
                "productos.idproducto",
                    "productos.nombre"
            ],
            [
                // desde el registro 1 hasta el 6
                "LIMIT"=>[0,6] ,
                
                 "ORDER" => "idproducto ASC"
            ]);
            
              
                // para ver el contenido de la consulta
                echo"<pre>";
                var_dump($abc);
                 echo "</pre>";
            
            */
           
         
         
                
               $d=0;
               $h=6;
           
            
            
           
            
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
                    "LIMIT"=>[$d,$h] ,
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
                    /*
					'
                        <div id="Card_'.$row["idproducto"].'" class="col l4 s12 dataproductos">
		                    
                                
                                    <div class="card " >
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <img class="activator" src="/sinhco/recursos/img/proyect.jpg">
                                        </div>
                                        
                                        <div class="card-content">
                                            <span style="margin-bottom:50px" class="card-title activator grey-text text-darken-4">'.$row["nombre"].'</span>  
                                            <h6>'.$row["Pnombre"].'</h6>            
                                        </div>
                                        <div class="card-action" style="position:relative" >
                                            <a href="javascript:OpenModal('.$row["idproducto"].')"><i class="material-icons left">mode_edit</i>Editar</a>
                                            <a href="javascript:Eliminar('.$row["idproducto"].')"><i class="material-icons ">delete</i>Borrar </a>
                                            
                                        </div>
                                        
                                        <div class="card-reveal"  style="margin-top:15px">
                                            <span class="card-title grey-text text-darken-4">'.$row["nombre"].'<i class="material-icons right">close</i></span>
                                            <p>'.$row["Cnombre"].'</p>
                                            <p>'.$row["descripcion"].'</p>
                                            
                                        </div>
                                        
                                    </div>
                                
                            
                         </div>
                    
          
					';*/
                    
                    '<div id="Card_'.$row["idproducto"].'" class="col s4 dataproductos">
                     
                        <div class="card ">
                            
                            <div class="card-image waves-effect waves-block waves-light">
                           
                                <img  src="/sinhco/recursos/img/proyect.jpg">
                            </div>
                        
                            <div class="card-content custom-content">                          
                                <p >'.$row["nombre"].'</p>    
                                 <p style="display:none">'.$row["descripcion"].'</p>                     
                            </div>
                            
                            <div class="card-action-custom" style="position:relative" >
                                <a href="javascript:Seleccionar('.$row["idproducto"].')" class="waves-effect waves-light btn">Seleccionar</a>                                            
                            </div>
                       
                        </div>
                    </div>
              ';
				}
            break;
        case 2://Insert
            $Nombre      = $_POST["Nombre"];
            $Descripcion = $_POST["Descripcion"];
            $Estado      = $_POST["Estado"];
            $Precio = $_POST["Precio"];
            $IdProveedor      = $_POST["IdProveedor"];
            $IdCategoria = $_POST["IdCategoria"];
            
            
			
            
            $last_id = $mysqli->insert("productos",
                [
                    "nombre"    	=> $Nombre,
                    "descripcion"     => $Descripcion,
                    "estado"  =>$Estado ,
                    "precio"  =>$Precio ,
                    "idproveedor"  =>$IdProveedor ,
                    "idcategoria"  =>$IdCategoria 
                    
                ]);
                
                     
                    if($mysqli->error()[2] != "")
                    {
                        echo "Error:".$mysqli->error()[2];
                        return;                        
                    }
                    
            echo 
            /*'
                        <div id="Card_'.$last_id.'" class="col l4 s12 dataproductos">
		                    
                                
                                    <div class="card " >
                                        <div class="card-image waves-effect waves-block waves-light">
                                            <img class="activator" src="/sinhco/recursos/img/proyect.jpg">
                                        </div>
                                        
                                        <div class="card-content">
                                            <span style="margin-bottom:50px" class="card-title activator grey-text text-darken-4">'.$Nombre.'</span>  
                                            <h6>'.$IdProveedor.'</h6>            
                                        </div>
                                        <div class="card-action" style="position:relative" >
                                            <a href="#"><i class="material-icons left">mode_edit</i>Editar</a>
                                            <a href="#"><i class="material-icons ">delete</i>Borrar </a>
                                            
                                        </div>
                                        
                                        <div class="card-reveal"  style="margin-top:15px">
                                            <span class="card-title grey-text text-darken-4">'.$Nombre.'<i class="material-icons right">close</i></span>
                                            <p>'.$IdCategoria.'</p>
                                            <p>'.$Descripcion.'</p>
                                            
                                        </div>
                                        
                                    </div>
                                
                            
                         </div>
                    
          
					';*/
                    '<div id="Card_'.$last_id.'" class="col s4 dataproductos">
                        <div class="card">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img  src="/sinhco/recursos/img/proyect.jpg">
                            </div>
                        
                            <div class="card-content custom-content">                          
                                <a >'.$Nombre.'</a>     
                                 <p style="display:none">'.$Descripcion.'</p>                   
                            </div>
                            
                             <div class="card-action-custom" style="position:relative" >
                                <a href="javascript:Seleccionar('.$last_id.')" class="waves-effect waves-light btn">Seleccionar</a>                                            
                            </div>
                       
                        </div>
                    </div>
              ';
              
				break;
        case 3:  //update
                
                $Nombre 	   = $_POST["Nombre"];
				$Descripcion   	= $_POST["Descripcion"];
                $IdProductos    =$_POST["IdProductos"];
				
				
				$mysqli->update("productos",
				[
					"nombre" => $Nombre,
					"descripcion" => $Descripcion					
				],
				[
                    "AND"=>[
                        "idproducto"=>$IdProductos
                    ]
					
				]);
				if( CheckDBError($mysqli) ) return;
				
				echo "0";
            
            
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
    