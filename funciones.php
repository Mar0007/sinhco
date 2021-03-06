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
        $bActive = strpos($_SERVER['REQUEST_URI'], GetURL($row["vinculo"])) !== false;
                
        return 
        '
            <li'.(($bActive) ? ' class="active"' : '').'>
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
            "imagenes.img","imagenes.ruta","imagenes.alineacion","imagenes.descripcion"
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
    
        if(count($stmt) <= 1)
        {
            $row = $stmt[0];
            
            return 
            '
                <div'.$idcss.' class="hero-bg hero-slider '. $clasecss .'" style="background-image:url('.htmlentities('"'.$row['ruta'].'"').');">
                </div>
                <div class="hero-caption'.(empty($row["alineacion"]) ? "" : " ".$row["alineacion"]."-align").'" style="opacity: 1; transform: translateX(0px) translateY(0px);">
                    <p class="flow-text">'.$row['descripcion'].'</p>
                </div>
            ';
        }              
        
        foreach ($stmt as $row)
        {
            $Result .= 
            "<li>
                <img src=\"". $row['ruta'] ."\">
                <div class=\"caption".(empty($row["alineacion"]) ? "" : " ".$row["alineacion"]."-align")."\">
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
    
    function ShowproductSlider($mysqli, $idproducto, $clasecss = "", $idcss = "")
    {
        if($idcss != "") $idcss = " id=\"$idcss\"";        
        $Result = "";        
        
        $stmt = $mysqli->select("productos_img",
        [
            "[><]imagenes" => "idimagen"
        ],
        [
            "imagenes.img","imagenes.ruta", "imagenes.descripcion"
        ],
        [
            "AND" =>
            [
                "productos_img.idproducto" => $idproducto
                
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
    function bloque($idbloque, $mysqli, $clasecss="", $idcss="",$bGetHTML = false)
    {
        if($bGetHTML) ob_start();
        
        if($idcss != "")	$idcss 	  = "id=\"$idcss\"";
        if($clasecss != "") $clasecss = "class=\"$clasecss\"";
                
        echo "<div $clasecss $idcss>";
        
        //Check in database
        $stmt = $mysqli->select("bloques",
        [
            "bloque", "contenido", "tipo"
        ],
        [
            "idbloque" => $idbloque
        ]);
        
        
        if(!$stmt)
        {
            if( !CheckDBError($mysqli) )
            {
                if($bGetHTML) ob_end_clean();
                echo '<script>console.error("B404: Bloque no esta declarado")</script>';
                return false;
                //echo "<h3>Error, el modulo no esta declarado en la base de datos.</h3>";                
            }                
        }
        else
        {        
            if( $stmt[0]["tipo"] == 1  || $stmt[0]["tipo"] == -1)
            {
                try{
                if( file_exists("bloques/".$idbloque.".modulo.php") )
                    require_once("bloques/".$idbloque.".modulo.php");
                else
                    echo "<h3>No existe el bloque: " . $idbloque ."</h3>";
                }
                catch (Exception $e) 
                {
                    if($bGetHTML) ob_end_clean();
                    echo '<script>console.error("B503: Exception-> '.$e->getMessage().'")</script>';
                    return false;                    
                }
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
                echo '<script>console.error("M404: Modulo no esta declarado")</script>';
                return false;
                //echo "<h3>Error, el modulo no esta declarado en la base de datos.</h3>";                
            }                
        }
        else
        {        
            if( $stmt[0]["tipo"] == 1  || $stmt[0]["tipo"] == -1)
            {
                try{
                if( file_exists("modulos/".$idmodulo.".modulo.php") )
                    require_once("modulos/".$idmodulo.".modulo.php");
                else
                    echo "<h3>No existe el modulo: " . $idmodulo ."</h3>";
                }
                catch (Exception $e) 
                {
                    if($bGetHTML) ob_end_clean();
                    echo '<script>console.error("M503: Exception-> '.$e->getMessage().'")</script>';
                    return false;                    
                }
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
        $Scripts = Array('index.php','login.php','editorutils.php','getimage.php');
        $Path = dirname($_SERVER['SCRIPT_NAME']);
        
        if(!in_array(basename($_SERVER['SCRIPT_NAME']),$Scripts)) 
            $Path = RelativePathUp($Path,2);            
        
        $Path = str_replace("\\","",$Path);

        if($Path == "/") return $Path;        
        return $Path . "/";
    }
    
    function RelativePathUp($Path,$Levels = 1)
    {        
        if($Levels > 0)
            return RelativePathUp(dirname($Path),$Levels - 1);
        
        return $Path; 
    }
    
    
    function GetURL($URL)
    {
        //If it finds a "javascript:"
        if (strlen($URL) > 10 && strtolower(substr($URL, 0, 11)) === 'javascript:')
            return $URL;
        
        return CurrentFolder().$URL;
    }
    
    /* Types: exact, scale
    */
    function GetImageURL($URL,$Width = null,$Height = null,$type = 'scale')
    {        
        if(empty($Width) || empty($Height))
            return GetURL('getimage.php?file='.$URL);
        
        if($type == 'exact')
            return GetURL('getimage.php?width='.$Width.'&height='.$Height.'&file='.$URL);
        
        return GetURL('getimage.php?maxw='.$Width.'&maxh='.$Height.'&file='.$URL);
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

    function deleteDir($dirPath) 
    {
        if (!is_dir($dirPath))
            throw new InvalidArgumentException("$dirPath must be a directory");

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/')
            $dirPath .= '/';
        
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) 
        {
            if (is_dir($file))
                self::deleteDir($file);
            else
                unlink($file);
        }
        rmdir($dirPath);
    }

    function SendMail($ToEmail,$Subject,$Message)
    {
        require dirname(__FILE__) . '/config.php';
        require dirname(__FILE__) . '/recursos/PHPMailer/PHPMailerAutoload.php';

        $response = new StdClass;
        
        if(!$UsePHPMailer)
        {            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: Sinhco <".$phpEmailUser.">" . "\r\n" .
                        "Reply-To: Sinhco <". $phpEmailUser .">\r\n" .
                        "X-Mailer: PHP/" . phpversion();
            
            $errLevel = error_reporting(E_ALL ^ E_NOTICE);
            $bError = !mail($ToEmail,$Subject,$Message["html"],$headers);
            error_reporting($errLevel);
            
            if($bError) $response->error  = error_get_last()["message"];            
        }
        else 
        {
            $mail = new PHPMailer;
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();

            $mail->Host = $EmailHost;
            $mail->Port = $EmailPort;
            $mail->SMTPSecure = $EmailSMTPSecure; 
            $mail->SMTPAuth = $EmailUseSMTPAuth;

            $mail->Username = $phpEmailUser;
            $mail->Password = $phpEmailPass;
            $mail->setFrom($phpEmailUser, 'Sinhco');
            $mail->addReplyTo($phpEmailUser, 'Sinhco');
            $mail->addAddress($ToEmail);
            $mail->isHTML(true);
            $mail->Subject = $Subject;
            
            $mail->msgHTML($Message["html"]);
            $mail->AltBody = $Message["text"];
            
            $bError = !$mail->send();
            if($bError) $response->error  = $mail->ErrorInfo;            
        }
        if ($bError)
        {
            $response->status = 172;
            if(!$UsePHPMailer) $response->error  = $mail->ErrorInfo;
        }
        else
            $response->status = 200;


        return $response;                
    }

    function SendContactMail($FromEmail, $FromName, $Subject,$Message)
    {
        require dirname(__FILE__) . '/config.php';
        require dirname(__FILE__) . '/recursos/PHPMailer/PHPMailerAutoload.php';

        $response = new StdClass;
        $ToEmail = "fbsinhco@gmail.com";
        
        if(!$UsePHPMailer)
        {            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From:'.$FromEmail.  "\r\n";
            
            $errLevel = error_reporting(E_ALL ^ E_NOTICE);
            $bError = !mail($FromEmail,$subject,$Message["html"],$headers);
            error_reporting($errLevel);
            
            if($bError) $response->error  = error_get_last()["message"];            
        }
        else 
        {
            $mail = new PHPMailer;
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();

            $mail->Host = $EmailHost;
            $mail->Port = $EmailPort;
            $mail->SMTPSecure = $EmailSMTPSecure; 
            $mail->SMTPAuth = $EmailUseSMTPAuth;

            $mail->Username = $phpEmailUser;
            $mail->Password = $phpEmailPass;
            $mail->setFrom($FromEmail, $FromName);
            $mail->addReplyTo($FromEmail, $FromName);
            $mail->addAddress($ToEmail, 'Sinhco');
            $mail->isHTML(true);
            $mail->Subject = $Subject;
            
            $mail->msgHTML($Message["html"]);
            $mail->AltBody = $Message["text"];
            
            $bError = !$mail->send();
            if($bError) $response->error  = $mail->ErrorInfo;            
        }
        if ($bError)
        {
            $response->status = 172;
            if(!$UsePHPMailer) $response->error  = $mail->ErrorInfo;
        }
        else
            $response->status = 200;


        return $response;                
    }
    function crypto_rand_secure($min, $max) 
    {
            $range = $max - $min;
            if ($range < 0) return $min; // not so random...
            $log = log($range, 2);
            $bytes = (int) ($log / 8) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // discard irrelevant bits
            } while ($rnd >= $range);
            return $min + $rnd;
    }

    function getToken($length=32)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
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
			return GetURL("uploads/avatars/default.svg");		
	}
    
    function GetProyectImagePath($idproyecto, $bIsService = false)
	{        
        $Prefix = ($bIsService) ? "../../" : "";
        $result = glob($Prefix . "uploads/images/Proyecto-".$idproyecto.".*");
		if(count($result) > 0 )
			return GetURL(ltrim($result[0],"/."));
		else
			return GetURL("uploads/images/proyect-default.jpg");		
	}
    function GetCoverImagePath($idusuario, $bIsService = false)
	{        
        $Prefix = ($bIsService) ? "../../" : "";
        $result = glob($Prefix . "uploads/covers/Cover-".$idusuario.".*");
		if(count($result) > 0 )
			return GetURL(ltrim($result[0],"/."));
		else
			return GetURL("uploads/covers/cover.jpg");		
	}
    
    function GetProductImagePath($idproducto, $bIsService = false)
	{        
        $Prefix = ($bIsService) ? "../../" : "";
        $result = glob($Prefix . "uploads/images/productos/Producto-".$idproducto.".*");
		if(count($result) > 0 )
			return GetURL(ltrim($result[0],"/."));
		else
			return GetURL("uploads/images/productos/Rotoplas.jpg");		
	}

   function GetServiceImagePath($id, $bIsService = false)
	{        
        $Prefix = ($bIsService) ? "../../" : "";
        $result = glob($Prefix . "uploads/images/servicios/Servicio-".$id.".*");
		if(count($result) > 0 )
			return GetImageURL(ltrim($result[0],"/."),500,500);
		else
			return GetURL("uploads/images/proyect-default.jpg");		
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
    
    function arraytolower(array $array, $round = 0){
        return unserialize(strtolower(serialize($array)));
    }         
    
	function GetDropDownSettingsRow($id,$Items,$classcss = 'dropdown-button btn-flat secondary-content grey-text',$stylecss="")
	{
		$HTMLResult = 
		"<a class='".$classcss."' href='#' style=\"".$stylecss."\" data-activates='cbSettingsRow_$id'><i class=\"material-icons\">more_vert</i></a>
			<ul id='cbSettingsRow_$id' class='more-menu dropdown-content'>";
			
		
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
    
    function GetBreadcrumbs()
    {
        global $Navigation;
        $Result = "";        
        
        foreach ($Navigation as $key => $val) 
           $Result .= '<a href="'.$val.'" class="breadcrumb">'.$key.'</a>';
           
        return $Result;
    }
    
    function AddHistory($Title,$Ref,$DeletePrevious = false)
    {
        global $Navigation;        
        
        if(isset($Navigation) && array_key_exists($Title,$Navigation)) 
            return false;
            
        if($DeletePrevious) array_pop($Navigation);
            
        $Navigation[$Title] = $Ref;        
        return true;        
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
    
    function parse_size($size) 
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) 
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        
        return round($size);
    }    

?>