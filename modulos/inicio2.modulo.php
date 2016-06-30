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
	<div class="row container"> <!-- SECTION TITLE -->
		<h2 class="light center blue-grey-text text-darken-2">Sinhco</h2>
		<p class="center light">Especializados en el suministro e instalación de obras civiles, hidráulicas y eléctricas,incluyendo la comercialización de equipos.</p>
	</div>
	<div class="row">
        <div class="col s12 m4">
            <div class="center">
                <a  class="btn-floating btn-large grey lighten-5 ">
                    <span><i class="material-icons light-blue-text text-accent-4">group</i></span>
                </a>
                <h5 class="grey-text text-darken-1">La Empresa</h5>
                <div class="container">
                    <p class="">Conformada por profesionales de la ingeniería civil, industrial, mecánica, electrónica y eléctrica con más de 15 años de experiencia en cada rama, personal técnico y auxiliar calificado.</p>                    
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="center">
                <a  class="btn-floating btn-large grey lighten-5 ">
                    <span><i class="material-icons light-blue-text text-accent-4">shopping_cart</i></span>
                </a>
                <h5 class="grey-text text-darken-1">Productos</h5>
                <div class="container">
                    <p class="">Marcas reconocidas y de alta calidad, circunstancia que nos permite manejar un alto control de calidad y ofrecer a nuestros clientes garantías de funcionamiento e instalación.</p>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="center">
                <a  class="btn-floating btn-large grey lighten-5 ">
                    <span><i class="material-icons light-blue-text text-accent-4">headset_mic</i></span>
                </a>
                <h5 class="grey-text text-darken-1">Servicios</h5>
                <div class="container">
                    <p class="">Ingeniería hidráulica, mecánica y civil, entre otros. Ofreciendo calidad basada en tecnología de punta y con el respaldo de personal capacitado y comprometido.</p>
                </div>
            </div>
        </div>
	</div>
</div> <!-- FOR CONTAINER end -->

<div class="parallax-container z-depth-1">
	<div class="section no-pad-bot">
		<div class="parallax"><img class="" src="/recursos/recursos/img/parallax.jpg"></div>
	</div>
</div>

<div id="products" class=""></div>
<div class="section indigo-bg"> <!-- FOR CONTAINER -->
	<div class="row"> <!-- SECTION TITLE -->
		<h3 class="light center blue-grey-text text-darken-2">Nuestros productos</h3>
		<p class="center light">Conoce nuestra variedad de productos</p>
	</div>
	<div class="row container"> <!-- SECTION CONTENT -->
        <div class="col s12 m6 l6">
          <div class="card">
            <div class="card-image">
              <img src="/uploads/static/norweco.jpg">              
            </div>            
            <div class="card-action">
              <a href="norweco">Ver productos</a>
            </div>
          </div>
        </div>
        <div class="col s12 m6 l6">
          <div class="card ">
            <div class="card-image">
              <img src="/uploads/static/rotoplas.jpg">
            </div>            
            <div class="card-action">
              <a href="productos">Ver productos</a>
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
					<img src="/recursos/recursos/img/Gildan.png">
				</li>
				<li class="col s12 m6 l3">
					<img src="/recursos/recursos/img/collective.jpg">
				</li>
				<li class="col s12 m6 l3">
					<img src="/recursos/recursos/img/colonia.png">
				</li>
				<li class="col s12 m6 l3">
					<img src="/recursos/recursos/img/antorcha.png">
				</li>
			</ul>             
		</div>
	</div> <!-- FOR CONTAINER end -->

