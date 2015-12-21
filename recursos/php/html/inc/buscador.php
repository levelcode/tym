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
							<select name="tipo" id="p" class="form-control" ng-disabled="sendingData" ng-model="selectedCar.vehicle" ng-options="vehicle.brand for (key, vehicle) in vehicles.data track by vehicle.id" ng-change="searchByBrand( selectedCar.vehicle )" required>
								<option disabled selected value=""value="">Seleccione Marca</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingselectedCar" ng-model="selectedCar.model" ng-options="model.model for (key, model) in models.data track by model.id" ng-change="loadYear( selectedCar.model )" required>
								<option disabled selected value="">Selecciona Modelo</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingselectedCar" ng-model="selectedCar.year" ng-options="year for (key, year) in years.data" required>
								<option disabled selected value="">Selecciona Año</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<button type="button" class="btn form-control bg-color3" ng-click="searchProducts( selectedCar )" style="    background-image: url(recursos/img/boton-busqueda.png);
    width: 193px;
    height: 192px;
    position: absolute;
    border: 0px solid transparent;
    background-color: transparent !important;
    margin-top: -93px;
    box-shadow: none;
    text-shadow: none;"> </button>
			</div>
		</div>
	</form>
</div>
