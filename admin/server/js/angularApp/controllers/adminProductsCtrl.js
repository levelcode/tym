adminTymApp.controller('adminProductsCtrl', ['$scope', '$http', '$timeout', '$cookies', '$window', '$cookies', 'ConstantsService', 'HttpMethodsService', function( $scope, $http, $timeout, $cookies, $window, $cookies, ConstantsService, HttpMethodsService ){

	$scope.loadingData = false;
	$scope.productTypeSelected = false;

	//accordion config
	$scope.oneAtATime = true;
	$scope.status = {
		isFirstOpen: true,
		isFirstDisabled: false
	};

	//panel control status
	$scope.addproductSection = false;
	$scope.searchAndEditSection = false;

	//data arrays
	$scope.producTypes = {};
	$scope.vehicles = {};
	$scope.models = {};	
	$scope.years = {};

	angular.element(document).ready(function(){
		loadData();
	});

	function loadData() {
		$scope.loadingData = true;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'admin-products';
			post.action = "get_base_data";

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case ConstantsService.responseStatus.LOADED:
		            	var jsonObject = angular.fromJson(data);
			            updatetDataToShow( jsonObject['product_types'], "product_types" );
			            updatetDataToShow( jsonObject['vehicles'], "vehicles" );
			            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	$scope.showForm = function( selectedTypeofProduct ){
		$scope.productTypeSelected = true;
		console.log(selectedTypeofProduct);
	}

	$scope.searchByBrand = function( selectedVehicleBrand ) {
		console.log( selectedVehicleBrand );
		$scope.loadingData = true;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'admin-products';
			post.action = "get_models_by_brand";
			post.brandId = selectedVehicleBrand.id;

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case ConstantsService.responseStatus.LOADED:
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

	$scope.switchPanelSection = function( sectionToSelect ) {

		switch( sectionToSelect ) {
			case 'add':
				$scope.productTypeSelected = false;

				$scope.addproductSection = true;
				$scope.searchAndEditSection = false;
			break;
			case 'searchAndEdit':
				$scope.productTypeSelected = false;

				$scope.addproductSection = false;
				$scope.searchAndEditSection = true;
			break;

		}

	}

	function updatetDataToShow( newData, type ) {

		var na = doArray( newData, true );

        if ( na.length > 0 ){

        	switch( type ) {
        		case 'product_types':
        			$scope.producTypes.data = na;
        			$scope.producTypes.empty = false;		
        			break;
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
	    		case 'product_types':
	    			$scope.producTypes.empty = true;	
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


}]);