adminTymApp.controller( 'notificationsCtrl', ['$scope', '$http', '$window', '$timeout', '$cookies', function( $scope, $http, $window, $timeout, $cookies ){
	
	'use strict';

	$scope.loadingNotifications = false;
	$scope.notifications = {};

	angular.element(document).ready(function(){
		
		//loadNotifications();	
		
	});


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