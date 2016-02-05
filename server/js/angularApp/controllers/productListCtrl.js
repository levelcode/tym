tymApp.controller('productListCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){

	$scope.productsLoaded = false;
	$scope.rinProductsSelected = false;
	$scope.seatProductsSelected = false;
	$scope.lightProductsSelected = false;

	$scope.rinEmpty = true;
	$scope.tireEmpty = true;
	$scope.portaequipajesEmpty = true;
	$scope.barrastechoEmpty = true;
	$scope.bicicleterosEmpty = true;
	$scope.parrillastechoEmpty = true;
	$scope.accesorios4x4Empty = true;
	$scope.seatEmpty = true;
	$scope.lightEmpty = true;
	$scope.tankEmpty = true;

	/*
    listeners
	*/

	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;
	});



	$rootScope.$on( ConstantsService.CHANGE_PRODUCTS, function( event, data ) {
 		chooseProductsToShow( data );
	});



	$rootScope.$on( ConstantsService.PRODUCTS_CHARGED, function( event, data ){

		//$scope.rinProducts = data;

		$scope.productsLoaded = true;


 		angular.forEach( data, function( value, key ){

			switch ( key ) {

				case 'rin_products':
					$scope.rinProducts = value;
					if ( value.length == 0 || value == undefined ){
						$scope.rinEmpty = true;
					}else {
						$scope.rinEmpty = false;
					}
					break;

				case 'tire_products':
					$scope.tireProducts = value;
					if ( value.length == 0 || value == undefined  ){
						$scope.tireEmpty = true;
					}else {
						$scope.tireEmpty = false;
					}
					break;

				case 'portaequipajes_products':

					$scope.portaequipajesProducts = value;

					if ( !(value.length > 0) ){
						$scope.portaequipajesEmpty = true;
					}else {
						$scope.portaequipajesEmpty = false;
					}
					break;

				case 'light_hid_products':

					$scope.lightProducts = value;

					if ( !(value.length > 0) ){

						$scope.lightEmpty = true;

					}
					$scope.lightEmpty = false;

				case 'tank_products':

					$scope.tankProducts = value;

					if ( !(value.length > 0) ){

						$scope.tankEmpty = true;

					}
					$scope.tankEmpty = false;

					break;

				default:

			}

		});


		chooseProductsToShow( 'rin' );

	});



	function chooseProductsToShow( productTypeToShow ) {

		$scope.productsLoaded = true;

		switch ( productTypeToShow ) {

			case 'rin':
				$scope.rinProductsSelected = true;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bicicleterosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesorios4x4ProductsSelected = false;
				break;

			case 'tire':
				$scope.tireProductsSelected = true;
				$scope.seatProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bicicleterosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesorios4x4ProductsSelected = false;
				break;

			case 'portaequipajes':
				$scope.portaequipajesProductsSelected = true;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bicicleterosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesorios4x4ProductsSelected = false;
				break;

			case 'barrastecho':
				$scope.barrasTechoProductsSelected = true;
				$scope.lightProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.bicicleterosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesorios4x4ProductsSelected = false;
				break;

			case 'bicicleteros':
				$scope.bicicleterosProductsSelected = true;
				$scope.tankProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				break;
			case 'parrillastecho':
				$scope.parrillastechoProductsSelected = true;
				$scope.tankProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bicicleterosProductsSelected = false;
				$scope.accesorios4x4ProductsSelected = false;
				break;
			case 'accesorios4x4':
				$scope.accesorios4x4ProductsSelected = true;
				$scope.tankProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bicicleterosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				break;
			default:

				console.log('product type no programmed');

				break;

		}

	}



	function groupByRinType( data ) {

		var na = [];

			//na.rines = {};

		angular.forEach(data, function (value, key) {

       		na[value.diameter] = value;

  		});

		return na;

	}



	$scope.sendToProductDetail = function( product, productType ) {

		var data = { info: product, type: productType };

		$rootScope.$broadcast( ConstantsService.VIEW_DETAIL, data);

	}



}]);



tymApp.filter('capitalize', function() {

	return function(input, scope) {

	if (input!=null)

		input = input.toLowerCase();

		return input.substring(0,1).toUpperCase()+input.substring(1);

	}

});
