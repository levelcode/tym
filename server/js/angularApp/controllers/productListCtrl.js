tymApp.controller('productListCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){

	$scope.productsLoaded = false;
	$scope.rinProductsSelected = false;
	$scope.seatProductsSelected = false;
	$scope.lightProductsSelected = false;

	$scope.rinEmpty = true;
	$scope.tireEmpty = true;
	$scope.portaequipajesEmpty = true;
	$scope.bomperestribosEmpty = true;
	$scope.barrastechoEmpty = true;
	$scope.bicicleterosEmpty = true;
	$scope.parrillastechoEmpty = true;
	$scope.accesoriosEmpty = true;
	$scope.seatEmpty = true;
	$scope.lightEmpty = true;
	$scope.tankEmpty = true;

	$scope.parrillasTechoProductsEmpty = false;
	$scope.barrasTechoProductsEmpty = false;


	/*
    listeners
	*/

	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;
		$scope.rinProducts = null;
		$scope.tireProducts = null;
		$scope.bomperestribosProducts = null;
		$scope.portaequipajesProducts = null;
		$scope.parrillasTechoProducts = null;
		$scope.barrasTechoProducts = null;
		$scope.lightProducts = null;
		$scope.tankProducts = null;
		$scope.universalProducts = null;

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
					case 'bomberestribos_products':
						$scope.bomperestribosProducts = value;
						if ( !($scope.getNumOfObjects(value) > 0) ){
							$scope.bomperestribosEmpty = true;
						}else {
							$scope.bomperestribosEmpty = false;
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
				case 'parrilas_techo':

					$scope.parrillasTechoProducts = value;

					if ( !(value.length > 0) ){
						$scope.parrillasTechoProductsEmpty = true;
					}else {
						$scope.parrillasTechoProductsEmpty = false;
					}
					break;
					case 'barras_techo':

						$scope.barrasTechoProducts = value;

						if ( value == undefined ){
							$scope.barrasTechoProductsEmpty = true;
						}else {
							$scope.barrasTechoProductsEmpty = false;
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
					case 'accesorios':

						$scope.universalProducts = value;

						if ( !(value.length > 0) ){

							$scope.universalEmpty = true;

						}
						$scope.universalEmpty = false;

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
				$scope.bomperestribosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesoriosProductsSelected = false;
				break;

			case 'tire':
				$scope.tireProductsSelected = true;
				$scope.seatProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bomperestribosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesoriosProductsSelected = false;
				break;

			case 'bomberestribos':
				$scope.bomperestribosProductsSelected = true;
				$scope.tireProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				break;
			case 'portaequipajes':
				$scope.portaequipajesProductsSelected = true;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bomperestribosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesoriosProductsSelected = false;
				break;

			case 'barrastecho':
				$scope.barrasTechoProductsSelected = true;
				$scope.lightProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.bomperestribosProductsSelected = false;
				$scope.parrillastechoProductsSelected = false;
				$scope.accesoriosProductsSelected = false;
				break;

			case 'parrillastecho':
				$scope.parrillastechoProductsSelected = true;
				$scope.bomperestribosProductsSelected = false;
				$scope.tankProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.accesoriosProductsSelected = false;
				break;
			case 'accesorios':
				$scope.accesoriosProductsSelected = true;
				$scope.tankProductsSelected = false;
				$scope.lightProductsSelected = false;
				$scope.seatProductsSelected = false;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
				$scope.portaequipajesProductsSelected = false;
				$scope.barrasTechoProductsSelected = false;
				$scope.bomperestribosProductsSelected = false;
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

	$scope.getNumOfObjects = function( objectOfObjects ) {
		var length = 0;
    	for( var key in objectOfObjects ) {
        	if( objectOfObjects.hasOwnProperty(key) ) {
            	++length;
        	}
    	}
    	return length;
	}



}]);

tymApp.filter('spaceless',function() {
    return function(input) {
        if (input) {
            return input.replace(/\s+/g, '-');
        }
    }
});

tymApp.filter('capitalize', function() {

	return function(input, scope) {

	if (input!=null)

		input = input.toLowerCase();

		return input.substring(0,1).toUpperCase()+input.substring(1);

	}

});
