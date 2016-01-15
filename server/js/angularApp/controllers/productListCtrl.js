tymApp.controller('productListCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){

	$scope.productsLoaded = false;
	$scope.rinProductsSelected = false;
	$scope.seatProductsSelected = false;

	$scope.rinEmpty = false;
	$scope.tireEmpty = false;
	$scope.seatEmpty = false;
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
					if ( !(value.length > 0) ){
						$scope.rinEmpty = true;
					}
					break;
				case 'tire_products':
					$scope.tireProducts = value;
					if ( !(value.length > 0) ){
						$scope.tireEmpty = true;
					}
					break;
				case 'seat_products':
					$scope.seatProducts = value;
					if ( !(value.length > 0) ){
						$scope.seatEmpty = true;
					}
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
				break;
			case 'tire':
				$scope.tireProductsSelected = true;
				$scope.seatProductsSelected = false;
				$scope.rinProductsSelected = false;
				break;
			case 'seat':
				$scope.seatProductsSelected = true;
				$scope.tireProductsSelected = false;
				$scope.rinProductsSelected = false;
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
