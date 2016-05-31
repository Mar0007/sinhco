<?php
	global $mysqli;
	global $SEGURIDAD;
	global $OnDashboard;
	
	if($SEGURIDAD != 1)
	{
		if($OnDashboard)
		{
			require_once("modulos/dashboard.modulo.php");
			return;
		}
		
		echo "<h1>Acceso denegado</h1>";
		return;
	}		
?>
<a href="#sinhco-intro" class="hide-on-med-and-down floating-btn fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
    <span><i class="material-icons">expand_more</i></span>
</a>
<div id="sinhco-intro" class="section"></div>
<div class="section"><!-- FOR CONTAINER end -->
	<div class="row"> <!-- SECTION TITLE -->
		<h2 class="light center blue-grey-text text-darken-2">Sinhco</h2>
		<p class="center light">Especializados en el suministro e instalación de obras civiles, hidráulicas y eléctricas,incluyendo la comercialización de equipos.</p>
	</div>
	<div class="row">
		<div class="col s12 m4">
			<div class="">
			<h2 class="center light-blue-text text-accent-4"><i style="font-size:54px" class="material-icons">group</i></h2>
			<h5 class="center">La Empresa</h5>

			<p class="light">Conformada por profesionales de la ingeniería civil, industrial, mecánica, electrónica y eléctrica con más de 15 años de experiencia en cada rama, personal técnico y auxiliar calificado.</p>
			</div>
		</div>        
		<div class="col s12 m4">
			<div class="">
				<h2 class="center light-blue-text text-accent-4"><i style="font-size:54px" class="material-icons">shopping_cart</i></h2>
				<h5 class="center">Productos</h5>

				<p class="light">Marcas reconocidas y de alta calidad, circunstancia que nos permite manejar un alto control de calidad y ofrecer a nuestros clientes garantías de funcionamiento e instalación.</p>
				</div>
		</div>
		<div class="col s12 m4">
			<div class="">
			<h2 class="center light-blue-text text-accent-4"><i style="font-size:54px" class="material-icons">location_on</i></h2>
			<h5 class="center">Visítanos</h5>
			<p class="light">Nuestra sede está en San Pedro Sula, Cortes y atendemos en cualquier zona del país.</p>
			</div>
		</div>
	</div>
</div> <!-- FOR CONTAINER end -->

<div class="parallax-container z-depth-1">
	<div class="section no-pad-bot">
		<div class="parallax"><img class="" src="../recursos/img/parallax.jpg"></div>
	</div>
</div>

<div id="products" class=""></div>
<div class="section indigo-bg"> <!-- FOR CONTAINER -->
	<div class="row"> <!-- SECTION TITLE -->
		<h3 class="light center blue-grey-text text-darken-2">Nuestros productos</h3>
		<p class="center light">Conoce nuestra variedad de productos</p>
	</div>
	<div class="row"> <!-- SECTION CONTENT -->
		<div class="col s12 m4 l4">
			<div class="card">
				<div class="card-image">
					<img src="../recursos/img/norweco.png">
					<a href="products.html" class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
						<span><i class="material-icons">open_in_new</i></span>
					</a>
				</div>
				<div class="card-content">
					<h2 class="card-title">Norweco</h2>
					<p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p>
				</div>                       
			</div>
		</div>
		<div class="col s12 m4 l4">
			<div class="card">
				<div class="card-image">
					<img src="../recursos/img/rotoplas.png">
					<a href="products.html" class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
						<span><i class="material-icons">open_in_new</i></span>
					</a>
				</div>
				<div class="card-content">
					<h2 class="card-title">Rotoplas</h2>
					<p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p>
				</div>                     
			</div>
		</div>
		<div class="col s12 m4 l4">
			<div class="card">
				<div class="card-image">
					<img  src="../recursos/img/fill-rite.png">
					<a href="products.html" class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light">
						<span><i class="material-icons">open_in_new</i></span>
					</a>                                
				</div>                            
				<div class="card-content">
					<h2 class="card-title">Fill-Rite</h2>
					<p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p>
				</div>                       
			</div>				    
	</div>
	</div>
</div><!-- FOR CONTAINER end -->

<div class="section banner z-depth-1">
	<div class="container">
		<h1 class="no-mar-bot thin">Alto control de calidad</h1>
		<h5 class="medium">Contamos con el respaldo de los fabricantes de los equipos que suministramos.</h5>
		<!--<a href="products.html" class="light-blue-text text-accent-4 medium">VER TODOS LOS PRODUCTOS<span><i class="fix-icon center light-blue-text text-accent-4 material-icons">navigate_next</i></span></a>-->
	</div>
	<div class="section"></div>            
</div>

<div id="outro" class="section"></div>
<div class="section"><!-- FOR CONTAINER end -->
	<div class="row"> <!-- SECTION TITLE -->
		<h2 class="light center blue-grey-text text-darken-3">Confían en nosotros</h2>
		<p class="center light"></p>
	</div>
	<div class="row">
		<div class="col m12">
			<ul class="row brand-list">
				<li class="col s12 m6 l3">
					<img src="../recursos/img/Gildan.png">
				</li>
				<li class="col s12 m6 l3">
					<img src="../recursos/img/collective.jpg">
				</li>
				<li class="col s12 m6 l3">
					<img src="../recursos/img/colonia.png">
				</li>
				<li class="col s12 m6 l3">
					<img src="../recursos/img/antorcha.png">
				</li>
			</ul>             
		</div>
	</div> <!-- FOR CONTAINER end -->

<!-- Modal Structure -->
<div id="modal1" class="modal">
	<div class="modal-content no-padding">
		<div class="row">
			<div id="product-img" class="col s12 m12 l5 no-padding">
				<img class="responsive-img" src="../recursos/img/tanque.jpg">
			</div>
			<div class="col s12 m12 l7 description">
				<span><i class="modal-action modal-close material-icons right">close</i></span>
				<h4 class="">Tanques para Agua y Químicos</h4>
				<h6 class="grey-text text-lighten-1">Almacenamiento</h6>
				<p class="flow-text">Los tanques Rotoplas son ideales para el acopio de agua en granjas durante tiempos de sequía, así como para el almacenamiento de melazas, alimentos y más de 300 sustancias químicas tales como: ácidos, cloruros y fosfatos.</p>     
				<div style="height:30px" class="section "></div>
				<a  style="bottom: 45px; right: 24px;" class="right btn waves-effect wave-light light-blue accent-4">Ver producto</a>                          
			</div>
		</div>
	</div>
</div>
