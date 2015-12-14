adminTymApp.controller('adminMainPageCtrl', ['$scope', '$http', '$timeout', '$cookies', '$window', '$cookies', function( $scope, $http, $timeout, $cookies, $window, $cookies ){

	$scope.loadingData = false;
	$scope.sectionSelected = false;
	$scope.sendingRequest = false;

	//accordion config
	$scope.oneAtATime = true;
	$scope.status = {
		isFirstOpen: true,
		isFirstDisabled: false
	};

	//panel control status
	$scope.homePromotion = false;
	$scope.universalProductsSection = false;

	//data arrays
	$scope.menuItems = {};	

	angular.element(document).ready(function(){
		loadData();
	});

	function loadData() {
		$scope.loadingData = true;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'admin-main-page';
			post.action = "get_base_data";

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'LOADED':
		            	var jsonObject = angular.fromJson(data);
			            updatetDataToShow( jsonObject['menu_items'], "menu_items" );
			            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	$scope.switchPanelSection = function( sectionToSelect ) {

		switch( sectionToSelect ) {
			case 'homePromotion':
				$scope.sectionSelected = false;

				$scope.homePromotion = true;
				$scope.universalProductsSection = false;
			break;
			case 'universalSection':
				$scope.sectionSelected = false;

				$scope.homePromotion = false;
				$scope.universalProductsSection = true;
			break;

		}

	}

	$scope.saveNewItem = function( data ){
		$scope.loadingData = true;

		st.ventanaInfo.abrir("Guardando", "success", 4000);

		var post = 	{};
			post.a = 'save_item';
			post.from = 'admin-main-page';
			post.action = "save_main_menu_item";
			post.data = {itemName : data.itemName};

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'SUCCESS':
		            	var jsonObject = angular.fromJson(data);
			            updatetDataToShow( jsonObject['menu_items'], "menu_items" );
			            st.ventanaInfo.abrir("Guandado con éxito", "success", 2000);
		            break;
		            case 'ERROR':
		            	st.ventanaInfo.abrir("Intentalo de nuevo", "error", 2000);
		            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });

	}

	function updatetDataToShow( newData, type ) {

		var na = doArray( newData, true );

        if ( na.length > 0 ){

        	switch( type ) {
        		case 'menu_items':
        			$scope.menuItems.data = na;
        			$scope.menuItems.empty = false;		
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
	    		case 'menu_items':
	    			$scope.menuItems.empty = true;	
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