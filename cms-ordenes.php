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
				<div class="alert alert-info">
						<strong ng-if="collectRequests.empty">En construcción</strong>
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
