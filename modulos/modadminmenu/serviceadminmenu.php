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
				$idMenu = $_POST['IDMenu'];
                $stmt = $mysqli->select("menu_detalle",
                [
                    "iditem","itemmenu","vinculo","orden","icono"
                ],
                [
                    "idmenu" => $idMenu,
                    "ORDER" => "orden ASC"
                ]);
                
                if(!$stmt)
                {
                    if($mysqli->error()[2] != "")
                        echo "Error:".$mysqli->error()[2];
                    
                    return;
                }
                
                foreach($stmt as $row)
                    echo GetDataHTML($row);
        
				break;		
		case 2: // Insertar				
                $mysqli->action(function($mysqli)
                {
                    $IDMenu		= $_POST["IDMenu"];
                    $Titulo   	= $_POST["Titulo"];
                    $Vinculo   	= $_POST["Vinculo"];
                    $Orden   	= $_POST["Posicion"];
                    $IDIcon   	= $_POST["IDIcon"];
                    
                    //Renumber database Order.
                    $mysqli->update("menu_detalle", ["orden[+]" => 1],
                    [
                        "AND" => 
                        [
                            "idmenu" => $IDMenu,
                            "orden[>=]" => $Orden
                        ]
                    ]);                                                
                    if( CheckDBError($mysqli) ) return false;
                                    
                    //Get IDItem
                    $IDItem = $mysqli->max("menu_detalle","iditem",["idmenu" => $IDMenu]) + 1;   
                    if( CheckDBError($mysqli) ) return false;
                    
                    //Insert all data
                    $Data = 
                    [
                        "idmenu" => $IDMenu,
                        "iditem" => $IDItem,
                        "itemmenu" => $Titulo,
                        "vinculo" => $Vinculo,
                        "orden" => $Orden,
                        "icono" => $IDIcon
                    ];                                                        
                    $mysqli->insert("menu_detalle",$Data);                    
                    if( CheckDBError($mysqli) ) return false;
                                        
                    echo GetDataHTML($Data);                                				
                });                
                
				break;
		case 3: //Actualizar                                
                $mysqli->update("menu_detalle", 
                [
                    "itemmenu" => $_POST["Titulo"],
                    "vinculo" => $_POST["Vinculo"],
                    "orden" => $_POST["Posicion"],
                    "icono" => $_POST["IDIcon"]
                ],
                [
                    "AND" =>
                    [
                        "idmenu" => $_POST["IDMenu"],
                        "iditem" => $_POST["IDItem"]
                    ]
                ]);
                
                if( CheckDBError($mysqli) ) return;                
                echo "0";
                
				break;
				
		case 4: //Eliminar
				$IDItem = $_POST["IDItem"];
				$IDMenu = $_POST["IDMenu"];
				$Orden	= $_POST["Posicion"];

				$strSQL = "DELETE FROM menu_detalle WHERE iditem = ? and idmenu = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ii',$IDItem,$IDMenu);
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

				//Renumber database Order.
				$strSQL   = "UPDATE menu_detalle SET orden = orden - 1 WHERE idmenu = ? and orden >= ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('ii',$IDMenu,$Orden);
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
				
		case 5: //Update Order
				//Renumber database Order.
				$IDMenu = $_POST['IDMenu'];				
				$Orden = 0;
                
                foreach ($_POST['Row'] as $IDItem) 
                {
                    $mysqli->update("menu_detalle",["orden" => $Orden++],
                    [
                        "AND" => 
                        [
                            "idmenu" => $IDMenu,
                            "iditem" => $IDItem
                        ]
                    ]);
                    
                    if( CheckDBError($mysqli) ) return;
                }
                
				echo "0";
				break;
		case 6: //Insert Menu
				$Menu = $_POST['Titulo'];																															
				$strSQL   = "INSERT INTO menus(menu) VALUES (?);";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('s',$Menu);
					$stmt->execute();
					if($stmt->errno != 0)
						echo $stmt->errno . " : " . $mysqli->error;
					else
						echo "<option value=\"$mysqli->insert_id\">$Menu</option>";										
				}
				else
					echo "Error en la consulta: " . $mysqli->error;
		
				break;		
		case 7: //Delete Menu
				$IDMenu = $_POST["IDMenu"];
				$strSQL = "DELETE FROM menus WHERE idmenu = ?";
				if( $stmt = $mysqli->prepare($strSQL) )
				{
					$stmt->bind_param('i',$IDMenu);
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
	}
	
	function GetMenuArray()
	{
		//Datarow menu
		return array(
			array
			(
				"href" 		=> "javascript:OpenModal('%id')",
				"icon" 		=> "edit",
				"contenido" => "Editar"
			),
			array
			(
				"href" 		=> "javascript:Eliminar('%id')",
				"icon" 		=> "delete",
				"contenido" => "Eliminar"
			)
		);		
	}
    
    
    function GetDataHTML($Data)
    {
        return 
        '
            <tr class="datarows1" id="Row_'.$Data["iditem"].'" style="display:none">
                <td class="ordermenu" init="'.$Data["orden"].'">
                    <i class="material-icons left handler-class" style="cursor:move">reorder</i> 
                    <span>'.$Data["orden"].'</span>
                </td>
                <td><i class="material-icons">'.$Data["icono"].'</i></td>
                <td>'.$Data["itemmenu"].'</td>
                <td>'.$Data["vinculo"].'</td>
                <td><div class="center">'.GetDropDownSettingsRow($Data["iditem"],GetMenuArray()).'</div></td>
            </tr>        
        ';
    }	
?>
