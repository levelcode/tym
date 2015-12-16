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
						<a class="btn btn-success" ng-click="switchPanelSection('universalSection')"><i class="fa fa-file-text"></i> &nbsp;Te puede interesar</a>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default" ng-if="homePromotion">
			<div class="panel-heading">
				<i class="fa fa-file-text"></i> &nbsp; Contenido Promoción del mes
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<form id="monthPromo" name="monthPromo" novalidate>
					    	<br>
					    	<div class="col-sm-6 col-lg-6">
					    		<div class="form-group">
									<label for="productimage">Imagen</label>
									<br>
									<img ng-show="monthPromo.file.$valid" ngf-thumbnail="promotion.picFile" class="thumb"> 
									<input type="file" name="productimage" ngf-select ng-model="promotion.picFile" class="form-control" ng-change="" ngf-resize="{width: 361, height: 182, centerCrop: true}" accept="image/*" ngf-min-height="182" ngf-max-size="1MB" required>
									<span class="help-text">Las dimensiones de la imagen deben de ser 361px x 182px, y un peso de máximo 1MB</span>
									<!-- {{monthPromo.productimage.$ngfValidations}} -->
								</div>
					    	</div>
							<div class="col-sm-6 col-lg-6">
								<div class="form-group">
									<label for="promotionDetail">Detalle</label>
									<textarea class="form-control" id="promotionDetail" ng-disabled="loadingData" name="promotionDetail" ng-model="promotion.promotionDetail" rows="3" required></textarea>			
								</div>
							</div>
							<div class="col-xs-12 bloque text-right">
								<button class="btn btn-danger" ng-click="cancelAll()"><i class="fa fa-remove"></i> &nbsp;Cancelar</button>
								<button id="save_waste_info" class="btn btn-success" ng-click="updatePromotion( promotion )" ng-disabled="sendingRequest || monthPromo.$invalid"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Guardar</button>
							</div>
						</form>				
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default" ng-if="universalProductsSection">
			<div class="panel-heading">
				<i class="fa fa-file-text"></i> &nbsp; Busqueda y edición
			</div>
			<div class="panel-body">
				<div class="row">

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
