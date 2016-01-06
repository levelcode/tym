tymApp.controller('monthPromotionCtrl', ['$scope', '$http', '$sce', '$timeout', function( $scope, $http, $sce, $timeout ){

	$scope.loadingData = false;

	angular.element(document).ready(function(){
		loadPromotion();
	});

	function loadPromotion( ){
		$scope.loadingData = true;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'home';
			post.action = "get_main_page_promotion";

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                
                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'PROMOTION_LOADED':
		            	var jsonObject = angular.fromJson(data);
			            //updatetDataToShow( jsonObject['menu_items'], "menu_items" );
			            $scope.promotion = jsonObject['promotion'][0];
		            break;
		            case 'ERROR':
		            	$timeout(function() {$window.location.reload();} , 1000 );
		            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });

	}
	
}]);