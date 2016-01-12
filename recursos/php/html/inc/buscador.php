<div class="container-fluid" id="buscador" ng-controller="searchCtrl">
	<form name="searchForm">
		<div class="row">
			<div class="col-xs-12 text-left">
				<h3 class="titulo">Elige tu vehículo </h3>
			</div>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo" id="p" class="form-control" ng-disabled="sendingData" ng-model="selectedCar.vehicle" ng-options="vehicle as ( vehicle.brand | capitalize ) for (key, vehicle) in vehicles.data track by vehicle.id" ng-change="searchByBrand( selectedCar.vehicle )" required>
								<option selected value="">Seleccione Marca</option>
								<option value="modelo">Modelo</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingselectedCar" ng-model="selectedCar.model" ng-options="model as ( model.model | capitalize ) for (key, model) in models.data track by model.id" ng-change="loadYear( selectedCar.model )" required>
								<option selected value="">Selecciona Modelo</option>
								<option value="modelo">Modelo</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo1" id="p2" class="form-control" ng-disabled="sendingselectedCar" ng-model="selectedCar.year" ng-options="year for (key, year) in years.data" required>
								<option selected value="">Selecciona Año</option>
								<option value="modelo">Modelo</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<button type="button" id="boton-busqueda-vehiculo" class="btn form-control bg-color3" ng-click="searchProducts( selectedCar )"><span><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar</span></button>
			</div>
		</div>
	</form>
</div>
