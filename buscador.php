<!DOCTYPE html>
<html lang="en" ng-app="tymApp">
<head>
	<meta charset="utf-8">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
	</script>
	<![endif]-->
	<title>Buscador</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="Cache-Control" content="max-age=2592000, public" />
	
	<!-- Angular js controllers start -->
	
	
	<script type="text/javascript" src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/recursos/js/angular.min.js'?>"></script>
	<script type="text/javascript" src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/recursos/js/ui-bootstrap-tpls-0.13.4.min.js'?>"></script>
	<script type="text/javascript" src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/recursos/js/angular-cookies.min.js'?>"></script>
	<script type="text/javascript" src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/recursos/js/ng-file-upload/ng-file-upload.min.js'?>"></script>
	<script type="text/javascript" src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/server/js/angularApp/angularApp.js'?>"></script>
	<script type="text/javascript" src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/server/js/angularApp/controllers/searchTest.js'?>"></script>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
	
<style type="text/css">
.bloque {
	margin: 25px 0 25px 0;
}
</style>
</head>

<body>
</body>
	<div class="container" ng-controller="searchTest">
		<div class="row">
			<div class="col-sm-3 col-lg-3">
				<div class="form-group">
					<label for="tipo">Marca</label>
					<select name="tipo" id="p" class="form-control" ng-disabled="sendingData" ng-model="request.vehicle" ng-options="vehicle.brand for (key, vehicle) in vehicles.data track by vehicle.id" ng-change="searchByBrand( request.vehicle )" required>
						<option disabled selected value="">-- Selecciona una opción --</option>
					</select>
				</div>
			</div>
			<div class="col-sm-2 col-lg-2">
				<div class="form-group">
					<label for="tipo1">Modelo</label>
					<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingRequest" ng-model="request.model" ng-options="model.model for (key, model) in models.data track by model.id" ng-change="loadYear( request.model )" required>
						<option disabled selected value="">-- Opción --</option>
					</select>
				</div>
			</div>
			<div class="col-sm-2 col-lg-2">
				<div class="form-group">
					<label for="tipo1">Año</label>
					<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingRequest" ng-model="request.year" ng-options="year for (key, year) in years.data" ng-change="searchProducts( request )" required>
						<option disabled selected value="">-- Opción --</option>
					</select>
				</div>
			</div>
			<div class="col-sm-5 col-lg-5 bloque" ng-if="showOptions">
				<button class="btn btn-default" type="submit">Button</button>
				<button class="btn btn-default" type="submit">Button</button>
				<button class="btn btn-default" type="submit">Button</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-lg-4">
				<div class="well well-sm">
					<h4>Diametro de Rin - Pulgadas</h4>
					<ul>
						<li ng-repeat="(key, type) in rinTypes.data" ng-bind="type.rin_diameter +' -- '+ type.inches"></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-4 col-lg-4">
				<div class="well well-sm">
					<h4>Llantas</h4>
					<ul>
						<li ng-repeat="(key, tire) in tires.data" ng-bind="tire.tire"></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-4 col-lg-4">
				<div class="well well-sm">
				<h4>Universales</h4>
				<ul>
					<li ng-repeat="(key, universal) in universals.data" ng-bind="universal.type"></li>
				</ul>
				</div>
			</div>
		</div>
	</div>

</html>