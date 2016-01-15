<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'La descripción aquí',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Empresas Aliadas - '._TITULO,
	'css' => array(
		'recursos/css/videos.css'
	),
	'js' => array(
		'recursos/js/angular.min.js',
		'recursos/js/ui-bootstrap-tpls-0.13.4.min.js',
		'recursos/js/angular-cookies.min.js',
		'recursos/js/ng-file-upload/ng-file-upload.min.js',
		'recursos/js/angular-sanitize.min.js'
	)
);

$cabecero = new html\Cabecero($opciones);


?>

<!-- contenido -->
		<div id="contenido">
			<div id="titulo">
				<h1 class="text-uppercase">Vídeos</h1>
			</div>

			<section id="videos">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<!-- slider inicio -->
							<div id="rotabanner" class="carousel slide" data-ride="carousel" data-interval="false">
								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox">
									<div class="item active text-center sld-1">
										<div class="embed-responsive embed-responsive-16by9">
											<iframe  src="https://www.youtube.com/embed/hjFPpU9XcFA" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe>
										</div>
									</div>

									<div class="item text-center sld-2">
										<div class="embed-responsive embed-responsive-16by9">
											<iframe  src="https://www.youtube.com/embed/ikE-3OretE0" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe>
										</div>
									</div>

									<div class="item text-center sld-3">
										<div class="embed-responsive embed-responsive-16by9">
											<iframe  src="https://www.youtube.com/embed/57tZ-Ti6AJA" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe>
										</div>
									</div>
								</div>
								<!-- Indicators -->
								<ol class="carousel-indicators">
									<li data-target="#rotabanner" data-slide-to="0" class="active"></li>
									<li data-target="#rotabanner" data-slide-to="1"></li>
									<li data-target="#rotabanner" data-slide-to="2"></li>
								</ol>
								<!-- Controls
								<a class="left carousel-control" href="#rotabanner" role="button" data-slide="prev">
									<div class="flecha">
										<span class="fa fa-angle-left fa-3x"></span>
									</div>
								</a>
								<a class="right carousel-control" href="#rotabanner" role="button" data-slide="next">
									<div class="flecha">
										<span class="fa fa-angle-right fa-3x"></span>
									</div>
								</a>-->
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/videos.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/productListHeaderCtrl.js',
		'server/js/angularApp/controllers/productListCtrl.js',
		'server/js/angularApp/controllers/productDetailCtrl.js',
		'server/js/angularApp/controllers/monthPromotionCtrl.js',
		'server/js/angularApp/controllers/shoppingCartAxuCtrl.js',
		'server/js/angularApp/controllers/menuProductCtrl.js',
		'server/js/angularApp/controllers/modals/LoginSignUpCtrl.js',
		'server/js/angularApp/controllers/modals/profileCtrl.js',
		'server/js/angularApp/controllers/modals/shoppingCartCtrl.js',
		'server/js/angularApp/services/constantService.js',
		'server/js/angularApp/services/utilService.js'
	)
);

$pie = new html\Pie($opciones);

?>
