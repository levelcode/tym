tymApp.controller('productDetailCtrl', ['$scope', '$rootScope', function( $scope, $rootScope ){
	
	$scope.test = "yujuuu!";
	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;	
	});
}]);