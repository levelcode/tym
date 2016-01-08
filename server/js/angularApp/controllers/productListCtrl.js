tymApp.controller('productListCtrl', ['$scope', '$rootScope', function( $scope, $rootScope ){
	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;	
	});
}]);

tymApp.filter('capitalize', function() {
	return function(input, scope) {
	if (input!=null)
		input = input.toLowerCase();
		return input.substring(0,1).toUpperCase()+input.substring(1);
	}
});