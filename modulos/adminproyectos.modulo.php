<?php
	global $mysqli;
	global $OnDashboard;
	
	if($OnDashboard != 1 || !login_check($mysqli))
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
	
	if(!esadmin($mysqli))
	{
		echo "<div class=\"row\">
                <div class=\"col s12 m12\">
                    <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                            <span class=\"card-title\">Warning!</span>
                                <p>You need administration access to view this information.</p>
                        </div>
                    <div class=\"card-action\">
                        <a class=\"modal-trigger\" href=\"#\">Sign in</a>
                    </div>
                </div>
            </div>
        </div>";
		return;
	}    
    
?>
<div class="row">
    <div class="container">
        <!--Module Title-->
        <div class="row">
            <h3 class="light center blue-grey-text text-darken-3">Administrar Proyectos</h3>
            <p class="center light">Cree y organice los proyectos.</p>            
        </div>
        <!--END Module Title-->
        
        <!--Module Data-->
        <div class="row">
            <ul id="proyectostb" class="fixed-drop no-margin">
                <?php
                    $stmt = $mysqli->select("proyectos",
            [

               "proyectos.idproyecto",

                "proyectos.nombre",
                "proyectos.lugar",
                "proyectos.fecha" 

            ],[
               "ORDER" => "proyectos.idproyecto DESC",
                "LIMIT"=>  6

            ]);

            if(!$stmt)
            {
                if($mysqli->error()[2] != "")
                    echo "Error:".$mysqli->error()[2];

                return;
            }
            
            if(empty($stmt))
            {
                echo "none";
                return;
            }	
            
            foreach($stmt as $row){
                echo 
                '   <li    id="'.$row["idproyecto"].'" class="dataproyectos">
                        <a href="crearproyecto/'.$row["idproyecto"].'">';
                echo'
                            <div class="col s12 m4 four-cards">                                    
                                <div class="card custom-small">
                                    <div class="card-image">   
                                        <img id="ProyectImage" class="responsive-img" style="height:120px;width:100%; object-fit:cover" src="'.GetProyectImagePath($row["idproyecto"], false).'">
                                    </div>

                                    <div id="proyect-overview'.$row["idproyecto"].'" class="card-content-custom">                                            
                                        <div class="black-text card-title-small">'.$row["nombre"].'</div>
                                        <div class="grey-text card-subtitle-small ">'.$row["lugar"].'</div>
                                    </div>
                                </div> 
                            </div>
                            </a>
                        </li>
                ';
            }           
                ?>
            </ul>
            
        </div>
        <input type="hidden" id="result_no" value="6">
        <div class="row">
            <div id="pulldata" class="section center-align">
                <a id="loadMore" onclick="javascript:loadmore()" class="btn-flat light-blue-text accent-4 z-depth-2 waves-effect"> Cargar más                    
                </a>
                <div id="loader"></div>
            </div>
        </div>
        <!--END Module Data-->
    
        <!--Module Action Button-->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="crearProyecto" onclick="OpenNewModal()" data-target="frmagregar" class="btn-floating btn-large blue-grey darken-2 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Nuevo proyecto">
                <i class="large material-icons">add</i>
            </a>               
        </div>
        <!--END Module Action Button-->
    </div>
</div>
   
<!--CREATE PROYECT MODAL-->
<div id="nuevo-proyecto" class="modal create-item">
    <div class="modal-content">
        <h5>Crear un proyecto</h5>
        
        <form id="frmnewproyect" autocomplete="off">
            <div class="row card-content">               
                <div class="input-field col s12">
                    <input id="nombre" name="nombre" type="text" class="validate" required length ="50" maxlength="50">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field col s12">
                    <input id="lugar" name="lugar" type="text" class="validate" required length="25" maxlength="25">
                    <label for="lugar">Lugar</label>
                </div>               
               <!-- <input  id="sendForm" type="submit" style="visibility:hidden" disabled="disabled">-->
            </div>           
        </form>       
        
    </div>
    
    <div class="modal-footer">
        <a id="guardar" onclick="javascript:OpenEditModal()"  class="disabled modal-action  btn-flat  waves-effect waves-light">Crear</a>
        
        <a id="cancel" class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
    </div>        

</div>
<!--END CREATE PROYECT MODAL-->

<!-------------------------------------------- MODAL EDITAR INFO PROYECTO ------------------------------------->
<div    id="custom-proyecto" class="modal modal-fixed-footer custom-item">
    <div class="modal-content no-padding">
        <form id="frmcustomproyect" autocomplete="off" method="POST" enctype="multipart/form-data" action="javascript:CrearProyecto()">
            <a class="" action="">
            <div id="proyectimg" class="card-image">
                <?php               
                    echo "<img id=\"Proyect-Image\" class=\"\" style=\"object-fit:cover; height:220px;width:100%\" src=\"".GetProyectImagePath(0)."\">";
                ?>
                <input style="display:none" type="file" name="imagen" id="FileInput" accept=".png,.jpg"/>
            </div>           
            <span><a id="" onclick="$('#proyectimg').find('#FileInput').click();" class="waves-effect waves-circle input-secondary-menu white-text"><i class="material-icons" style="padding:4px">camera_alt</i></a></span>
            </a>
            <div class="description">
                <div class="row card-content">               
                    <div class="input-field col s12">
                        <input id="nombre-proyecto" length="50" maxlength="50" name="nombre-proyecto" type="text" class="validate" required> 
                        <label for="nombre-proyecto">Proyecto</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="lugar-proyecto" length="25" maxlength="25" name="lugar-proyecto" type="text" class="validate" required>
                        <label for="lugar-proyecto">Lugar</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="fecha-proyecto" name="fecha-proyecto" type="date"  class="datepicker validate" required>
                        <label class="active" for="fecha-proyecto">Fecha</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="contenido-proyecto" name="contenido-proyecto" maxlength="300" length="300" class="materialize-textarea" required></textarea>
                        <label for="contenido-proyecto">Descripción</label>
                    </div> 
                    <input  type="submit" style="display:none">
                </div> 
            </div>
        </form>       
    </div>
    <div class="modal-footer">
           <a id="update-yes" onclick="$('#frmcustomproyect').find(':submit').click();" class="btn-flat blue-text text-darken-1 waves-effect ">Salvar<i class="material-icons right"></i></a>
           <a id="update-no"  class="btn-flat modal-action modal-close waves-effect waves-light">Cancelar<i class="material-icons right"></i></a>           
        </div>        
</div>
<!-------------------------------------------- MODAL EDITAR INFO PROYECTO ------------------------------------->


<script>
        
    $(document).ready(function(){  
        
        //initialize datepicker
        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 8, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd' ,
            max: true //Limits date to current date
        });
        
        //end datepicker
        
        //IMAGE PREVIEW
        $(":file").change(handleFileSelect);
                
        //toggle submit button in modal
         $('#nombre').keyup(function() {

            var empty = false;
            $('#nombre').each(function() {
                if ($(this).val().length == 0) {
                    empty = true;
                }
            });

            if (empty) {
                $('#guardar').addClass("disabled");
                $('#guardar').removeClass("modal-close");
                $('#guardar').removeClass("blue-text");
               
            } else {
                $('#guardar').removeClass("disabled");
                $('#guardar').addClass("modal-close");
                $('#guardar').addClass("blue-text");
            }
        });
        
        //end toggle
        
        //get data
        $.ajax({
			url:"<?php echo GetURL("modulos/modadminproyectos/serviceadminproyectos.php?accion=1") ?>"
		}).done(
			function(data){
                if(data == "none")
				{
                    $("#proyectostb").append('<li class="DataEmpty center"><div class="center grey-text"Es hora de agregar tu primer proyecto.</div></li>');                    
					return;
				}
				$("#proyectostb").append(data);	                
                $(".dataproyectos").fadeIn();
				//Materialize.showStaggeredList("#proyectostb");
			}
		);
        
        //end get data
    }); //end document ready
    function loadmore()
    {
        $("#loadMore").hide();
        $("#loader").append(preloader);
      var val = document.getElementById("result_no").value;
      $.ajax({
      type: 'post',
      url: "<?php echo GetURL("modulos/modadminproyectos/loadproyectos.php")?>",
      data: {
        getresult:val
      },
      success: function (response) {
        var content = document.getElementById("proyectostb");
          if(response == "")
          {
            $("#loadMore").hide();
              $("#pulldata").append('<div class="DataEmpty center"><div class="center grey-text">Parece que has llegado al final.</div></div>');
                    return;
          }
        $("#loader").hide();
          $("#loadMore").show();
        
        content.innerHTML = content.innerHTML+response;         
        // We increase the value by 2 because we limit the results by 2
        document.getElementById("result_no").value = Number(val)+6;          
      }
      });
    }
    
    //Opening new Proyect modal
    function OpenNewModal (){
        document.getElementById("frmnewproyect").reset();                
        Materialize.updateTextFields(); 
        $('#guardar').addClass("disabled");
        $('#guardar').removeClass("modal-close");
        $('#guardar').removeClass("blue-text");
        
        $("#nuevo-proyecto").openModal({                    
            complete: function() { 
                document.getElementById("frmnewproyect").reset();                
                Materialize.updateTextFields();  
                $('#guardar').addClass("disabled");
                $('#guardar').removeClass("modal-close");
                $('#guardar').removeClass("blue-text");
            }
        });
    }
    
    //end opening modal
    
    
    //Open edit modal
    function OpenEditModal()
    { 	
        if(($("#nombre").val() && $("#lugar").val()) == "")
            {
                Materialize.toast('Todos los campos son requeridos.', 3000);
            }
        else{
            $("#nuevo-proyecto").closeModal();     
            
            //Reset modal and get values from previous
            $("#custom-proyecto").find("form").trigger("reset");
            $("#nombre-proyecto").val($("#nombre").val());
            $("#lugar-proyecto").val($("#lugar").val());            
            Materialize.updateTextFields();
            
            //Open modal and prevent closing by clicking outside 
            $('#custom-proyecto').openModal({
                dismissible: false,
            });
        }
    }
    
    
    function CrearProyecto (){   
        var formData = new FormData($('#frmcustomproyect')[0]);
     
        $.ajax({
            url:"<?php echo GetURL("modulos/modadminproyectos/serviceadminproyectos.php?accion=2")?>",
            method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false           
        }).done(function(last_id){
            Materialize.toast('Creando...', 3000);
            $("#custom-proyecto").closeModal();
            if(last_id != "0"){                
                location.href= "crearproyecto/"+last_id;                
            }
        });      
    }
</script>