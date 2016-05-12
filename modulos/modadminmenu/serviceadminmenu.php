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
                    "iditem","itemmenu","vinculo","orden","icono","submenus"
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
                    echo GetDataHTML($row,$stmt);
        
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
                        "icono" => $IDIcon,
						"submenus" => ""
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
				$mysqli->action(function($mysqli)
				{
					$IDItem = $_POST["IDItem"];
					$IDMenu = $_POST["IDMenu"];
					$Orden	= $_POST["Posicion"];

					$mysqli->delete("menu_detalle",
					[
						"AND" => 
						[
							"iditem" => $IDItem,
							"idmenu" => $IDMenu	
						]	
					]
					);										
					if( CheckDBError($mysqli) ) return false;				
					
					//Renumber database Order.
					$mysqli->update("menu_detalle", ["orden[-]" => 1],
					[
						"AND" => 
						[
							"idmenu" => $IDMenu,
							"orden[>=]" => $Orden
						]
					]);                                                
					if( CheckDBError($mysqli) ) return false;															
					echo "0";					
				});
								
				break;				
		case 5: //Update Order
				//Renumber database Order.											
				$IDMenu = $_POST['IDMenu'];
				$JData = json_decode($_POST['JSONData'],true);
				
				$mysqli->pdo->beginTransaction();				
				
				foreach ($JData as $key => $val) 
				{					
					if(isset($val["children"]))
					{
						if(!UpdateChildren($mysqli,$val["children"],$IDMenu))
						{
							echo "::1";
							$mysqli->pdo->rollBack();
							return;
						}
					}
					else
						$val["children"] = "";					
					
					$mysqli->update("menu_detalle",
					[
						"orden" => $key,
						"(JSON) submenus" => $val["children"]
					],
					[
						"AND" => 
						[
							"idmenu" => $IDMenu,
							"iditem" => $val["id"]
						]
					]);
					
					if( CheckDBError($mysqli) )
					{
						$mysqli->pdo->rollBack();
						echo "::2";
						return;
					}					
				}
				
				$mysqli->pdo->commit();
				echo "0";
				
				//echo print_r(json_decode($JData));				
				/*
				$mysqli->action(function($mysqli)
				{				
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
						
						if( CheckDBError($mysqli) ) return false;
					}
					
					echo "0";
				});
				*/
				
				
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
				
				$mysqli->delete("menus",["idmenu" => $IDMenu]);								
				if( CheckDBError($mysqli) ) return;							
					
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
    
    
    function GetDataHTML($row,$stmt = null,$bIsChild = false)
    {
		if($row["orden"] == -1 && !$bIsChild)
			return '';
		
		return 
		'
			<li id="Row_'.$row["iditem"].'" style="display:none;padding-left: 90px; padding-right:0;" class="dataitems collection-item avatar" pos="'.$row["orden"].'">
				<div>
					<i class="material-icons left handler-class" style="cursor:move;margin-left:-85px;margin-top:10px">swap_vert</i>
					<i class="material-icons circle'.(($row["icono"]) ? '"' : ' tooltipped" data-position="bottom" data-delay="50" data-tooltip="No icono"').' style="background-color:#1665c1; left:36px">'.(($row["icono"]) ? $row["icono"] : 'highlight_off').'</i>				
					<a  class="black-text" href="#!">
						<span class="title">'.$row["itemmenu"].'</span>								
					</a>                 
					<p class="grey-text lighten-2 title">'.$row["vinculo"].'</p>
					'.GetDropDownSettingsRow($row["iditem"],GetMenuArray()).'												
				</div>
				'.GetChildsHTML($row,$stmt).'
			</li>
		';        
    }
	
	function GetChildsHTML($row,$stmt)
	{
		if(!$row['submenus'] || $row['submenus'] == "" || !$stmt)
			return '';
		
		$JData = json_decode($row['submenus'],true); 
		$Result = '';
		
		foreach ($JData as $key => $val) 		
		{
			$FilterData = 
			array_filter($stmt, function($row) use($val) {
				  return $row['iditem'] == $val['id'];
			});
			
			foreach ($FilterData as $value) 
				$Result .= GetDataHTML($value,$stmt,true);
		}
		
		return '<ul>'.$Result.'</ul>';				
		
	}

	/* Recursive function.
	*/
	function UpdateChildren($mysqli,$AChild,$IDMenu)
	{
		foreach ($AChild as $key => $val) 
		{			
			if(isset($val["children"]))
			{
				if(!UpdateChildren($mysqli,$val["children"],$IDMenu))
					return false;				
			}
			else
				$val["children"] = "";			
				
			$mysqli->update("menu_detalle",
			[
				"orden" => -1,
				"(JSON) submenus" => $val["children"]
			],
			[
				"AND" => 
				[
					"idmenu" => $IDMenu,
					"iditem" => $val["id"]
				]
			]);
			
			if( CheckDBError($mysqli) ) return false;																																
		}
		
		return true;		
	}	
?>
