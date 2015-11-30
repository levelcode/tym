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
		'recursos/js/angular-cookies.min.js'
	)
);

$cabecero = new html\Cabecero($opciones);

/* --- menu --- */

?>
<!-- contenido -->
<div id="contenido" ng-controller="adminProductsCtrl">
	<ol class="breadcrumb">
		<li><a href="./admin">Inicio</a></li>
		<li class="active">Administrar contenido</li>
	</ol>
	<h3 class="st-titulo"><i class="fa fa-file-text"></i> &nbsp;Administrador de productos</h3>
	<div class="container">
	<!-- panel: clientes actuales -->
		<div class="panel" >
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-4 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('add')"><i class="fa fa-file-text"></i> &nbsp;Agregar</a>
					</div>
					<div class="col-sm-4 st-bloque">
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
							<select name="productType" id="productType" class="form-control" ng-disabled="loadingData" ng-model="request.productType" ng-options="productType.type for (key, productType) in producTypes.data track by productType.id" required>
								<option disabled selected value="">-- Selecciona una opción --</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
				</div>
			</div>
		</div>
		<div class="panel panel-default" ng-if="searchAndEditSection">
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
		'server/js/angularApp/controllers/adminProductsCtrl.js'
	)
);

$pie = new html\Pie($opciones);

?>
