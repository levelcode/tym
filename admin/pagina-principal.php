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
					<div class="col-sm-2 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('mainMenu')"><i class="fa fa-file-text"></i> &nbsp;Menú principal</a>
					</div>
					<div class="col-sm-2 st-bloque">
						<a class="btn btn-success" ng-click="switchPanelSection('universalSection')"><i class="fa fa-file-text"></i> &nbsp;Sección de "Te puede interesar"</a>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default" ng-if="mainMenuSection">
			<div class="panel-heading">
				<i class="fa fa-file-text"></i> &nbsp; Contenido menú principal
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<accordion close-others="oneAtATime">
							<accordion-group  panel-class="panel-info">
								<accordion-heading>
						       	 Añadir
						      	</accordion-heading>
								<form id="AddProductForm" name="AddProductForm" novalidate>
							    	<br>
									<div class="col-sm-6 col-lg-6">
										<div class="form-group">
											<label for="itemName">Nombre del nuevo item</label>
											<input type="text" name="itemName" ng-disabled="loadingData" ng-model="request.itemName" id="productName" class="form-control" required>
										</div>
									</div>
									<hr>				
									<div class="col-xs-12 bloque text-right">
										<button id="save_new_menu_item" class="btn btn-success" ng-click="saveNewItem(request)" ng-disabled="sendingRequest"><i class="fa fa-save" ng-if="!sendingRequest"></i><i class="fa fa-circle-o-notch fa-spin" ng-if="sendingRequest"></i> &nbsp;Añadir</button>
									</div>
								</form>
							</accordion-group>
							<accordion-group  panel-class="panel-info">
								<accordion-heading>
						       	 Ordenar
						      	</accordion-heading>
					      	</accordion-group>
						</accordion>
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
