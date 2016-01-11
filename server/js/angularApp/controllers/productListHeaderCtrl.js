tymApp.controller('productListHeader', [ '$scope', '$rootScope', function( $scope, $rootScope ){

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


}]);
