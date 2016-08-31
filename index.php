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
						<div class="col-md-12">
							<div class="st-titulo">
								<small>Nuestras</small>
								<h1>Promociones del mes</h1>
							</div>
						</div>
					</div>
					<div class="row" ng-controller="monthPromotionCtrl" ng-cloak id="month_promotions">
						<div class="col-sm-4 promociones st-seccion handy" ng-repeat="item in promotions" >
							<div class="row" >
								<div ng-click="sendToProductDetail(item.data, item.data.category_aux)">
									<div class="col-xs-12">
									</div>
									<div class="col-sm-6">
										<div class="st-titulo">
											<small ng-bind="item.data.brand"></small>
										</div>
										<i class="st-separador"></i>
										<p class="txt-15 ng-cloak" ng-bind-html="item.data.custom_message"></p>
									</div>
									<div class="col-sm-6">
										<br>
										<img ng-if="item.data.category_aux == 'kit completo' || item.data.category_aux == 'marco placa' || item.data.category_aux == 'rejilla frontal' || item.data.category_aux == 'cubierta stops traseros' || item.data.category_aux == 'exploradoras' || item.data.category_aux == 'barra de exploradoras' || item.data.category_aux == 'tanques' || item.data.category_aux == 'barra antivolco' || item.data.category_aux == 'plumillas' || item.data.category_aux == 'barra luces led' || item.data.category_aux == 'portabicicleta' || item.data.category_aux == 'portabicicleta de techo' || item.data.category_aux == 'filtro de aire' || item.data.category_aux == 'pijamas para vehiculos' || item.data.category_aux == 'pitos' || item.data.category_aux == 'reflejo logo' || item.data.category_aux == 'rines ciegos' || item.data.category_aux == 'tapete maletero'" ng-src="/admin/recursos/img/accesorios/{{item.data.category_aux}}-products/{{item.data.img}}.gif" alt="" class="img-responsive">
										<img ng-if="item.data.category_aux != 'kit completo' && item.data.category_aux != 'marco placa' && item.data.category_aux != 'rejilla frontal' && item.data.category_aux != 'cubierta stops traseros' && item.data.category_aux != 'exploradoras' && item.data.category_aux != 'barra de exploradoras' && item.data.category_aux != 'tanques' && item.data.category_aux != 'barra antivolco' && item.data.category_aux != 'plumillas' && item.data.category_aux != 'barra luces led' && item.data.category_aux != 'portabicicleta' && item.data.category_aux != 'portabicicleta de techo' && item.data.category_aux != 'filtro de aire' && item.data.category_aux != 'pijamas para vehiculos' && item.data.category_aux != 'pitos' && item.data.category_aux != 'reflejo logo' && item.data.category_aux != 'rines ciegos' && item.data.category_aux != 'tapete maletero'" ng-src="/admin/recursos/img/{{item.data.category_aux}}-products/{{item.data.img}}.gif" alt="" class="img-responsive">
									</div>
								</div>
							</div>
							<!-- <div class="row" ng-if="item.data.category_aux == 'tire'">
								<div ng-click="sendToProductDetail(item.data, 'tire')">
									<div class="col-xs-12">
									</div>
									<div class="col-sm-6">
										<div class="st-titulo">
											<small ng-bind="item.data.brand"></small>
										</div>
										<i class="st-separador"></i>
										<p class="txt-15 ng-cloak" ng-bind="item.data.custom_message"></p>
									</div>
									<div class="col-sm-6">
										<br>
										<img ng-src="/admin/recursos/img/{{item.data.category_aux}}-products/{{item.data.img}}.gif" alt="" class="img-responsive">
									</div>
								</div>
							</div> -->
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
						<div class="col-sm-3 st-seccion">
							<div class="row">
								<div class="col-lg-7">
									<a href="/videos"><div class="st-titulo">
											<h1>Galería</h1>
											<small>Vídeos/Eventos</small>
										</div></a>
									<i class="st-separador"></i>
								</div>
								<div class="col-lg-5">
									<a href="/videos">
										<img src="recursos/img/imac-videos.png" alt="" class="img-responsive">
									</a>
								</div>
							</div>
						</div>
						<div class="te-puede-interesar">
							<div class="col-sm-3">
								<div class="row tanques" style="background-color: #FFF;">
									<a data-producto-nombre="tapete-maletero" class="col-xs-6 cuadro txt">
										<i>Tapete maletero</i>
									</a>
									<div class="col-xs-6 cuadro no-padding bg">
										<!-- <img src="recursos/img/img-tanques.jpg" class="img-responsive hidden-xs"> -->
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="row racks">
									<a data-producto-nombre="pijamas-para-vehiculos" class="col-xs-6 cuadro txt">
										<i>Pijamas para vehículos</i>
									</a>
									<div class="col-xs-6 cuadro no-padding bg">
										<!-- <img src="recursos/img/img-racks.jpg" class="img-responsive hidden-xs"> -->
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="row bicicleteros" style="background-color: #FFF;">
									<a data-producto-nombre="plumillas" class="col-xs-6 cuadro txt">
										<i>Plumillas</i>
									</a>
									<div class="col-xs-6 cuadro no-padding bg">
										<!-- <img src="recursos/img/img-bicicleteros.jpg" class="img-responsive hidden-xs"> -->
									</div>
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
		'src/js/index.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/mainSearchCtrl.js',
		'server/js/angularApp/controllers/searchCtrl.js',
		'server/js/angularApp/controllers/productListHeaderCtrl.js',
		'server/js/angularApp/controllers/productListCtrl.js',
		'server/js/angularApp/controllers/productDetailCtrl.js',
		'server/js/angularApp/controllers/monthPromotionCtrl.js',
		'server/js/angularApp/controllers/shoppingCartAuxCtrl.js',
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
