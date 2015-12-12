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
<div id="contenido" ng-controller="adminProductsCtrl">
	<ol class="breadcrumb">
		<li><a href="./inicio">Inicio</a></li>
		<li class="active">Administrar contenido</li>
	</ol>
	<h3 class="st-titulo"><i class="fa fa-file-text"></i> &nbsp;Administrador de productos</h3>
	<div class="container">
	<!-- panel: clientes actuales -->
		<div class="panel" >
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-2 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('add')"><i class="fa fa-file-text"></i> &nbsp;Agregar</a>
					</div>
					<div class="col-sm-2 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('searchAndEdit')"><i class="fa fa-file-text"></i> &nbsp;Buscar y editar</a>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default" ng-if="addproductSection">
			<div class="panel-heading">
				<i class="fa fa-file-text"></i> &nbsp; Añadir productos
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-4 st-bloque">
						<div class="form-group">
							<label for="productType">Tipo de producto a añadir</label>
							<select name="productType" id="productType" class="form-control" ng-change="showForm( request.productType )" ng-disabled="loadingData" ng-model="request.productType" ng-options="productType.type for (key, productType) in producTypes.data track by productType.id" required>
								<option disabled selected value="">-- Selecciona una opción --</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row" ng-if="productTypeSelected">
					<h3 class="st-titulo" ng-bind="formTittle"></h3>
					<div class="col-xs-12">
						<accordion close-others="oneAtATime">
							<accordion-group  panel-class="panel-info">
								<accordion-heading>
						       	 Individual
						      	</accordion-heading>
								<form id="AddProductForm" name="AddProductForm" novalidate>
							    	<br>
							    	<div class="col-sm-6 col-lg-6">
							    		<div class="form-group">
											<label for="productimage">Imagen</label>
											<br>
											<img ng-show="AddProductForm.file.$valid" ngf-thumbnail="request.picFile" class="thumb"> 
											<input type="file" name="productimage" ngf-select ng-model="request.picFile" class="form-control" ng-change="viewSize(request.picFile)" ngf-resize="{width: 250, height: 250, centerCrop: true}" name="file" accept="image/*" ngf-min-height="250" ngf-max-size="2MB" required>
											<span class="help-text">Las dimensiones de la imagen deben de ser 250px x 250px</span>
										</div>
							    	</div>
									<div class="col-sm-6 col-lg-6">
										<div class="form-group">
											<label for="productName">Nombre del producto</label>
											<input type="text" name="productName" ng-disabled="loadingData" ng-model="request.productName" id="productName" class="form-control" required>
										</div>
									</div>
									<div class="col-sm-6 col-lg-6">
										<div class="form-group">
											<label for="productReference">Referencia</label>
											<input type="text" name="productReference" ng-disabled="loadingData" ng-model="request.productReference" id="productReference" class="form-control" required>
										</div>
									</div>
									<div class="col-sm-6 col-lg-6">
										<div class="form-group">
											<label for="productDescription">Descripción</label>
											<textarea class="form-control" name="productDescription" id="productDescription" ng-model="request.productDescription" ng-disabled="loadingData" rows="3" required></textarea>
										</div>
									</div>
									<div class="col-sm-6 col-lg-6">
										<div class="form-group">
											<label for="productStock">Cantidad en inventario</label>
											<input type="number" name="productStock" ng-disabled="loadingData" ng-model="request.productStock" id="productStock" class="form-control" required>
										</div>
									</div>
									<div class="col-sm-6 col-lg-6">
										<div class="form-group">
											<label for="productPrice">Precio unidad</label>
											<input type="text" name="productPrice" ng-disabled="loadingData" ng-model="request.productPrice" id="productPrice" class="form-control" required>
										</div>
									</div>
									<hr>
									<h3>Datos del vehiculo:</h3>
									<div class="col-sm-4 col-lg-4">
										<div class="form-group">
											<label for="tipo">Marca</label>
											<select name="tipo" id="p" class="form-control" ng-disabled="sendingData" ng-model="request.vehicle" ng-options="vehicle.brand for (key, vehicle) in vehicles.data track by vehicle.id" ng-change="searchByBrand( request.vehicle )" required>
												<option disabled selected value="">-- Selecciona una opción --</option>
											</select>
										</div>
									</div>
									<div class="col-sm-4 col-lg-4">
										<div class="form-group">
											<label for="tipo1">Modelo</label>
											<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingRequest" ng-model="request.model" ng-options="model.model for (key, model) in models.data track by model.id" ng-change="loadYear( request.model )" required>
												<option disabled selected value="">-- Opción --</option>
											</select>
										</div>
									</div>
									<div class="col-sm-4 col-lg-4">
										<div class="form-group">
											<label for="tipo1">Año</label>
											<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingRequest" ng-model="request.year" ng-options="year for (key, year) in years.data" ng-change="searchProducts( request )" required>
												<option disabled selected value="">-- Opción --</option>
											</select>
										</div>
									</div>																																																
									<hr>				
									<div class="col-xs-12 bloque text-right">
										<button class="btn btn-danger" ng-click="cancelAll()"><i class="fa fa-remove"></i> &nbsp;Cancelar</button>
										<button id="save_waste_info" class="btn btn-success" ng-click="addProduct( request )" ng-disabled="sendingRequest || AddProductForm.$invalid"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Guardar</button>
									</div>
								</form>
							</accordion-group>
							<accordion-group  panel-class="panel-info">
								<accordion-heading>
						       	 Multiples productos
						      	</accordion-heading>
						      	<form name="addMultiplesProducts">
						      		<div class="form-group">
										<label for="fileOfProducts">Subir archivo</label>
										<input type="file" id="fileOfProducts">
										<p class="help-block">El archivo no debe exceder los 20MB.</p>
									</div>
									<div class="col-sm-2 st-bloque">
										<a class="btn btn-success"><i class="fa fa-file-text"></i> &nbsp;Importar</a>
									</div>
						      	</form>
					      	</accordion-group>
						</accordion>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default" ng-if="searchAndEditSection">
			<div class="panel-heading">
				<i class="fa fa-file-text"></i> &nbsp; Busqueda y edición
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="alert alert-info" ng-if="loadingRequests || collectRequests.empty">
  							<span ng-if="loadingRequests"><strong>Cargando &nbsp;<i class="fa fa-circle-o-notch fa-spin"></i></strong></span>
  							<strong ng-if="collectRequests.empty">No existen solicitudes de recolección confirmadas</strong>
						</div>
						<div class="table-responsive" ng-if="!loadingRequests && !collectRequests.empty">
							<table class="table" id="myTable">
								<thead>
									<tr>
										<th colspan="12" class="text-center">Productos existentes</th>
									</tr>
									<tr>
										<th>NIT</th>
										<th>Cliente</th>
										<th>Fecha de recolección</th>
										<th>N<sup>o</sup> recolección</th>
										<th>Residuo</th>
										<th>Cantidad Recolectada</th>
										<th>Cantidad Verificada</th>
										<th>Embalaje</th>
										<th>Vehículo(Placa)</th>
										<th>Vehículo(Peso neto)</th>
										<th>Grados API</th>
										<th>%Sedimientos</th>
										<th>%Humedad</th>
									</tr>
								</thead>
								<tbody>									
									<tr ng-if="results.length == 0">
										<td colspan="12">
											<div class="alert alert-warning">
				  								<strong >La busqueda no genera resultados</strong>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
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
		//mainApp
		'server/js/angularApp/angularApp.js',
		//Services
		'server/js/angularApp/services/ConstantsService.js',
		'server/js/angularApp/services/HttpMethodsService.js',
		//Controllers
		'server/js/angularApp/controllers/notificationsCtrl.js',
		'server/js/angularApp/controllers/adminProductsCtrl.js'
	)
);

$pie = new html\Pie($opciones);

?>
