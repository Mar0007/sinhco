<?php
global $mysqli;

if(!login_check($mysqli))
        {
        echo "<div class=\"row\">
                <div class=\"col s12 m12\">
                    <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                            <span class=\"card-title\">Warning!</span>
                                <p>Login in if you want to see this information. You have to be an administrator in order to make changes and/or visualize this information.</p>
                        </div>
                    <div class=\"card-action\">
                        <a class=\"modal-trigger\" href=\"#modal1\">Sign in</a>
                    </div>
                </div>
            </div>
        </div>";
        return;
    }
    
    if(!esadmin ($mysqli))
        {
        echo "<div class=\"row\">
                <div class=\"col s12 m12\">
                    <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                            <span class=\"card-title\">Warning!</span>
                                <p>You need administration access to view this information.</p>
                        </div>
                    <div class=\"card-action\">
                        <a class=\"modal-trigger\" href=\"#modal1\">Sign in</a>
                    </div>
                </div>
            </div>
        </div>";
        return;
    }
?>

<div class="container story-content">
    <div class="row">
        <h3 class="light center blue-grey-text text-darken-3">Nuevo proyecto</h3>
        <p class="center light">Agregue un nuevo proyecto al portafolio.</p>
        <div class="divider3"></div>
    </div>

   <div id="" class="row">
       <form id="frmnewproyect" autocomplete="off" action="javascript:salvar()">
           <div class="row">               
               <div class="input-field col s8">
                   <input id="nombre" name="nombre" type="text" class="validate" >
                   <label for="nombre">Nombre</label>
               </div>
               <div class="input-field col s8">
                   <input id="lugar" name="lugar" type="text" class="validate" >
                   <label for="lugar">Lugar</label>
               </div>               
               <div class="input-field col s6">
                   <input id="fechaproyecto" placeholder="Fecha de realización" name="datepicker" type="date" class="datepicker">                   
                </div>               
                <div class="input-field col s12">
                   <textarea id="descripcion" class="materialize-textarea"></textarea>
                   <label for="descripcion">Descripción del proyecto</label>
                </div>                 
               <input  type="submit" style="display:none">
           </div>           
       </form>
       <div class="right">
           <a id="cancel" href="adminproyectos" class="btn-flat  waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>
           <a id="guardar" onclick="$('#frmnewproyect').find(':submit').click();" class="btn-flat waves-effect waves-teal ">Agregar<i class="material-icons right"></i></a>           
       </div>
       
    </div>
    
</div>

    
<script>

    $(document).ready(function(){
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd'    
        });
    });
        
    function salvar(){
        $("#guardar").click(function( event ) {
          event.preventDefault();
          });
        
        
        var nombre = $("#nombre").val();
        //var estado= $("#estado").is(":checked")?1:0;
        var lugar = $("#lugar").val();
        var fechaproyecto = $("#fechaproyecto").val();
        var descripcion = $("#descripcion").val;
        
        
             $.ajax({
                url:"<?php echo GetURL("modulos/modcrearproyecto/servicecrearproyecto.php?accion=2") ?>",
                type: 'POST',
                data: {nombre:nombre,lugar:lugar,fechaproyecto:fechaproyecto,descripcion:descripcion}        
              }).done(function(data){
                $("#frmnewproyect").append(data);
                 location.href="adminproyectos";
                 Materialize.toast('Proyecto agregado.', 3000, 'rounded');
                 
              });
    }    
</script>