tymApp.controller( 'searchCtrl', [ '$scope', '$http', '$rootScope', 'ConstantsService', '$cookies', '$window', function( $scope, $http, $rootScope, ConstantsService, $cookies, $window ){

	$scope.vehicles = {};
	$scope.models = {};
	$scope.years = {};
	$scope.rinTypes = {};
	$scope.rinProducts = {};
	$scope.tires = {};
	$scope.loadingData = false;
	$scope.showOptions = false;
	$scope.defaultValueBrand = "Seleccione Marca";
	$scope.defaultValueModel = "Selecciona Modelo";
	$scope.defaultValueYear = "Selecciona Año";

	var todayFull = new Date();
	var todayDay = todayFull.getDate();
	todayFull.setDate( todayDay + 1 );
	var cookiesOptions = { path: "/" , expires: todayFull };
	/*
	*cookies config
	*/

	angular.element(document).ready(function(){
		$scope.loadingData = true;
		autoSearch();
	});

	function autoSearch(){
		$scope.currentSearch = $cookies.getObject('TYMSEARCH');
		if( $scope.currentSearch != undefined ){
			console.log($scope.currentSearch);
			$scope.searchProducts($scope.currentSearch);
			st.menuAccesorios.abrir();
		}
	}

	$rootScope.$on(ConstantsService.RE_SEARCH, function(event, data){
		console.log('cheking-if-searching');
		switch (data.status) {
			case 'JUST_SEARCH':
				$scope.searchProducts(data.info);
				break;
			case 'RE_SEARCH':
				autoSearch();
				break;
		}
	});

	$scope.searchProducts = function( request ) {

		$rootScope.$broadcast('vehicle_chaged', request);
		$scope.request = request;
		//$scope.showOptions = true;
		console.log(request);

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'home';
			post.action = "get_products";
			post.vehicleId = request.vehicle.id;
			post.modelName = request.model.model;
			post.year = request.year;

        $http.post("/admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'PRODUCTS_LOADED':
						saveSearchData('TYMSEARCH', request, cookiesOptions);
		            	var jsonObject = angular.fromJson(data);
						$rootScope.$broadcast( ConstantsService.PRODUCTS_CHARGED, jsonObject);
			            updatetDataToShow( jsonObject['rin_types'], "rin_types" );
			            updatetDataToShow( jsonObject['tires'], "tires" );
			            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	function saveSearchData( name, searchData, options ) {
		$cookies.putObject( name, searchData, options );
	}

	function doArray( data, preserveKey ) {

		var i = 0,
		na = [];

       	angular.forEach(data, function (value, key) {

       		if ( preserveKey )
       			na[key] = value;
       		else {
	       		na[i] = value;
	       		i++;
       		}
   		});

       	return na;

	}

	function updatetDataToShow( newData, type ) {

		var na = doArray( newData, true );

        if ( na.length > 0 ){

        	switch( type ) {
        		case 'vehicles':
        			$scope.vehicles.data = na;
        			$scope.vehicles.empty = false;
        			break;
    			case 'models':
    					$scope.models.data = na;
        				$scope.models.empty = false;
					break;
				case 'years':
    					$scope.years.data = na;
        				$scope.years.empty = false;
					break;
				case 'rin_types':
    					$scope.rinTypes.data = na;
        				$scope.rinTypes.empty = false;
					break;
				case 'tires':
    					$scope.tires.data = na;
        				$scope.tires.empty = false;
					break;
        	}

        }else {
        	switch( type ) {
	    		case 'vehicles':
	    			$scope.vehicles.empty = true;
	    			break;
    			case 'models':
	    			$scope.models.empty = true;
	    			break;
    			case 'years':
	    			$scope.years.empty = true;
	    			break;
    			case 'rin_types':
	    			$scope.rinTypes.empty = true;
	    			break;
    			case 'tires':
	    			$scope.tires.empty = true;
	    			break;
			}
        }

	}

}]);
