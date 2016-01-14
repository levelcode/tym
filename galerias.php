<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'La descripción aquí',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Galerías - '._TITULO,
	'css' => array(
		'recursos/css/galerias.css'
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
				<h1 class="text-uppercase">Galería</h1>
			</div>

			<section id="galeria">
				<div class="container">
					<div class="row">
						<div class="col-sm-4">
							<div class="galeria">
								<img src="recursos/img/foto-galeria-1.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Car Audio</span><br>
									<span class="txt-18 c-color1">2012</span>
								</a>
							</div>
							<div class="galeria">
								<img src="recursos/img/foto-galeria-2.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 1</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="galeria">
								<img src="recursos/img/foto-galeria-3.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 2</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="galeria">
								<img src="recursos/img/foto-galeria-4.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 3</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
							</div>
							<div class="galeria">
								<img src="recursos/img/foto-galeria-5.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 4</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
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
		'recursos/js/galerias.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/productListHeaderCtrl.js',
		'server/js/angularApp/controllers/productListCtrl.js',
		'server/js/angularApp/controllers/productDetailCtrl.js',
		'server/js/angularApp/controllers/monthPromotionCtrl.js',
		'server/js/angularApp/controllers/shoppingCartAxuCtrl.js',
		'server/js/angularApp/controllers/modals/LoginSignUpCtrl.js',
		'server/js/angularApp/controllers/modals/profileCtrl.js',
		'server/js/angularApp/controllers/modals/shoppingCartCtrl.js',
		'server/js/angularApp/services/constantService.js',
		'server/js/angularApp/services/utilService.js'
	)
);

$pie = new html\Pie($opciones);

?>
