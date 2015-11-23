
carterApp.controller( 'collectorRecordsCtrl', ['$scope', '$http', '$window', '$timeout', function( $scope, $http, $window, $timeout ){

	'use strict';

	$scope.collectRequests = {};
	$scope.loadingRequests = false;

	angular.element(document).ready(function(){

		loadCollectRequests();

	});

	$scope.exportToXls = function() {

		st.ventanaInfo.abrir("Exportanto a excel...", "success", 100);
		$timeout(function() {$window.open('server/excel/records');} , 250);
		
	}

	function loadCollectRequests() {

		$scope.loadingRequests = true;

		var id = $scope.userId;

		var post = {};
			post.a = 'list_varios';
			post.from = 'collector_record';
			post.join = 1;
			post.where = 1;
			post.driver_id = id;

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                

                console.log(data);

                var jsonObject = angular.fromJson( data );
                $scope.loadingRequests = false;

                updateCollectRequestData( jsonObject['requests'] );

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	function updateCollectRequestData( newData ) {

		var na = doArray( newData );

        if ( na.length > 0 ){
        	$scope.collectRequests.data = na;
        	$scope.collectRequests.empty = false;
        }else {
        	$scope.collectRequests.empty = true;	
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