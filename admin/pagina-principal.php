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
				<i class="fa fa-file-text"></i> &nbsp; Contenido sección "Promoción del mes"
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
				<i class="fa fa-file-text"></i> &nbsp; Contenido sección "te puede interesar"
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-4">
						<div class="well well-sm">
							<div class="row">
								<form id="mayInterestYouFormFirstSection" name="mayInterestYouFormFirstSection" novalidate>
							    	<br>
							    	<div class="col-sm-12 col-lg-12">
							    		<h3>Primera sección</h3>
							    		<div class="form-group">
											<label for="firstSectionImage">Imagen</label>
											<br>
											<img ng-show="mayInterestYouFormFirstSection.file.$valid" ngf-thumbnail="firstSection.picFile" class="thumb"> 
											<input type="file" name="firstSectionImage" ngf-select ng-model="firstSection.picFile" class="form-control" ng-change="" ngf-resize="{width: 190, height: 190, centerCrop: true}" accept="image/*" ngf-min-height="190" ngf-max-size="1MB" required>
											<span class="help-text">Las dimensiones de la imagen deben de ser 190px x 190px, y un peso de máximo 1MB</span>
											<!-- {{mayInterestYouFormFirstSection.firstSectionImage.$ngfValidations}} -->
										</div>
							    	</div>
									<div class="col-sm-12 col-lg-12">
										<div class="form-group">
											<label for="universalProducttype">Tipo de producto universal</label>
											<select class="form-control" id="universalProducttype" ng-disabled="loadingData" name="universalProducttype" ng-model="firstSection.universalProducttype" ng-options="productType.type for (key, productType) in universalProductsTypes.data track by productType.id" required>
												<option disabled value="">Seleccione una opción</option>
											</select>
										</div>
									</div>
									<div class="col-xs-12 bloque text-right">
										<button id="save_waste_info" class="btn btn-success" ng-click="updateInterestSection( firstSection, 'f' )" ng-disabled="sendingRequest || mayInterestYouFormFirstSection.$invalid"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Actualizar</button>
									</div>
								</form>
							</div>				
						</div>
					</div>
					<div class="col-sm-4">
						<div class="well well-sm">
							<div class="row">
								<form id="mayInterestYouFormSecondarySection" name="mayInterestYouFormSecondarySection" novalidate>
							    	<br>
							    	<div class="col-sm-12 col-lg-12">
							    		<h3>Segunda sección</h3>
							    		<div class="form-group">
											<label for="secondarySectionImage">Imagen</label>
											<br>
											<img ng-show="mayInterestYouFormSecondarySection.file.$valid" ngf-thumbnail="secondarySection.picFile" class="thumb"> 
											<input type="file" name="secondarySectionImage" ngf-select ng-model="secondarySection.picFile" class="form-control" ng-change="" ngf-resize="{width: 190, height: 190, centerCrop: true}" accept="image/*" ngf-min-height="190" ngf-max-size="1MB" required>
											<span class="help-text">Las dimensiones de la imagen deben de ser 190px x 190px, y un peso de máximo 1MB</span>
											<!-- {{mayInterestYouFormSecondarySection.secondarySectionImage.$ngfValidations}} -->
										</div>
							    	</div>
									<div class="col-sm-12 col-lg-12">
										<div class="form-group">
											<label for="universalProductType">Tipo de producto universal</label>
											<select class="form-control" id="universalProductType" ng-disabled="loadingData" name="universalProductType" ng-model="secondarySection.universalProducttype" ng-options="productType.type for (key, productType) in universalProductsTypes.data track by productType.id" required>
												<option disabled value="">Seleccione una opción</option>
											</select>
										</div>
									</div>
									<div class="col-xs-12 bloque text-right">
										<button id="save_waste_info" class="btn btn-success" ng-click="updateInterestSection( secondarySection )" ng-disabled="sendingRequest || mayInterestYouFormFirstSection.$invalid"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Actualizar</button>
									</div>
								</form>
							</div>							
						</div>
					</div>
					<div class="col-sm-4">
						<div class="well well-sm">
							<div class="row">
								<form id="mayInterestYouFormThirdSection" name="mayInterestYouFormThirdSection" novalidate>
							    	<br>
							    	<div class="col-sm-12 col-lg-12">
							    		<h3>Tercera sección</h3>
							    		<div class="form-group">
											<label for="secondarySectionImage">Imagen</label>
											<br>
											<img ng-show="mayInterestYouFormThirdSection.file.$valid" ngf-thumbnail="thirdSection.picFile" class="thumb"> 
											<input type="file" name="thirdSectionImage" ngf-select ng-model="thirdSection.picFile" class="form-control" ng-change="" ngf-resize="{width: 190, height: 190, centerCrop: true}" accept="image/*" ngf-min-height="190" ngf-max-size="1MB" required>
											<span class="help-text">Las dimensiones de la imagen deben de ser 190px x 190px, y un peso de máximo 1MB</span>
											<!-- {{mayInterestYouFormThirdSection.thirdSectionImage.$ngfValidations}} -->
										</div>
							    	</div>
									<div class="col-sm-12 col-lg-12">
										<div class="form-group">
											<label for="universalProductType">Tipo de producto universal</label>
											<select class="form-control" id="universalProductType" ng-disabled="loadingData" name="universalProductType" ng-model="thirdSection.universalProducttype" ng-options="productType.type for (key, productType) in universalProductsTypes.data track by productType.id" required>
												<option disabled value="">Seleccione una opción</option>
											</select>
										</div>
									</div>
									<div class="col-xs-12 bloque text-right">
										<button id="save_waste_info" class="btn btn-success" ng-click="updateInterestSection( thirdSection )" ng-disabled="sendingRequest || mayInterestYouFormFirstSection.$invalid"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Actualizar</button>
									</div>
								</form>
							</div>							
						</div>
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
