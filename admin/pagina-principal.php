<?php
require_once('recursos/php/config.php');


$opciones = array(
	'responsivo' => true,
	'is_admin' => true,
	'descripcion' => 'TYM Accesorios es una empresa de ',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Admin contenido :: '._TITULO,
	'css' => array(
		'recursos/css/clientes.css'
	),
	'js' => array(
		'recursos/js/angular.min.js',
		'recursos/js/ui-bootstrap-tpls-0.13.4.min.js',
		'recursos/js/angular-cookies.min.js',
		'recursos/js/ng-file-upload/ng-file-upload.min.js'
	)
);

$cabecero = new html\Cabecero($opciones);

/* --- menu --- */

?>
<!-- contenido -->
<div id="contenido" ng-controller="adminMainPageCtrl">
	<ol class="breadcrumb">
		<li><a href="./admin">Inicio</a></li>
		<li class="active">Administrar contenido</li>
	</ol>
	<h3 class="st-titulo"><i class="fa fa-file-text"></i> &nbsp;Administrador página principal</h3>
	<div class="container">
	<!-- panel: clientes actuales -->
		<div class="panel" >
			<div class="panel-body">
				<div class="row">
					<!--<div class="col-sm-2 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('mainMenu')"><i class="fa fa-file-text"></i> &nbsp;Menú principal</a>
					</div>-->
					<div class="col-sm-2 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('homePromotion')"><i class="fa fa-file-text"></i> &nbsp;Promoción del mes</a>
					</div>
					<div class="col-sm-2 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('tePuedeInteresar')"><i class="fa fa-file-text"></i> &nbsp;Te puede interesar</a>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default" ng-if="homePromotion">
			<div class="panel-heading">
				<i class="fa fa-file-text"></i> &nbsp; Contenido sección "Promociónes del mes"
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<form id="monthPromo" name="monthPromo" novalidate>
					    	<br>
							<div class="col-sm-6 col-lg-6">
								<div class="form-group">
									<label for="promotionDetail">Promoción 1:</label>
									<input type="text" name="promotionOne" ng-model="promotions[0].detail" class="form-control" required>
								</div>
							</div>
							<div class="col-sm-6 col-lg-6">
								<div class="form-group">
									<label for="promotionDetail">Promoción 2:</label>
									<input type="text" name="promotionTwo" ng-model="promotions[1].detail" class="form-control" required>
								</div>
							</div>
							<div class="col-sm-6 col-lg-6">
								<div class="form-group">
									<label for="promotionDetail">Promoción 3:</label>
									<input type="text" name="promotioThree" ng-model="promotions[2].detail" class="form-control" required>
								</div>
							</div>
							<div class="col-xs-12 bloque text-right">
								<button class="btn btn-danger" ng-click="cancelAll()"><i class="fa fa-remove"></i> &nbsp;Cancelar</button>
								<button id="save_waste_info" class="btn btn-success" ng-click="updatePromotion( promotions )" ng-disabled="sendingRequest || monthPromo.$invalid"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Guardar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default" ng-if="universalProductsSection">
			<div class="panel-heading">
				<i class="fa fa-file-text"></i> &nbsp; Contenido sección "te puede interesar"
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<form id="monthPromo" name="monthPromo" novalidate>
					    	<br>
							<div class="col-sm-6 col-lg-6" ng-repeat="(groupName, group) in mayInterestYouItems">
								<div class="form-group">
									<label for="promotionDetail" ng-bind="groupName+':'"></label>
									<input type="text" ng-repeat="(key, item) in group" name="promotionOne{{item.category}}{{item.id}}" ng-model="item.detail" class="form-control" required>
								</div>
							</div>
							<div class="col-xs-12 bloque text-right">
								<button class="btn btn-danger" ng-click="cancelAll()"><i class="fa fa-remove"></i> &nbsp;Cancelar</button>
								<button id="save_waste_info" class="btn btn-success" ng-click="updatePromotion( promotions )" ng-disabled="sendingRequest || monthPromo.$invalid"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Guardar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/clock.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/notificationsCtrl.js',
		'server/js/angularApp/controllers/adminMainPageCtrl.js'
	)
);

$pie = new html\Pie($opciones);

?>
