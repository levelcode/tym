tymApp.controller( 'searchCtrl', [ '$scope', '$http', '$rootScope', function( $scope, $http, $rootScope ){

	'use strict';

	$scope.vehicles = {};
	$scope.models = {};
	$scope.years = {};
	$scope.rinTypes = {};
	$scope.tires = {};
	
	$scope.loadingData = false;
	$scope.showOptions = false;

	angular.element(document).ready(function(){
		$scope.loadingData = true;

		loadHomeData();
	});
	
	$scope.searchByBrand = function( selectedVehicleBrand ) {
		console.log( selectedVehicleBrand );
		$scope.loadingData = true;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'home';
			post.action = "get_models_by_brand";
			post.brandId = selectedVehicleBrand.id;

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'VEHICLE_MODELS_LOADED':
		            	var jsonObject = angular.fromJson(data);
			            updatetDataToShow( jsonObject['models'], "models" );
			            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	$scope.loadYear = function( modelSelected ) {
		console.log(modelSelected);

		var years = [];

		if( modelSelected.year.search( "-" ) != -1 ) {
			var yearsArray = modelSelected.year.split("-");	

			var yearsDifference = yearsArray[1] - yearsArray[0];

			for (var i = 0; i <= yearsDifference; i++) {
				if( i==0 )
					years[i] = parseInt(yearsArray[0]);
				else
					years[i] = parseInt(yearsArray[0]) + i;
			};
		}else {
			years[0] = modelSelected.year;
		}
		
		console.log(years);
		updatetDataToShow( years, "years" );

	}

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
			post.modelId = request.model.id;

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'PRODUCTS_LOADED':
		            	var jsonObject = angular.fromJson(data);
			            updatetDataToShow( jsonObject['rin_types'], "rin_types" );
			            updatetDataToShow( jsonObject['tires'], "tires" );
			            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	function loadHomeData() {

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'home';
			post.action = 'load_vehicles';

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'VEHICLES_LOADED':

                		var jsonObject = angular.fromJson(data);
	                	updatetDataToShow( jsonObject['vehicles'], "vehicles" );

                		break;
                }


            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
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