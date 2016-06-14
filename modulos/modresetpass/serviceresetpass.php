<?php
	require_once("../../config.php");
	require_once("../../funciones.php");  

  inicio_sesion();

  //1 = Consulta; 2 = Insertar; 3 = Actualizar; 4 = Eliminar;
  $accion = $_GET["accion"];

	switch($accion)
	{
        case 1:
        //Security
        $_SESSION['B848'] = isset($_SESSION['B848']) ? $_SESSION['B848'] + 1 : 0;
        if(!isset($_SESSION['sleep_stime'])) $_SESSION['sleep_stime'] = 0;  
        
        if($_SESSION['B848'] > 5 || $_SESSION['sleep_stime'] != 0)
        {
            $_SESSION['B848'] = 0;        
            // Set last regen session variable first time
            if ($_SESSION['sleep_stime'] == 0) 
                $_SESSION['sleep_stime'] = time();		
            
            $session_sleep = 60*5;
            $EndTime = $_SESSION['sleep_stime'] + $session_sleep;
            if (time() < $EndTime)
            {            
                $response = new StdClass;
                $response->status = 999;
                $response->left   = $EndTime - time();
                $response = json_encode($response);
                echo $response;
                return;
            }
            
            $_SESSION['sleep_stime'] = 0;
        }
        //-----------------------          

          $ToEmail = $_POST['email'];
          $response = new StdClass;

          //Get user.
          $stmt = $mysqli->select("usuarios",
          [
              "idusuario","nombre"
          ],
          [
              "email" => $ToEmail
          ]);
          
          if(!CheckDBError($mysqli) && !empty($stmt))
          {            
              //Generate token
              $Token = hash('SHA1', $stmt[0]["idusuario"] . microtime() .  GetToken());
              
              //Clear last tokens
              $mysqli->delete("usuario_reset",["idusuario" => $stmt[0]["idusuario"]]);
              
              //Insert new token
              $last_id = $mysqli->insert("usuario_reset",
              [
                "idusuario" => $stmt[0]["idusuario"],
                "token" => $Token,
                "ip" => $_SERVER['REMOTE_ADDR']
              ]);
              
              if(CheckDBError($mysqli) || empty($last_id)) return;
              
              //Generate link
              $ResetURL = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}" . GetURL("reset/".$stmt[0]["idusuario"]."/".$Token);
              
              //Send HTML reset message.
              $Message = HTMLResetMessage($stmt[0],$ResetURL);   
              $Subject = 'Restablezca su clave para Sinhco';

              $MailResponse = SendMail($ToEmail,$Subject,$Message);
              $response->status = $MailResponse->status;
              if(isset($MailResponse->error))
                $response->error  = $MailResponse->error;
          }
          else
          { 
              $response->status = 404;
          }    
          
          $response = json_encode($response);
          echo $response;                    
          break;         

        case 2:
          $Token    = $_POST['token'];
          $UserID   = $_POST['user'];
          $Password = $_POST['txtPassword'];

          $response = new StdClass;
          
          define('SECONDS_PER_DAY', 86400);
          if($mysqli->has('usuario_reset',
          [
            "AND" =>
            [
              "idusuario" => $UserID,
              "token"     => $Token, 
              "fecha[<>]" => [date("Y-m-d", time() - 1 * SECONDS_PER_DAY), date("Y-m-d")]
            ]
          ]))
          {
            //Make salt and encripted password
            $llave = hash('sha512',rand());            
            $encryptpass = hash('sha512',$Password . $llave);

            //Update password
            $mysqli->update("usuarios",
            [
              "llave" => $llave,
              "password" => $encryptpass
            ],
            [
              "idusuario" => $UserID
            ]);
            
            //Delete all tokens
            $mysqli->delete("usuario_reset",
            [
              "idusuario" => $UserID,
            ]);

            $response->status = 200;
          }
          else 
          {
            $response->status = 404;            
          }
          $response = json_encode($response);
          echo $response;
          break;
          
    }




function HTMLResetMessage($data,$Link)
{
return[ 
"html" => 
'
<!DOCTYPE html>
<html lang="es_HN">
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="es_HN" http-equiv="Content-Language">    
    <meta name="viewport" content="width=device-width">
  </head>
  <body style="min-width: 100%;margin: 0;padding: 0;color: #212121;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, Verdana, &quot;Trebuchet MS&quot;;font-weight: 400;font-size: 14px;line-height: 1.429;letter-spacing: 0.001em;background-color: #eee;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;width: 100% !important;">
    <table width="100%" class="mui-body" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;margin: 0;padding: 0;height: 100%;width: 100%;color: #212121;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, Verdana, &quot;Trebuchet MS&quot;font-weight: 400;font-size: 14px;line-height: 1.429;letter-spacing: 0.001em">
      <tr>
        <td style="padding: 0;text-align: left;border-collapse: collapse !important;">
          <center>
            <!--[if mso]><table><tr><td class="mui-container-fixed"><![endif]-->
            <div class="mui-container" style="max-width: 600px;display: block;margin: 0 auto;clear: both;text-align: left;padding-left: 15px;padding-right: 15px;">
              <h3 class="mui--text-center" style="margin-top: 20px;margin-bottom: 10px;font-weight: 400;font-size: 20px;line-height: 28px;text-align: center;"><img src="data:image/png;base64,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" alt="Sinhco"></h3>
              <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;">
                <tr>
                  <td class="mui-panel" style="padding: 15px;text-align: left;border-radius: 0;background-color: #FFF;border-top: 1px solid #ededed;border-left: 1px solid #e6e6e6;border-right: 1px solid #e6e6e6;border-bottom: 2px solid #d4d4d4;border-collapse: collapse !important;">
                    <table id="content-wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;">
                      <tbody>
                        <tr>
                          <td style="padding: 0;text-align: left;border-collapse: collapse !important;">
                            <h2 style="margin-top: 20px;margin-bottom: 10px;font-weight: 400;font-size: 24px;line-height: 32px;">¿Necesitas restablecer tu contraseña?</h2>
                          </td>
                        </tr>
                        <tr>
                          <td class="mui--divider-top" style="padding: 5px;text-align: left;border-top: 1px solid #e0e0e0;border-collapse: collapse !important;">
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 5px;text-align: left;border-collapse: collapse !important;">
                            Hola '.$data["nombre"].',                             
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 5px;text-align: left;border-collapse: collapse !important;">
                            Haz clic en el enlace a continuación y se te redirigirá a un sitio seguro en el cual podrás establecer una nueva contraseña.                             
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 5px;text-align: left;border-collapse: collapse !important;">
                            Tu usuario: <b>'.$data["idusuario"].'</b>                             
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 5px;text-align: left;border-collapse: collapse !important;">
                            <table class="mui-btn mui-btn--primary" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;cursor: pointer;white-space: nowrap;">
                              <tr>
                                <td style="padding: 5px;text-align: left;background-color: #2196F3;border-radius: 3px;border-collapse: collapse !important;">
                                  <a href="'.$Link.'" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;color: #FFF;text-decoration: none;border-top: 1px solid #2196F3;border-left: 1px solid #2196F3;border-right: 1px solid #2196F3;border-bottom: 1px solid #2196F3;font-weight: 500;font-size: 14px;line-height: 14px;letter-spacing: 0.03em;text-transform: uppercase;display: inline-block;text-align: center;border-radius: 3px;padding: 10px 25px;background-color: transparent;">Restablecer contraseña</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding: 5px;text-align: left;border-collapse: collapse !important;">
                            Gracias,
                          </td>
                        </tr>
                        <tr>
                          <td id="last-cell" style="padding-left: 5px;text-align: left;border-collapse: collapse !important;">
                            Staff de Sinhco
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
            <!--[if mso]></td></tr></table><![endif]-->
          </center>
        </td>
      </tr>
    </table>
  </body>
</html>',
"text" =>
'¿Necesitas restablecer tu contraseña?
Hola '.$data["nombre"].'
Ve al siguiente enlace y se te redirigirá a un sitio seguro en el cual podrás establecer una nueva contraseña.
Tu usuario: '.$data["idusuario"].'
Link: '.$Link.'
'
];
}


?>