tymApp.controller('productListCtrl', ['$scope', '$rootScope', function( $scope, $rootScope ){

	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;
	});

	$rootScope.$on('rin_product_loaded', function( event, data ){
		$scope.rinProducts = groupByRinType(data);
	});

	$scope.test = "blabla";

	function groupByRinType( data ) {

		var na = [];
		angular.forEach(data, function (value, key) {

       		na[value.diameter].rines = value;
   		});

		return na;
	}


}]);

tymApp.filter('capitalize', function() {
	return function(input, scope) {
	if (input!=null)
		input = input.toLowerCase();
		return input.substring(0,1).toUpperCase()+input.substring(1);
	}
});
