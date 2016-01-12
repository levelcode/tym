tymApp.controller('productListCtrl', ['$scope', '$rootScope', function( $scope, $rootScope ){

	$scope.rinesLoaded = false;
	$scope.rinesEmpty = false;
	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;
	});

	$rootScope.$on('rin_product_loaded', function( event, data ){
		$scope.rinProducts = data;
		$scope.rinesLoaded = true;

		if ( !(data.length > 0) )
			$scope.rinesEmpty = true;

	});

	$scope.test = "blabla";


	function groupByRinType( data ) {

		var na = [];
			//na.rines = {};
		angular.forEach(data, function (value, key) {

       		na[value.diameter] = value;
   		});

		return na;
	}

	$scope.sendToProductDetail = function( product ) {
		$rootScope.$broadcast('view_detail', product);
	}

}]);

tymApp.filter('capitalize', function() {
	return function(input, scope) {
	if (input!=null)
		input = input.toLowerCase();
		return input.substring(0,1).toUpperCase()+input.substring(1);
	}
});
