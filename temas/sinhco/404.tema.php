<?php 
  require_once('funciones.php');
  header("HTTP/1.1 404 Not Found"); 
?>

<!DOCTYPE html>
<html lang="es_HN">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Sinhco</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo GetURL($tema."css/materialize.css")?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo GetURL($tema."css/styles.css")?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="<?php echo GetURL($tema."js/materialize.min.js")?>"></script>
    
</head>
<body>
    
<div class="row center " style="margin-top: 50px">
        <div class="col s12">
            <img src="<?php echo GetURL("recursos/img/sinhco.png")?>">
        </div>  
</div>
    <div class="container center-wrapper" style="margin-top: 10%">
        <div class="row">
            <div class="col s12 ">
              <div class="card">
                <div class="card-content">
                  <span class="card-title">Lo sentimos. No pudimos encontrar la dirección.</span>                    
                </div>
                <div class="card-action">
                  <a href="javascript:GoBack()">Regresar</a>                  
                </div>
              </div>
            </div>
          </div>
    </div>
    </body>
</html>

<script>
  function GoBack() {
    fallbackUrl = '<?php echo GetURL('inicio')?>';
    var prevPage = window.location.href;

    window.history.go(-1);

    setTimeout(function(){ if (window.location.href == prevPage) window.location.href = fallbackUrl; }, 500);
}
</script>