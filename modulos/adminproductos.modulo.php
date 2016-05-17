<?php
	global $mysqli;
	//global $SEGURIDAD;
    global $OnDashboard;
	
	if($OnDashboard != 1 || !login_check($mysqli))
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}
    $idusuario= "aa";
?>
<div class="container"> 
  <!--Module Data--> 
        <div class="row">
          <div class="col s5 left">                 
          	<div class="slider">
            	<ul class="slides">
                	<li>
                    	<img  src="/sinhco/recursos/img/proyect.jpg"> 
                        <div class="caption center-align">
                          
                        </div>
                      </li>
                      <li>
                        <img  src="/sinhco/recursos/img/proyect.jpg"> 
                        <div class="caption left-align">
                          
                        </div>
                      </li>
                      <li>
                        <img  src="/sinhco/recursos/img/proyect.jpg"> 
                        <div class="caption right-align">
                          
                        </div>
                      </li>
                      
                </ul>
           	</div>
                  
         	<div id="Econtenido">
					<form id="frmeditar" action="javascript:Editar()">
						<div class="input-field col s12 m12 l12">
						<i class="material-icons prefix">assignment_ind</i>
						<input id="otronombre" type="text" class="validate" required>
						<label for="otronombre">Nombre del producto</label>
						</div>
						
						<div class="input-field col s12 m12 l12">
						<i class="material-icons prefix">assignment_ind</i>
						<textarea  id="otradescripcion" class="validate materialize-textarea"  required></textarea>
						<label for="otradescripcion">Descripcion del producto</label>
						</div>
						<input type="submit" style="display:none">
						
						<div class="input-field col s12">
						<!-- <i class="material-icons prefix">assignment_ind</i> -->	
                        <select id="cbCategorias">
                            <option value="" href="" disabled>Elija la categoria</option>
                            <?php
                            
                                $stmt = $mysqli->select("categoria_producto",
                                [
                                    "idcategoria","nombre"
                                ]);
                                
                                if($stmt)
                                {
                                    foreach($stmt as $row)
                                        echo '<option value="'.$row["idcategoria"].'">'.$row["nombre"].'</option>';
                                }
                                                                          					
                            ?>				
                        </select>
                        <label for="cbCategorias">Categorias</label>
				    	</div>
						
						<div class="input-field col s12">
						<!--<i class="material-icons prefix">assignment_ind</i> -->	
                        <select id="cbProveedores">
                            <option value="" href="" disabled>Elija la categoria</option>
                            <?php
                            
                                $stmt = $mysqli->select("proveedores",
                                [
                                    "idproveedor","nombre"
                                ]);
                                
                                if($stmt)
                                {
                                    foreach($stmt as $row)
                                        echo '<option value="'.$row["idproveedor"].'">'.$row["nombre"].'</option>';
                                }
                                                                          					
                            ?>				
                        </select>
                        <label for="cbProveedores">Categorias</label>
				    	</div>
						
						<a id="a" class="waves-effect waves-light btn disabled" ><i class="material-icons left" >done</i>Aplicar Cambios</a>
						<a id="b" class="waves-effect waves-light btn" ><i class="material-icons right" >cancel</i>Cancelar</a>
						
					</form>
            </div>
          </div>

			<div class="col s7 right" id="productocard">	
				
				
			</div>
				<ul class="pagination">
				
                
				</ul>
				
			
		</div>
</div>
	<style>
		     
    .card .card-action-custom{
        padding: 20px;
        padding-top: 0px;
    }
		.card .custom-content{
        height: 70px;
       max-height:70px;
    }
	
	</style>
  			<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a id="crearProyecto" onclick="OpenModal()" class="btn-floating btn-large blue-grey darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Nuevo producto">
                <i class="large material-icons">mode_edit</i>
            </a>
			</div>

    <!-- Agregar -->
<div id="modalFrmAdd" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Agregar Productos</h4>
		<div class="divider"></div>
		<form id="frmagregar" action="javascript:Agregar()">
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="Nombre" type="text" class="validate"  required  maxlength="50" length="50">
			<label for="Nombre">Nombre del producto</label>
			</div>		
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">perm_identity</i>
			<input id="Descripcion" type="text" class="validate" required>
			<label for="Descirpcion">Descripcion</label>
			</div>
            <div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="Estado" type="text" >
			<label for="Estado">Estado</label>
			</div>		
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">perm_identity</i>
			<input id="Precio" type="text" >
			<label for="Precio">Precio</label>
			</div>
            <div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="IdProveedor" type="text" class="validate"  required>
			<label for="IdProveedor">IdProveedor</label>
			</div>		
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">perm_identity</i>
			<input id="IdCategoria" type="text" class="validate" required>
			<label for="IdCategoria">IdCategoria</label>
			</div>
			
			<div class="input-field col s12">
						<!-- <i class="material-icons prefix">assignment_ind</i> -->	
                        <select id="IdCategoria">
                            <option value="" href="" disabled>Elija la categoria</option>
                            <?php
                            
                                $stmt = $mysqli->select("categoria_producto",
                                [
                                    "idcategoria","nombre"
                                ]);
                                
                                if($stmt)
                                {
                                    foreach($stmt as $row)
                                        echo '<option value="'.$row["idcategoria"].'">'.$row["nombre"].'</option>';
                                }
                                                                          					
                            ?>				
                        </select>
                        <label for="IdCategoria">Categorias</label>
				    	</div>
						
						<div class="input-field col s12">
						<!--<i class="material-icons prefix">assignment_ind</i> -->	
                        <select id="IdProveedor">
                            <option value="" href="" disabled>Elija la categoria</option>
                            <?php
                            
                                $stmt = $mysqli->select("proveedores",
                                [
                                    "idproveedor","nombre"
                                ]);
                                
                                if($stmt)
                                {
                                    foreach($stmt as $row)
                                        echo '<option value="'.$row["idproveedor"].'">'.$row["nombre"].'</option>';
                                }
                                                                          					
                            ?>				
                        </select>
                        <label for="IdProveedor">Categorias</label>
				    	</div>
			
			<input type="submit" value="Guardar" style="display:none">  						
		</form>
	</div>
	<div class="modal-footer">		
	  <button id="btnCancelDialogUsr" class="btn waves-effect waves-light red modal-action modal-close">Cancelar
    	<i class="material-icons left">close</i>
  	  </button>
	  <button id="btnSaveDialogUsr" class="btn waves-effect waves-light green" style="margin-right:10px" onclick="$('#modalFrmAdd').find('form').find(':submit').click()">
    	<i class="material-icons left">library_add</i>Agregar
  	  </button>
    </div>	
</div>

 <!-- Editar -->  
<div id="modalFrmEdit" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Editar Producto</h4>
		<div class="divider"></div>
		<form id="frmeditar" action="javascript:Editar()">
			<div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="ENombre" type="text" class="validate" required>
			<label for="ENombre">Nombre del producto</label>
			</div>
            
            <div class="input-field col s12 m12 l6">
			<i class="material-icons prefix">assignment_ind</i>
			<input id="EDescripcion" type="text" class="validate"  required>
			<label for="EDescripcion">Descripcion del producto</label>
			</div>
            <input type="submit" style="display:none">
        </form>
    </div>
    <div class="modal-footer">		
	  <button id="btnCancelDialogUsr" class="btn waves-effect waves-light red modal-action modal-close">Cancelar
    	<i class="material-icons left">close</i>
  	  </button>
	  <button id="btnSaveDialogUsr" class="btn waves-effect waves-light green" style="margin-right:10px" onclick="$('#modalFrmEdit').find('form').find(':submit').click()">
    	<i class="material-icons left">library_add</i>Agregar
  	  </button>
    </div>
</div>

    

<script>
 
 $(document).ready(function(){
      $('.slider').slider({full_width: true});
	   $('select').material_select();
        $.ajax({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=1") ?>"
		}).done(
			function(data){
				$("#productocard").append(data);
				
			}
		);
		
		 $.ajax({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=5") ?>"
		}).done(
			function(data){
				$(".pagination").append(data);
				
			}
		);
		
    }); 
    
	function Paginar(ll){
	
	
    $(ll).removeClass('active');

		var d=0;
		var h=6;
		var a=0;
		//var cells = $(".pagination").children();
		 a=ll.innerText;
		
				
		//	a=$(this).getElementsByTagName("a")[0].innerHTML ;
			a= a*6;
			d= a-6;
			
			$.ajax({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=0") ?>",
			method: "POST",
			data: {d:d,h:h}
			
		}).done(
			
			function(data){
					
				$("#productocard").fadeOut(function(){
					
					$(this).empty();
				$("#productocard").prepend(data);	
						$(this).fadeIn();		
														
				});	
					
			//ll.setAttribute("class", "active");
			
			}
			
		);
		
						
			
	}
  function OpenModal(ID)
	{
        if(ID){
            var frm = $('#modalFrmEdit').find('form');
		frm.trigger('reset');
        
            //Get row cells
				var cells = $("#Card_"+ID).children();
				//Set Nombre
				$("#ENombre").val(cells[0].children[1].children[0].innerHTML);
				$("#otronombre").val(cells[0].children[1].children[0].innerHTML);
				//Set descripcion
                $("#EDescripcion").val(cells[0].children[1].children[1].innerHTML);
				$("#otradescripcion").val(cells[0].children[1].children[1].innerHTML);
				//cells[0].children[3].children[2].innerHTML
				//Set Categoria
				//cells[0].children[3].children[1].innerHTML
                
				
        frm.attr('action','javascript:Editar('+ID+')')
		//At last open it.		
        $('#modalFrmEdit').openModal();
		
         
            
        }
        else{
		var frm = $('#modalFrmAdd').find('form');
		frm.trigger('reset');
							
		//At last open it.
		$('#modalFrmAdd').openModal();
		
        }
	}
    
  function Seleccionar(IdProductos)
	{
		 var frm = $('#modalFrmEdit').find('form');
		 frm.trigger('reset');
        
		$("a").removeClass('disabled');
            //Get row cells
				var cells = $("#Card_"+IdProductos).children();
				//Set Nombre
				
				$("#otronombre").val(cells[0].children[1].children[0].innerHTML);
				//Set descripcion
                
				$("#otradescripcion").val(cells[0].children[1].children[1].innerHTML);
				
				$("#a").unbind('click').click(function(){
					Editar(IdProductos);
				}
				
				);
				
				$("#b").unbind('click').click(function(){
					Eliminar(IdProductos);
				}
				
				);
				
                
				
       
	}
    
function Agregar()
	{														
					
		
		
		var Nombre 		= $("#Nombre").val();
        var Descripcion = $("#Descripcion").val();
        var Estado      = $("#Estado").val();
        var Precio      = $("#Precio").val();
        var IdCategoria = $("#IdCategoria").val();
        var IdProveedor = $("#IdProveedor").val();
        //var estado 	= $("#Estado").val();
								
		
		ShowLoadingSwal();
																			
		$.ajax(
			{
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=2")?>",
			method: "POST",
			data: {Nombre:Nombre,Descripcion:Descripcion,Estado:Estado,IdCategoria:IdCategoria,IdProveedor:IdProveedor,Precio:Precio}
		}).done(function(data){
			$("#modalFrmAdd").closeModal();
			if(data.indexOf("<div") > -1)
			{
				swal.close();			
				$("#productocard").append(data);
				
			}
			else
				swal("Error", data, "error");
		});								
	}
    
function Editar(IdProductos)
	{
        
		var Nombre        = $("#otronombre").val();
		var Descripcion	  = $("#otradescripcion").val();

		ShowLoadingSwal();
		$.ajax
		({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=3")?>",
			method: "POST",
			data: {IdProductos:IdProductos,Nombre:Nombre,Descripcion:Descripcion}
		}).done(function(data){
            $("#modalFrmEdit").closeModal();
			if(data == "0")// si esta 
			{
                swal.close();
				$("#Card_"+IdProductos).fadeOut(function()
			{
				//Get row cells
                var cells = $("#Card_"+IdProductos).children();
				// Set Nombre
				cells[0].children[1].children[0].innerHTML = Nombre;		
				//Set Descripcion
				cells[0].children[1].children[1].innerHTML = Descripcion;
				$(this).fadeIn();								
			});					
			}				
			else
				swal("Error", data, "error");
		});					
	}
	
	
	
	
function Eliminar(id)
  {
	
	var IdProductos= id;
	
	swal({
		title:  "¿Eliminar Registro ?" ,
		text: "¿Desea eliminar el registro seleccionado?",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true,
		},
		function()
		{				
		$.ajax({
			url:"<?php echo GetURL("modulos/modadminproductos/serviceadminproductos.php?accion=4")?>",
			method: "POST",
			data: {IdProductos:IdProductos}
		}).done(function(data){
			if(data == "0")
			{
				$("#Card_"+IdProductos).fadeOut(function(){
					$(this).remove();
															
				});			
				swal("Borrado", "Se borro exitosamente.", "success");
			}
			else
				swal("Error", data, "error");
		});		  		
	});		  
  }
</script>