<?php
//-------------------------------------------------------------------------------------
// Functions.php
// Where all functions are.
//-------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------
// Main functions
//-------------------------------------------------------------------------------------
    function menu($mysqli, $idmenu, $clasecss = "", $idcss = "",$BeginUL = "", $EndUL = "")
    {        
        $Result = "";
        $DropDowns = "";
        $stmt = $mysqli->select("menu_detalle",
        [
            "iditem","itemmenu","vinculo","icono","submenus","orden"
        ],
        [
            "idmenu" => $idmenu,
            "ORDER" => "orden ASC"
        ]);
        
        if( CheckDBError($mysqli) ) return "";
        
        foreach ($stmt as $row)
        {
            if($row["orden"] == -1)
                continue;
            
            if(strtolower($row["itemmenu"]) == "login" && login_check($mysqli))
            {
                $Result .= 
                "<li>
                    <a class=\"waves-effect waves-cyan\" href=\"".GetURL($row["vinculo"])."\"><img class=\"responsive-img circle left z-depth-1\"".
                    "style=\"width:32px;height:32px;margin-top:15px;margin-right:10px\""
                    ." src=\"".GetUserImagePath($_SESSION['idusuario'])."\">".$_SESSION['idusuario']."</a>
                 </li>
                 ";
                 
                 continue;                    
            }
            
            if($row["submenus"] != "")
            {                                                
                //If side-nav then make it a collapsible
                if(strpos($clasecss, 'side-nav') !== false)
                {
                     $Result .= 
                     '
                     <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                             <a class="collapsible-header">'.
                            (($row["icono"] && $row["icono"] != "") ? 
                            '<i class="material-icons left" style="line-height: inherit;">'.$row["icono"].'</i>' : "" )                             
                             .$row["itemmenu"].
                             '<i class="right mdi-navigation-arrow-drop-down"></i>
                             </a>
                             <div class="collapsible-body">
                                <ul>
                                '.GetMenuChildsHTML($row["submenus"],$stmt).'
                                </ul>
                             </div>
                           </li>
                        </ul>
                     </li>
                     ';
                }
                else
                {
                    //If nav-bar then make it a dropdown                
                    $DPName = 'Menudp_' . $row["itemmenu"];
                    $Result .=  GetMenuitemHTML($row,true,$DPName);
                    $DropDowns .= 
                    '<ul id="'.$DPName.'" class="dropdown-content">'
                        .GetMenuChildsHTML($row["submenus"],$stmt).
                    '</ul>';
                }                
                
                continue;                
            }
            
            //Default
            $Result .= GetMenuitemHTML($row);
        }        
        
		if($idcss != "")	$idcss 	  = "id=\"$idcss\"";
		if($clasecss != "") $clasecss = "class=\"$clasecss\"";
        $Result = "<ul $clasecss $idcss>" .
                        $BeginUL . 
                        $Result .
                        $EndUL .
                  "</ul>"
                  .$DropDowns;                    
                                  
        return $Result;
    }
    
	function GetMenuChildsHTML($Submenus,$stmt)
	{	
		$JData = json_decode($Submenus,true); 
		$Result = '';
		
		foreach ($JData as $key => $val) 		
		{
			$FilterData = 
			array_filter($stmt, function($row) use($val) {
				  return $row['iditem'] == $val['id'];
			});
			
			foreach ($FilterData as $value)
                $Result .= GetMenuitemHTML($value); 
		}
		
		return $Result;						
	}
    
    function GetMenuitemHTML($row,$bisDP = false,$DPName = "")
    {        
        return 
        '
            <li>
                <a class="waves-effect waves-cyan'.((!$bisDP) ? '"' : ' dropdown-button" data-activates="'.$DPName.'"').' href="'.GetURL($row["vinculo"]).'">'.
                    (($row["icono"] && $row["icono"] != "") ? 
                    '<i class="material-icons left" style="line-height: inherit;">'.$row["icono"].'</i>' : "" ) 
                    .$row["itemmenu"].
                '</a>
            </li>
        ';        
    }    

    function ShowSlider($mysqli, $idslider, $idmodulo, $clasecss = "", $idcss = "")
    {
        if($idcss != "") $idcss = " id=\"$idcss\"";        
        $Result = "";        
        
        $stmt = $mysqli->select("slider_img_mod",
        [
            "[><]imagenes" => "idimagen"
        ],
        [
            "imagenes.img","imagenes.ruta"
        ],
        [
            "AND" =>
            [
                "slider_img_mod.idslider" => $idslider,
                "slider_img_mod.idmodulo" => $idmodulo
            ],
            "ORDER" => "orden ASC"
        ]);
        
        
        if(!$stmt)
        {
			if($mysqli->error()[2] != "")
                echo "Error on -> ShowSlider():". $mysqli->error()[2];
                
			return "";            
        }                
        
        foreach ($stmt as $row)
        {
            $Result .= 
            "<li>
                <img src=\"". $row['ruta'] ."\">
                <div class=\"caption right-align\">
                    <p class=\"flow-text\">".$row['img']."</p>
                </div>
             </li>";
        }
        
        $Result = '<div'.$idcss.' class="slider '. $clasecss .'">
                      <ul class="slides">'.
                        $Result.
                     '</ul>
                   </div>';
        
        return $Result;        
    }

    function ShowProyectSlider($mysqli, $idproyecto, $clasecss = "", $idcss = "")
    {
        if($idcss != "") $idcss = " id=\"$idcss\"";        
        $Result = "";        
        
        $stmt = $mysqli->select("proyectos_img",
        [
            "[><]imagenes" => "idimagen"
        ],
        [
            "imagenes.img","imagenes.ruta", "imagenes.descripcion"
        ],
        [
            "AND" =>
            [
                "proyectos_img.idproyecto" => $idproyecto,
                
            ]
        ]);
        
        
        if(!$stmt)
        {
			if($mysqli->error()[2] != "")
                echo "Error on -> ShowSlider():". $mysqli->error()[2];
                
			return "";            
        }                
        
        foreach ($stmt as $row)
        {
            $Result .= 
            "<li>
                <img src=\"". $row['ruta'] ."\">
                <div class=\"caption right-align\">
                    <p class=\"flow-text\">".$row['descripcion']."</p>
                </div>
             </li>";
        }
        
        $Result = '<div'.$idcss.' class="slider '. $clasecss .'">
                      <ul class="slides">'.
                        $Result.
                     '</ul>
                   </div>';
        
        return $Result;        
    }
    
	//function mostrarpanel($bloques,$idmodulo,$mysqli){}	
	//function panel($bloques, $idmodulo, $mysqli) {}    
    function bloque($idbloque, $mysqli, $clasecss="", $idcss=""){}
    
    function modulo($idmodulo, $mysqli, $clasecss="", $idcss="", $bGetHTML = false)
    {
        if($bGetHTML) ob_start();
        
        if($idcss != "")	$idcss 	  = "id=\"$idcss\"";
        if($clasecss != "") $clasecss = "class=\"$clasecss\"";
        
        //$IgnoreMods = Array('inicio','articulos','galeria');
        //if(in_array($idmodulo,$IgnoreMods)) $clasecss = "";
        
        echo "<div $clasecss $idcss>";
        
        //Check in database
        $stmt = $mysqli->select("modulos",
        [
            "modulo", "contenido", "tipo"
        ],
        [
            "idmodulo" => $idmodulo
        ]);
        
        
        if(!$stmt)
        {
            if( !CheckDBError($mysqli) )
            {
                if($bGetHTML) ob_end_clean();
                return false;
                //echo "<h3>Error, el modulo no esta declarado en la base de datos.</h3>";                
            }                
        }
        else
        {        
            if( $stmt[0]["tipo"] == 1 )
            {
                if( file_exists("modulos/".$idmodulo.".modulo.php") )
                    require_once("modulos/".$idmodulo.".modulo.php");
                else
                    echo "<h3>No existe el modulo: " . $idmodulo ."</h3>";
            }
            else
            {
                //echo "<h1>". $stmt[0]["modulo"] ."</h1>";
                echo $stmt[0]["contenido"];
            }
        }
        
        echo "</div>";
        
        if($bGetHTML)
        {
            $buffer = ob_get_contents();
            ob_end_clean();
            return $buffer;
        }
    }
    	
//-------------------------------------------------------------------------------------	
// System functions
//-------------------------------------------------------------------------------------
	function inicio_sesion()
	{
		$nombre_sesion = 'sinhco_3336';
		$seguridad = false;
		$HTTPOnly = true;
		
		ini_set('session.use_only_cookies', 1);
		$cookie_params = session_get_cookie_params();
		session_set_cookie_params(86400, $cookie_params["path"], 
								  $cookie_params["domain"], $seguridad, $HTTPOnly);
		
		session_name($nombre_sesion);
		session_start();
		
        /*
		// Set last regen session variable first time
		if (!isset($_SESSION['last_regen']))
			$_SESSION['last_regen'] = time();		
		
		$session_regen_time = 60*5;
		if ($_SESSION['last_regen'] + $session_regen_time < time()){
			$_SESSION['last_regen'] = time();
			session_regenerate_id(true);   
		}
        */				
	}
    

    function login($idusuario,$password,$mysqli)
    {
        $stmt = $mysqli->select("usuarios",
        [
            "nombre", "password", "llave"
        ],
        [
            "idusuario" => $idusuario
        ]);
        
        if(!$stmt)
        {
            //Error en la consulta
            if( CheckDBError($mysqli,false) )
                echo "Error en login()";
                
            //Usuario no existe en la BD;
            return false;
        }
        
        $password = hash('SHA512',$password . $stmt[0]["llave"]);
        if($password == $stmt[0]["password"])
        {
            $_SESSION['usuario'] 	= $stmt[0]["nombre"];
            $_SESSION['idusuario'] 	= $idusuario;
            $navegador = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['loginstring'] = hash('SHA512', $password . $navegador); 
                        
            return true; //Login exitoso            
        }
        else
            return false; // Password Incorrecto
    }
    
    function login_check($mysqli,$Retry = false)
    {
        if( isset($_SESSION['usuario'] ,
				  $_SESSION['idusuario'] , 
				  $_SESSION['loginstring'] ) )
		{
			$idusuario	 = $_SESSION['idusuario'];
			$usuario 	 = $_SESSION['usuario'];
			$loginstring = $_SESSION['loginstring'];
			$navegador = $_SERVER['HTTP_USER_AGENT'];
            
            $stmt = $mysqli->select("usuarios",
            ["password"],
            ["idusuario" => $idusuario]);
            
            if(!$stmt)
            {
                //Error en la consulta.
                if( CheckDBError($mysqli,false) )
                    echo "Error->LoginCheck():".$mysqli->error()[2];
                 
                //No existe el usuario   
                return false;
            }
            
            $logincheck = hash('SHA512', $stmt[0]["password"] . $navegador);
            return $logincheck == $loginstring; //Login correcto/incorrecto                    
        }
        
        //If there is a pending login do it. Just once.
        if( isset($_POST['idusuario'], $_POST['passw']) && !$Retry)
        {
            $idusuario = $_POST['idusuario'];
            $password = $_POST['passw']; //Password Encriptado
            
            login($idusuario, $password, $mysqli);
            return login_check($mysqli,true);
        }        
        
        return false; //No sesion is active.
    }
    
    function esadmin($mysqli)
    {
        //Not used.
        return true;
    }
    
    function CheckDBError($mysqli,$bEcho = true)
    {
        if($mysqli->error()[2] != "")
        {
            if($bEcho) echo "Error: ".$mysqli->error()[2];
            return true;
        }                        
    }
    
    function CurrentFolder()
    {
        $Scripts = Array('index.php','login.php','logout.php');
        if(!in_array(basename($_SERVER['SCRIPT_NAME']),$Scripts)) 
            return dirname($_SERVER['SCRIPT_NAME'])."/../../";            
        
        return str_replace("\\","",dirname($_SERVER['SCRIPT_NAME'])."/");
    }
    
    
    function GetURL($URL)
    {
        //If it finds a "javascript:"
        if (strlen($URL) > 10 && strtolower(substr($URL, 0, 11)) === 'javascript:')
            return $URL;
        
        return CurrentFolder().$URL;
    }
    
    
    function Debug()
    {
        echo "<br>";
        echo "CurrentFolder->".CurrentFolder();
        echo "<br>";
        echo "Fixed URL->".GetURL("");
        echo "<br>";
        //echo "ScriptName->".basename($_SERVER['SCRIPT_NAME']);
        echo "ScriptName->".$_SERVER['SCRIPT_NAME'];
        echo "<br>";
        echo "ScriptName->".dirname($_SERVER['SCRIPT_NAME']);
        echo "<br>";
    }    
    
    function URLParam($Segment)
    {
        
        $URL = $_SERVER['REQUEST_URI'];       
        //$URL = ltrim($URL, CurrentFolder());
        $URL = preg_replace('/^' . preg_quote(CurrentFolder(), '/') . '/', '', $URL);
        $URL = explode('/',$URL);               
        
        return ( isset($URL[$Segment]) ? $URL[$Segment] : false);
    }
    
//-------------------------------------------------------------------------------------    
// Custom functions
//-------------------------------------------------------------------------------------
	function GetUserImagePath($idusuario,$bIsService = false)
	{        
        $Prefix = ($bIsService) ? "../../" : "";
        
        $result = glob($Prefix . "uploads/avatars/".GetStrWithRange($idusuario).".*");
		if(count($result) > 0 )
			return GetURL(ltrim($result[0],"/."));
		else
			return GetURL("uploads/avatars/default.png");		
	}
    
    function GetProyectImagePath($idproyecto, $bIsService = false)
	{        
        $Prefix = ($bIsService) ? "../../" : "";
        $result = glob($Prefix . "uploads/images/".$idproyecto.".*");
		if(count($result) > 0 )
			return GetURL(ltrim($result[0],"/."));
		else
			return GetURL("uploads/images/proyect-default.jpg");		
	}
    
    function GetProductImagePath($idproducto, $bIsService = false)
	{        
        $Prefix = ($bIsService) ? "../../" : "";
        $result = glob($Prefix . "uploads/images/productos/".$idproducto.".*");
		if(count($result) > 0 )
			return GetURL(ltrim($result[0],"/."));
		else
			return GetURL("uploads/images/Rotoplas.jpg");		
	}

	function GetStrWithRange($str)
	{				
		$result = "";
		$Upper = str_split(strtoupper($str));
		$Lower = str_split(strtolower($str));
		
		for($i = 0; $i < count($Upper); $i++)
			$result .= "[".$Upper[$i].$Lower[$i]."]";
		
		return $result;
	}    
    
	function GetDropDownSettingsRow($id,$Items)
	{
		$HTMLResult = 
		"<a class='dropdown-button btn-flat secondary-content grey-text lighten-1' href='#' data-activates='cbSettingsRow_$id'><i class=\"material-icons\">more_vert</i></a>
			<ul id='cbSettingsRow_$id' class='dropdown-content'>";
			
		
		foreach($Items as $Item)
		{
			//Skip if custom condition doest meet.
			if(isset($Item["ifonly"]) && $Item["ifonly"] != true)
				continue;
			
			if(isset($Item[0]) == "divider")
			{
				$HTMLResult .= "<li class=\"divider\"></li>";
				continue;
			}
			
			$HTMLResult .= "<li". ((isset($Item["id"])) ? "id=\"".$Item["id"]."\"" : "" ) .">";
			$HTMLResult .= "<a class=\"truncate\" href=".((isset($Item["href"])) ? str_replace("%id",$id,$Item["href"]) : "" ) . ">";
			if(isset($Item["icon"])) $HTMLResult .= "<i class=\"material-icons left\">".$Item["icon"]."</i>";
			$HTMLResult .= $Item["contenido"] . "</a></li>";
		}
		
		$HTMLResult .= "</ul>";
		
		return $HTMLResult;
	}
	
	function limit_text($text, $limit) 
	{
		if (str_word_count($text, 0) > $limit) 
		{
			$words = str_word_count($text, 2);
			$pos = array_keys($words);
			$text = substr($text, 0, $pos[$limit]) . '...';
		}
		
		return $text;
	}
	
	function GetFirstImage(&$HTML,$bRemove = false)
	{
		$Doc = new DOMDocument();
		@$Doc->loadHTML($HTML);
		$Elements = $Doc->getElementsByTagName('img')->item(0);
		if(!$Elements) return "";
		
		if($bRemove)
		{
			$Elements->setAttribute('style','display:none');
			$HTML = $Doc->saveHTML();
		} 					
				
		return $Elements->getAttribute('src');
		
	}
	
	function AddAttributeToTag($HTML,$Tag,$Attrib,$AttribContent)
	{
		$Doc = new DOMDocument();
		@$Doc->loadHTML($HTML);
		$Elements = $Doc->getElementsByTagName($Tag);
		if(!$Elements) return $HTML;
		
		foreach ($Elements as $Element)
			$Element->setAttribute($Attrib,$AttribContent);
			
		return $Doc->saveHTML();
	}        
    
    function round_up($number, $precision = 2)
    {
        $fig = (int) str_pad('1', $precision, '0');
        return (ceil($number * $fig) / $fig);
    }

?>