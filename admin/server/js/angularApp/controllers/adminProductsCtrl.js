adminTymApp.controller('adminProductsCtrl', ['$scope', '$http', '$timeout', '$cookies', '$window', '$cookies', function( $scope, $http, $timeout, $cookies, $window, $cookies ){

	//panel control status
	$scope.addproductSection = false;
	$scope.searchAndEditSection = false;	

	angular.element(document).ready(function(){
		

		
	});

	$scope.switchPanelSection = function( sectionToSelect ) {

		switch( sectionToSelect ) {
			case 'add':
				$scope.addproductSection = true;
				$scope.searchAndEditSection = false;
			break;
			case 'searchAndEdit':
				$scope.addproductSection = false;
				$scope.searchAndEditSection = true;
			break;

		}

	}


}]);