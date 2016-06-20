<?php
	global $mysqli;
    global $tema;

	if( login_check($mysqli) )
	{
		header("Location: ".GetURL(dashboard));
        return;
	}

    $UserID    = ( !URLParam(1) ) ? null : URLParam(1);
    $UserToken = ( !URLParam(2) ) ? null : URLParam(2);
    
    $WebTitle = "Sinhco - Olvidar contraseña";

    if(!empty($UserID))
    {
          //Pre-check token
          define('SECONDS_PER_DAY', 86400);
          if(!$mysqli->has('usuario_reset',
          [
            "AND" =>
            [
              "idusuario" => $UserID,
              "token"     => $UserToken, 
              "fecha[<>]" => [date("Y-m-d", time() - 1 * SECONDS_PER_DAY), date("Y-m-d")]
            ]
          ]))
          {
            throw new Exception("Invalid token");
            return;
          }              
?>
        <input type="hidden" id="UserID" value="<?php echo $UserID?>">
        <input type="hidden" id="Usertoken" value="<?php echo $UserToken?>">
        <!-- Import SHA512 functions -->
        <script src="<?php echo GetURL("recursos/sha512.js") ?>"></script>
        <a class="btn-floating btn-medium blue darken-1 waves-effect" style="position:absolute;top:10px;left:10px" href="login">
            <i class="material-icons">arrow_back</i>
        </a>	

        <div class="row center">
            <form id="frmReset" action="javascript:UpdatePass()" method="POST" autocomplete="off">
                <label class="light"> Ingrese nueva contraseña </label>        
                <div class="input-field col s12">		
                    <input type="password" class="validate" name="txtpassword" id="txtpassword" required />
                    <label for="txtpassword">Nueva contraseña</label>
                </div>
                <div class="input-field col s12">		
                    <input type="password" class="validate" name="txtconfirm" id="txtconfirm" required />
                    <label for="txtconfirm">Confirmar contraseña</label>
                </div>        
                <input type="submit" value="Ingresar" style="display:none"/>
                <a id="btnSend" class="btn-floating btn-large right right-top-margin blue darken-1 waves-effect"   onclick="$(this).parents().find(':submit').click();">
                    <i class="material-icons">send</i>
                </a>	
            </form>
        </div>
<script>

var SmallLoader = 
' <div class="preloader-wrapper small active" style="margin-top:10px">' +
    '<div class="spinner-layer spinner-blue-only">' +
      '<div class="circle-clipper left">'+
        '<div class="circle"></div>'+
      '</div><div class="gap-patch">'+
        '<div class="circle"></div>'+
      '</div><div class="circle-clipper right">'+
        '<div class="circle"></div>'+
      '</div>'+
    '</div>'+
  '</div>'

var ajax_request;
function UpdatePass()
{
    if($("#btnSend").hasClass("disabled"))
    return;        
    
    if(ajax_request) ajax_request.abort();

    if($("#txtpassword").val() != $("#txtconfirm").val())
    {
        Materialize.toast('Contraseñas no concuerdan', 3000,"red");
        return;
    }

    var txtPassword = hex_sha512($("#txtpassword").val());
    var user = $("#UserID").val();
    var token = $("#Usertoken").val();

    $("#btnSend").addClass("disabled");
    $("#btnSend i").fadeOut(0,function(){
        $("#btnSend").append(SmallLoader);
    });

    ajax_request = $.ajax({
        url: "<?php echo GetURL("modulos/modresetpass/serviceresetpass.php?accion=2")?>",
        method: "POST",
        dataType: "JSON",
        data: {txtPassword:txtPassword,user:user,token:token}
    });
    
    ajax_request.done(function(data)
    {                        
        $("#btnSend .preloader-wrapper").fadeOut(0,function()
        {
            $("#btnSend i").fadeIn();
            $(this).remove();
        });

        if(data["status"] == 200)
        {
            Materialize.toast('Contraseña actualizada', 1000,"green",
            function()
            {
                location.href="<?php echo GetURL("login")?>";
            });
            return;            
        }

        if(data["status"] == 404)
        {
            Materialize.toast('La sesión ha expirado', 1000,"red",
            function()
            {
                location.href="<?php echo GetURL("login")?>";
            });
            return;
        }

        $("#btnSend").removeClass("disabled");
        Materialize.toast('Error interno: No se pudo guardar contraseña', 3000,"red");
        console.error("JSON-Error->UpdatePass(): "+data);
    });	

	ajax_request.fail(function(AjaxObject)
    {
        $("#btnSend").removeClass("disabled");
        $("#btnSend .preloader-wrapper").fadeOut(0,function()
        {
            $("#btnSend i").fadeIn();
            $(this).remove();
        });

        Materialize.toast('Error interno: No se pudo guardar contraseña', 3000,"red");
        console.error("JSON-Error->UpdatePass(): "+AjaxObject.responseText);
    });
}

</script>        

<?php
        return;
    }
?>

<a class="btn-floating btn-medium blue darken-1 waves-effect" style="position:absolute;top:10px;left:10px" href="login">
    <i class="material-icons">arrow_back</i>
</a>	

<div class="row center">
    <form id="frmReset" action="javascript:SendResetEmail()" method="POST" autocomplete="off">
        <label class="light"> Restablecer contraseña </label>
        <label id="lberror" class="light" style="display:none"></label>        
        <div class="input-field col s12">		
            <input type="email" class="validate" name="correo" id="txtcorreo" required />
            <label for="txtcorreo">Correo</label>
        </div>
        <input type="submit"  value="Ingresar" style="display:none"/>
        <a id="btnSend" class="btn-floating btn-large right right-top-margin blue darken-1 waves-effect"   onclick="$(this).parents().find(':submit').click();">
            <i class="material-icons">send</i>
        </a>	
    </form>
</div>


<script>

var SmallLoader = 
' <div class="preloader-wrapper small active" style="margin-top:10px">' +
    '<div class="spinner-layer spinner-blue-only">' +
      '<div class="circle-clipper left">'+
        '<div class="circle"></div>'+
      '</div><div class="gap-patch">'+
        '<div class="circle"></div>'+
      '</div><div class="circle-clipper right">'+
        '<div class="circle"></div>'+
      '</div>'+
    '</div>'+
  '</div>'

var ajax_request;
function SendResetEmail()
{
    if($("#btnSend").hasClass("disabled"))
        return;        
    
    if(ajax_request) ajax_request.abort();

    var email = $("#txtcorreo").val();

    $("#btnSend").addClass("disabled");
    $("#btnSend i").fadeOut(0,function(){
        $("#btnSend").append(SmallLoader);
    });

    ajax_request = $.ajax({
        url: "<?php echo GetURL("modulos/modresetpass/serviceresetpass.php?accion=1")?>",
        method: "POST",
        dataType: "JSON",
        data: {email:email}
    });
    
    ajax_request.done(function(data)
    {                
        $("#btnSend").removeClass("disabled");
        $("#btnSend .preloader-wrapper").fadeOut(0,function()
        {
            $("#btnSend i").fadeIn();
            $(this).remove();
        });

        if(data["status"] == 200)
        {
            Materialize.toast('Correo enviado', 2000,"green",
            function()
            {
                location.href="<?php echo GetURL("login")?>";
            });
            return;
        }

        if(data["status"] == 172)
        {
            Materialize.toast('No se pudo enviar el correo', 3000,"red");
            console.error("Error->SendResetEmail(): "+data["error"]);
            return;
        }

        if(data["status"] == 404)
        {
            //Materialize.toast('No hay ningun usuario asociado a ese correo', 3000,"red");
            Materialize.toast('No se encontro ese correo', 3000,"red");
            return;            
        }

        if(data["status"] == 999)
        {
            Materialize.toast('Por favor espere '+data["left"]+"seg para volver a intentar", 3000,"red");
            return;
        }

        Materialize.toast('Error interno: No se pudo enviar el correo', 3000,"red");
        console.error("JSON-Error->SendResetEmail(): "+data);
    });	

	ajax_request.fail(function(AjaxObject)
    {
        $("#btnSend").removeClass("disabled");
        $("#btnSend .preloader-wrapper").fadeOut(0,function()
        {
            $("#btnSend i").fadeIn();
            $(this).remove();
        });        
        Materialize.toast('Error interno: No se pudo enviar el correo', 3000,"red");
        console.error("JSON-Error->SendResetEmail(): "+AjaxObject.responseText);
    });		        
}
</script>