adminTymApp.controller('adminProductsCtrl', ['$scope', '$http', '$timeout', '$cookies', '$window', '$cookies', function( $scope, $http, $timeout, $cookies, $window, $cookies ){

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
                	case 'LOADED':
		            	var jsonObject = angular.fromJson(data);
			            updatetDataToShow( jsonObject['product_types'], "product_types" );
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