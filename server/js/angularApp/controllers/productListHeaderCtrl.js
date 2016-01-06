tymApp.controller('productListHeader', [ '$scope', '$rootScope', function( $scope, $rootScope ){

	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;	
	});

	
}]);