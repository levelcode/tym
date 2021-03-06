<div class="container-fluid" id="buscador" ng-controller="mainSearchCtrl">
	<form name="searchForm">
		<div class="row">
			<div class="col-xs-12 text-left">
				<h3 class="titulo">Elige tu vehículo </h3>
			</div>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo" id="p" class="form-control" ng-disabled="sendingData || loadingData" ng-model="selectedCar.vehicle" ng-options="vehicle as ( vehicle.brand | capitalize ) for (key, vehicle) in vehicles.data track by vehicle.id" ng-change="searchByBrand( selectedCar.vehicle )" required>
								<option selected disabled value="">{{defaultValueBrand}}</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo1" id="p1" class="form-control" ng-disabled="sendingselectedCar || loadingData" ng-model="selectedCar.model" ng-options="model as ( model.model | capitalize ) for (key, model) in models.data track by model.id" ng-change="loadYear( selectedCar.model )" required>
								<option selected disabled value="">{{defaultValueModel}}</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<select name="tipo1" id="p2" class="form-control" ng-disabled="sendingselectedCar" ng-model="selectedCar.year" ng-options="year for (key, year) in years.data" required>
								<option selected value="">{{defaultValueYear}}</option>
							</select>
							<!-- <button type="button" class="btn form-control bg-color3" ng-click="read( )">read</button> -->
						</div>
					</div>
				</div>
				<div class="row" ng-if="currentSearch != undefined">
					<div class="col-lg-12">
						<h4>Actual búsqueda:</h4>
					</div>
				</div>
				<div class="row" ng-if="currentSearch != undefined">
					<div class="col-lg-7">
						<strong>Marca:&nbsp;</strong>{{currentSearch.vehicle.brand}},&nbsp;<strong>Modelo:&nbsp;</strong>{{currentSearch.model.model}},&nbsp;<strong>Año:&nbsp;</strong>{{currentSearch.year}}
					</div>
					<div class="col-lg-5">
						<button type="button" class="btn form-control bg-color3" ng-click="resetSearch()" >Limpiar búsqueda</button>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<button type="button" id="boton-busqueda-vehiculo" class="btn form-control bg-color3" ng-click="searchProducts( selectedCar )"><span><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar</span></button>
			</div>
		</div>
	</form>
</div>
