<?php
	//Funciones de manejo de contenido o tema
	function menu($mysqli, $idmenu, $clasecss = "", $idcss = "",$BeginUL = "", $EndUL = "")
	{
		if($idcss != "")	$idcss 	  = "id=\"$idcss\"";
		if($clasecss != "") $clasecss = "class=\"$clasecss\"";
		
		
		//$bAdmin = login_check($mysqli) && esadmin($mysqli);
		
		$Result = "<ul $clasecss $idcss>";
		if($BeginUL != "") $Result .= $BeginUL;
		if( $stmt = $mysqli->prepare("SELECT itemmenu, vinculo, icono FROM menu_detalle WHERE idmenu = ? order by orden") )
		{
			$stmt->bind_param('i', $idmenu);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($itemmenu, $vinculo,$icon);
			while( $stmt->fetch() )
			{
				if(strtolower($itemmenu) == "login" && login_check($mysqli))
				{
					$Result .= "<li><a href=\"$vinculo\"><img class=\"responsive-img circle left z-depth-1\"".
					"style=\"width:32px;height:32px;margin-top:15px;margin-right:10px\""
					." src=\"".GetUserImagePath($_SESSION['idusuario'])."\">".$_SESSION['idusuario']."</a></li>";
				}
				else
					$Result .= "<li><a href=\"$vinculo\">". (($icon && $icon != "") ? "<i class=\"material-icons left\" style=\"line-height: inherit;\">$icon</i>" : "" )."$itemmenu</a></li>";
			}
		}
        else
        {
            echo "Error al traer el menu->Menu()";
        }		
		
		if($EndUL != "") $Result .= $EndUL;
		
		$Result .= "</ul>";
		
		return $Result;		
	}
	
	function ShowSlider($mysqli, $idslider, $idmodulo, $clasecss = "", $idcss = "")
	{
		if($idcss != "") $idcss = " id=\"$idcss\"";		
		$Result = '<div'.$idcss.' class="slider '. $clasecss .'"><ul class="slides">';
		$strSQL = 
		"SELECT i.img, i.ruta
		FROM slider_img_mod m JOIN imagenes i on m.idimagen = i.img
		WHERE idslider = ? and idmodulo = ?
		ORDER BY orden";		
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('is', $idslider,$idmodulo);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($Titulo,$Ruta);
			while( $stmt->fetch() )
			{
				$Result .= "<li><img src=\"$Ruta\"><div class=\"caption center-align\"><h3>$Titulo</h3></div></li>";
			}
			
			if( $stmt->num_rows <= 0 )
				return "";										
		}
		else
		{
			echo "Error on -> ShowSlider()";
			return "";
		}		
		$Result .= "</ul></div>";
		return $Result;		
	}
	
	function mostrarpanel($bloques,$idmodulo,$mysqli)
	{
		
	}
	
	function panel($bloques, $idmodulo, $mysqli) 
	{
		
	}
	
	function bloque($idbloque, $mysqli, $clasecss="", $idcss="")
	{
		if($idcss != "")	$idcss 	  = "id=\"$idcss\"";
		if($clasecss != "") $clasecss = "class=\"$clasecss\"";
		
		echo "<div $clasecss $idcss>";
		
		//Check in database
		if( $stmt = $mysqli->prepare("SELECT bloque, contenido, tipo FROM bloques WHERE idbloque = ?") )
		{
			$stmt->bind_param('s', $idbloque);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($titulo, $contenido, $tipo);
			$stmt->fetch();			
			
			if( $stmt->num_rows == 1 )
			{
				//El bloque es un archivo
				if( $tipo == 1 )
				{
					if( file_exists("bloques/$idbloque.bloque.php") )
						require_once("bloques/$idbloque.bloque.php");
					else
						echo "<h1>No existe el bloque: " . $idbloque;											
				}
				else
				//El bloque esta en la base de datos.
				{
					echo "<h3>$titulo</h3>";
					echo "$contenido";
				}
			}
			else
			{
				echo "<h4>Error, el bloque no esta declarado en la base de datos.</h4>";
			}
			
		}
		else
		{
			$error = $mysqli->error;
			echo "<h4>Error en la base de datos: $error</h4>";
		}
			
		echo "</div>";		
	}

	function modulo($modulo, $mysqli, $clasecss="", $idcss="")
	{
		if($idcss != "")	$idcss 	  = "id=\"$idcss\"";
		if($clasecss != "") $clasecss = "class=\"$clasecss\"";
		
		$IgnoreMods = Array('inicio','articulos','galeria');
		if(in_array($modulo,$IgnoreMods))
			$clasecss = "";
									
		echo "<div $clasecss $idcss>";
		
		//Check in database
		if( $stmt = $mysqli->prepare("SELECT modulo, contenido, tipo FROM modulos WHERE idmodulo = ?") )
		{
			$stmt->bind_param('s', $modulo);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($titulo, $contenido, $tipo);
			$stmt->fetch();			
			
			if( $stmt->num_rows == 1 )
			{
				//El modulo es un archivo
				if( $tipo == 1 )
				{
					if( file_exists("modulos/$modulo.modulo.php") )
						require_once("modulos/$modulo.modulo.php");
					else
						echo "<h3>No existe el modulo: " . $modulo."</h3>";											
				}
				else
				//El modulo esta en la base de datos.
				{
					echo "<h1>$titulo</h1>";
					echo "$contenido";
				}
			}
			else
			{
				echo "<h3>Error, el modulo no esta declarado en la base de datos.</h3>";
			}
			
		}
		else
		{
			$error = $mysqli->error;
			echo "<h3>Error en la base de datos: $error</h3>";
		}
			
		echo "</div>";
	}
	
	//Custom functions
	function GetUserImagePath($idusuario)
	{
        $RelativePath = "";
        //if(strtolower(basename(getcwd())) != "blog")
           // $RelativePath = "../../";
        
        $result = glob($RelativePath."uploads/avatars/".GetStrWithRange($idusuario).".*");
		if(count($result) > 0 )
			return ltrim($result[0],"/.");
		else
			return "uploads/avatars/default.png";		
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
	

	//Source: http://dev.flauschig.ch/wordpress/?p=213
	function DynamicBindVariables($stmt, $params)
	{
		if ($params != null)
		{
			// Generate the Type String (eg: 'issisd')
			$types = '';
			foreach($params as $param)
			{
				if(is_int($param)) {
					// Integer
					$types .= 'i';
				} elseif (is_float($param)) {
					// Double
					$types .= 'd';
				} elseif (is_string($param)) {
					// String
					$types .= 's';
				} else {
					// Blob and Unknown
					$types .= 'b';
				}
			}
	
			// Add the Type String as the first Parameter
			$bind_names[] = $types;
	
			// Loop thru the given Parameters
			for ($i=0; $i<count($params);$i++)
			{
				// Create a variable Name
				$bind_name = 'bind' . $i;
				// Add the Parameter to the variable Variable
				$$bind_name = $params[$i];
				// Associate the Variable as an Element in the Array
				$bind_names[] = &$$bind_name;
			}
			
			// Call the Function bind_param with dynamic Parameters
			call_user_func_array(array($stmt,'bind_param'), $bind_names);
		}
		return $stmt;
	}
	
	function GetDropDownSettingsRow($id,$Items)
	{
		$HTMLResult = 
		"<a class='dropdown-button btn' href='#' data-activates='cbSettingsRow_$id'><i class=\"material-icons\">settings</i></a>
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
			$HTMLResult .= "<a href=".((isset($Item["href"])) ? str_replace("%id",$id,$Item["href"]) : "" ) . ">";
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
	
	
	//Funciones del sistema.
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
		
        //Debug
		// Set last regen session variable first time
		if (!isset($_SESSION['last_regen']))
			$_SESSION['last_regen'] = time();		
		
		$session_regen_time = 60*5;
		if ($_SESSION['last_regen'] + $session_regen_time < time()){
			$_SESSION['last_regen'] = time();
			session_regenerate_id(true);   
		}				
	}
	
	function login($idusuario,$password,$mysqli)
	{
		$strSQL = "SELECT nombre, password, llave FROM usuarios WHERE idusuario = ?";
		if ( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('s', $idusuario);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($nombre,$passw,$llave);
			$stmt->fetch();
			if($stmt->num_rows == 1)
			{
				$password = hash('SHA512',$password . $llave);
				if($passw == $password)
				{
					$_SESSION['usuario'] 	= $nombre;
					$_SESSION['idusuario'] 	= $idusuario;
					$navegador = $_SERVER['HTTP_USER_AGENT'];
					$_SESSION['loginstring'] = hash('SHA512', $password . $navegador); 
					
					return true; //Login exitoso
				}
				else
                    return false; // Password Incorrecto
				
			}
			else
                return false; //Usuario no existe en la BD;
		}
		else	
            return false; //Error en la consulta
	}
	
	function fuerzabruta($idusuario,$mysqli)
	{
		
	}
	
	function login_check($mysqli,$Retry = false)
	{
		//return true;
        if( isset($_SESSION['usuario'] ,
				  $_SESSION['idusuario'] , 
				  $_SESSION['loginstring'] ) )
		{
			$idusuario	 = $_SESSION['idusuario'];
			$usuario 	 = $_SESSION['usuario'];
			$loginstring = $_SESSION['loginstring'];
			$navegador = $_SERVER['HTTP_USER_AGENT'];
			
			$strSQL = "SELECT password FROM usuarios WHERE idusuario = ?";
			if ( $stmt = $mysqli->prepare($strSQL) )
			{
				$stmt->bind_param('s',$idusuario);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($password);				
				$stmt->fetch();
				
				if($stmt->num_rows == 1)
				{
					$logincheck = hash('SHA512', $password . $navegador);
					if($logincheck == $loginstring)
					{
						return true; //Login Correcto
					}
					else
					{
						return false; // Sesion invalida
					}
				}
				else
					return false; //No existe el usuario
				
			}
			else
				return false; //Error en la consulta.
			
		}
		else
		{
			//If there is a pending login do it. Just once.
			if( isset($_POST['idusuario'], $_POST['passw']) && !$Retry)
			{
				$idusuario = $_POST['idusuario'];
				$password = $_POST['passw']; //Password Encriptado
				
				login($idusuario, $password, $mysqli);
				return login_check($mysqli,true);
			}
			
			return false; //No hay nadie logeado.
		}
	}
	
	function esadmin($mysqli)
	{
		return true;
        
        $idusuario = $_SESSION['idusuario'];
		$strSQL = "SELECT esadmin FROM usuarios WHERE idusuario = ?";
		if( $stmt = $mysqli->prepare($strSQL) )
		{
			$stmt->bind_param('s',$idusuario);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($admin);										
							
			if($stmt->fetch())
				return $admin;
		}			
		
		return false;
	}
?>