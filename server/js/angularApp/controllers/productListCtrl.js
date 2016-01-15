tymApp.controller('productListCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){

	$scope.productsLoaded = false;
	$scope.rinProductsSelected = false;


	$scope.rinesEmpty = false;
	$scope.tiresEmpty = false;
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
						$scope.rinesEmpty = true;
					}
					break;
				case 'tire_products':
					$scope.tireProducts = value;
					if ( !(value.length > 0) ){
						$scope.tiresEmpty = true;
					}
					break;
				default:
			}
		});

		chooseProductsToShow( 'rin' );
	});

	function chooseProductsToShow( productTypeToShow ) {
		switch ( productTypeToShow ) {
			case 'rin':
				$scope.rinProductsSelected = true;
				$scope.tireProductsSelected = false;
				break;
			case 'tire':
				$scope.tireProductsSelected = true;
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
