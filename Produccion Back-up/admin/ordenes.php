<?php
require_once('recursos/php/config.php');


$opciones = array(
	'responsivo' => true,
	'is_admin' => true,
	'descripcion' => 'TYM Accesorios es una empresa de ',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Admin contenido :: '._TITULO,
	'css' => array(
		'recursos/css/admin/clientes.css'
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
<div id="contenido" ng-controller="">
<ol class="breadcrumb">
	<li><a href="./admin">Inicio</a></li>
	<li class="active">Administrar contenido</li>
</ol>
<h3 class="st-titulo-admin"><i class="fa fa-file-text"></i> &nbsp;Resumen de ordenes</h3>
	<div class="container">

		<div class="row">
			<div class="col-xs-12">

				<div class="alert alert-info" ng-if="loadingRequests || collectRequests.empty">
						<span ng-if="loadingRequests"><strong>Cargando &nbsp;<i class="fa fa-circle-o-notch fa-spin"></i></strong></span>
						<strong ng-if="collectRequests.empty">No existen solicitudes de recolección confirmadas</strong>
				</div>
				<div class="table-responsive" ng-if="!loadingRequests && !collectRequests.empty">
					<table class="table" id="myTable">
						<thead>
							<tr>
								<th colspan="12" class="text-center">Ordenes existentes</th>
							</tr>
							<tr>
								<th>N<sup>o</sup> de orden</th>
								<th>productos</th>
								<th>N<sup>o</sup> referencia</th>
								<th>Direccion</th>
								<th>Notas</th>
								<th>Valor</th>
								<th>estado</th>
							</tr>
						</thead>
						<tbody>									
							<tr ng-if="results.length == 0">
								<td colspan="7">
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
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/admin/clock.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/collectRequestCtrl.js',
		'server/js/angularApp/controllers/notificationsCtrl.js'
	),
	'pie' => 'admin/pie-general',
	'user' => 'admin'
);

$pie = new html\Pie($opciones);

?>
