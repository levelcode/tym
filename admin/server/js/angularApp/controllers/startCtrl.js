adminTymApp.controller('startCtrl', ['$scope', '$http', '$timeout', '$cookies', '$window', '$cookies', function( $scope, $http, $timeout, $cookies, $window, $cookies ){

	//'use strict';

	$scope.notifications = {};
	$scope.loadingRequests = false;
	$scope.loadingChartData = false;

	angular.element(document).ready(function(){
		
		//loadNotifications();
		//loadChart();
		
	});

	$scope.previewNotification = function( collectRequestId, wasteId ) {

		var todayFull = new Date();
    	var todayMinuts = todayFull.getMinutes();

    	todayFull.setMinutes( todayMinuts + 1 );

		var cookieOptions = {path:'/', expires: todayFull};

		var selectedNotificationData = { CrId: collectRequestId, wId: wasteId };

		$cookies.putObject( 'notificationData', selectedNotificationData, cookieOptions );

		st.ventanaInfo.abrir("Redireccionando...", "success");

		var goTo;

		switch( $scope.userTypeId ){
			case 1:
				goTo = "/solicitud-cliente";
				break;
			case 2:
				goTo = "/reporte-solicitud";
				break;
			case 3:
				goTo = "/orden-servicio";
				break;
			case 4:
				goTo = "/ingreso-bascula";
				break;
		}

		$timeout(function() {window.location = goTo;} , 500 );
	}


	function loadNotifications() {


		$scope.loadingRequests = true;

		var id = $scope.userId;
		var userType = $scope.userTypeId;

		var post = 	{};
			post.a = 'list_varios';
			switch( userType ) {
				case 1:
					post.from = 'client_notifications';
					break;
				case 2:
					post.from = 'logistic_notifications';
					break;
				case 3:
					post.from = 'collector_notifications';
					break;
				case 4:
					post.from = 'weighing_machine_notifications';
					break;
			}
			post.page = 'start';
			post.join = 1;
			post.where = 1;
			post.client_id = id;

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                

                console.log(data);

                var jsonObject = angular.fromJson( data );
                $scope.loadingRequests = false;

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

	function loadChart() {
		$scope.loadingChartData = true;

		var id = $scope.userId;
		var post = 	{};
			post.a = 'list_varios';
			post.from = 'start_char';

		var userType = $scope.userTypeId;
			switch( userType ) {
				case 1:
					post.page = 'client_char';
					break;
				case 2:
					post.page = 'logistic_notifications';
					break;
				case 3:
					post.page = 'collector_notifications';
					break;
				case 4:
					post.page = 'weighing_machine_notifications';
					break;
			}

			post.join = 1;
			post.where = 1;
			post.client_id = id;

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
            	$scope.loadingChartData = false;
                
                console.log(data);

                var jsonObject = angular.fromJson( data );

                switch( jsonObject.status ) {
                	case 'FILTERED':
                		drawGoogleChart( jsonObject.data_chart );
                		break;
            		case 'EMPTY':
                		
                		break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
        	});

	}

	function drawGoogleChart(  ) {

		

	}



}]);