<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'Progracol es una empresa de ',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => _TITULO,
	'css' => array(
		'recursos/css/index.css'
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

			<?php require_once(_INC.'buscador.php'); ?>
			<?php require_once(_INC.'slider-intro.php'); ?>

			<section id="promociones-galeria">
				<div class="container">
					<div class="row">
						<div class="col-sm-7 promociones st-seccion" ng-controller="monthPromotionCtrl" ng-cloak>
							<div class="row">
								<div class="col-xs-12">

								</div>
								<div class="col-sm-6">
									<div class="st-titulo">
										<small>Nuestra</small>
										<h1>Promoción del mes</h1>
									</div>
									<i class="st-separador"></i>
									<p class="txt-13 ng-cloak" ng-bind="promotion.detail"></p>
								</div>
								<div class="col-sm-6">
									<br>
									<img ng-src="{{promotion.base_img}}" alt="" class="img-responsive">
								</div>
							</div>
						</div>
						<div class="col-sm-5 galeria st-seccion">
							<div class="row">
								<div class="col-lg-5">
									<div class="st-titulo">
										<h1>Galería</h1>
										<small>Vídeos/Eventos</small>
									</div>
									<i class="st-separador"></i>
								</div>
								<div class="col-lg-7">
									<a href="./videos">
										<img src="recursos/img/imac-videos.png" alt="" class="img-responsive">
									</a>
								</div>
							</div>


						</div>
					</div>
				</div>
			</section>

			<section id="te-puede-interesar">
				<div class="container cont st-seccion">
					<div class="row">
						<div class="col-xs-12">
							<div class="st-titulo text-left">
								<h1>Te puede interesar</h1>
								<i class="st-separador"></i>
							</div>
						</div>
					</div>

					<div class="row etiquetas">
						<div class="col-sm-4">
							<div class="row tanques">
								<a class="col-xs-6 cuadro txt">
									<i>Tanques</i>
								</a>
								<div class="col-xs-6 cuadro no-padding bg">
									<!-- <img src="recursos/img/img-tanques.jpg" class="img-responsive hidden-xs"> -->
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row racks">
								<a class="col-xs-6 cuadro txt">
									<i>Racks</i>
								</a>
								<div class="col-xs-6 cuadro no-padding bg">
									<!-- <img src="recursos/img/img-racks.jpg" class="img-responsive hidden-xs"> -->
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="row bicicleteros">
								<a class="col-xs-6 cuadro txt">
									<i>Bicicleteros</i>
								</a>
								<div class="col-xs-6 cuadro no-padding bg">
									<!-- <img src="recursos/img/img-bicicleteros.jpg" class="img-responsive hidden-xs"> -->
								</div>
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
		'recursos/js/index.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/searchCtrl.js',
		'server/js/angularApp/controllers/productListHeaderCtrl.js',
		'server/js/angularApp/controllers/productListCtrl.js',
		'server/js/angularApp/controllers/productDetailCtrl.js',
		'server/js/angularApp/controllers/monthPromotionCtrl.js',
		'server/js/angularApp/controllers/modals/LoginSignUpCtrl.js'
	)
);

$pie = new html\Pie($opciones);

?>
