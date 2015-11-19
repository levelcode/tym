<?php
require_once('recursos/php/config.php');

/*echo '<pre>';
print_r($_SESSION);
echo '</pre>';*/


$opciones = array(
	'responsivo' => true,
	'is_admin' => true,
	'descripcion' => 'TYM Accesorios es una empresa de ',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Turismo al vuelo',
	'css' => array(
		'recursos/css/admin/inicio.css', 
		'recursos/css/admin/clientes.css'),
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
		<div id="contenido-admin" ng-controller="startCtrl">
			<ol class="breadcrumb">
				<li class="active">Inicio</li>
			</ol>
			<h3 class="st-titulo-admin"><i class="fa fa-home"></i> &nbsp;Inicio administrador de contenido</h3>
			<div class="container">
				<div class="panel">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
								<b>Bienvenido:</b> <?= strtoupper($_SESSION["first_names"])?><?= ( isset($_SESSION["last_names"]) ) ? ' '. strtoupper($_SESSION["last_names"]) : '';?>
							</div>
							<div class="col-sm-4">
								<b>Ultimo ingreso:</b> <?= (isset($_SESSION["last_login"])) ? $_SESSION["last_login"] : "Primera vez"; ?>
							</div>
							<div class="col-sm-4">
								<b>Fecha Hora Actual:</b> <span id="clock"></span>
							</div>
						</div>
						<input type="hidden" id="id_cliente_for_jq" name="id_cliente_for_jq" value="<?= $_SESSION['id']?>">
						<input type="hidden" id="user_type_id_for_jq" name="user_type_id_for_jq" value="<?= $_SESSION['user_type_id']?>">
						<input type="hidden" id="id_cliente" name="id_cliente" ng-model="userId" ng-init="userId=<?= $_SESSION['id']?>" value="1">
						<input type="hidden" id="user_type_id" name="user_type_id" ng-model="userTypeId" ng-init="userTypeId=<?= $_SESSION['user_type_id']?>">
					</div>
				</div>

				<div class="row">
					<div class="col-sm-7">
						
					</div>
					<div class="col-sm-5">

					</div>
				</div>

				
			</div>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'https://www.google.com/jsapi',
		'recursos/js/admin/inicio.js', 
		'recursos/js/admin/clock.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/startCtrl.js'
		//'server/js/angularApp/controllers/notificationsCtrl.js'
	),
	'pie' => 'admin/pie-general',
	'user' => 'admin'
);

$pie = new html\Pie($opciones);

?>
