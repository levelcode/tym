carterApp.controller( 'notificationsCtrl', ['$scope', '$http', '$window', '$timeout', '$cookies', function( $scope, $http, $window, $timeout, $cookies ){
	
	'use strict';

	$scope.loadingNotifications = false;
	$scope.notifications = {};

	angular.element(document).ready(function(){
		
		loadNotifications();	
		
	});
	
	function loadNotifications() {


		$scope.loadingNotifications = true;

		var id = $scope.userId;
		var userType = $scope.userTypeId;

		var post = 	{};
			post.a = 'list_varios';
			switch( userType ) {
				case 1:
					post.from = 'client_notifications';
					post.page = '';
					break;
				case 2:
					post.from = 'logistic_notifications';
					post.page = 'report-request';
				break;
				case 3:
					post.from = 'collector_notifications';
					post.page = 'order-service';
				break;
				case 4:
					post.from = 'weighing_machine_notifications';
					post.page = 'ingreso-bascula';
				break;
			}

			post.join = 1;
			post.where = 1;
			post.client_id = id;


        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                

                console.log(data);

                var jsonObject = angular.fromJson( data );
                $scope.loadingNotifications = false;

                updateNotificationstData( jsonObject['notifications'] );

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
        	});

	}

	function updateNotificationstData( newData ) {

		var na = doArray( newData );

        if ( na.length > 0 ){
        	$scope.notifications.data = na;
        	$scope.notifications.empty = false;
        }else {
        	$scope.notifications.empty = true;	
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