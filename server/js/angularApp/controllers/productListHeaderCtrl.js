tymApp.controller('productListHeader', [ '$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){

	var vehicle = { brand : 'ninguno' };

	var model = { model : 'ninguno' };

	var year = 'ninguno';

	$scope.selectedCar = { vehicle, model, year};
	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;
	});

	$rootScope.$on('product_category_changed', function( event, data ){
		$scope.interestYouItems = data;
	});

	$scope.openProductType = function( productType ) {
        $rootScope.$broadcast( ConstantsService.CHANGE_PRODUCTS, productType );

    }



}]);
