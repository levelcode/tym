carterApp.controller( 'editProfileCtrl', ['$scope', '$log', '$modal', '$http', function( $scope, $log, $modal, $http ) {

	"use strict";

	$scope.animationsEnabled = true;
	$scope.sendingRequest = false;
	$scope.loadingAddresses = false;
	$scope.addresses = {};
	$scope.updatingAddress = false;


	angular.element(document).ready(function(){

		if( $scope.userId  == 1 ) {
			$scope.loadingAddresses = true;
			loadAddresses();
		}

	});

	$scope.OpenEditProfileModal = function( userId ) {

		loadUserData( userId );

	}
	$scope.savePersonInCharge = function( personInCharge, addressId ) {
		$scope.updatingAddress = true;

		var post = 	{};
			post.a = 'update_client_address';
			post.table = 'client_address';
			post.column_id = 'id';
			post.id = addressId;
			
			post.personInCharge = personInCharge;

		$http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

            	$scope.updatingAddress = false;

            	$log.info(data);

            	switch( data.status ){
            		case "ADDRESS_UPDATED":
            			st.ventanaInfo.abrir("Persona encargada guardada con éxito", "success");
            			loadAddresses();
            			break;
        			case "ADDRESS_NOT_UPDATED":
            			break;
            	}

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
        });
	}

	function loadAddresses() {
		var userId = $scope.userId;

		var post = 	{};
			post.a = 'list_one_where';
			post.table = 'client_address';
			post.column_id = 'client_id';
			post.id = userId;

		$http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

            	$scope.loadingAddresses = false;

            	$log.info(data);

            	var jsonObject = angular.fromJson( data );
            	updateAddressesData( jsonObject );

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
        });
	}

	function loadUserData( userId ) {

		var id = userId;

		var post = 	{};
			post.a = 'list_one_where';
			post.table = 'client';
			post.column_id = 'id';
			post.id = id;

		$http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

				var result;
                
            	if( data[Object.keys(data)[0]].id != undefined )
            		result = data[Object.keys(data)[0]];
            	else
            		result = false;

            	var modalInstance = $modal.open({
			      animation: $scope.animationsEnabled,
			      templateUrl: 'edit-profile.html',
			      controller: 'editProfileModalInstanceCtrl',
			      size: "lg",//sm, lg
			      resolve: {
			        items: function () {
			        	$log.log(result);
			          	return result;
			        }
			      }	
		    	});

			    modalInstance.result.then(function ( newUserData ) {

			    	$scope.sendingRequest = true;
					$scope.newUserData = newUserData;
					updateProfile( newUserData );

					}, function () {
					$log.info('Modal dismissed at: ' + new Date());
			    });


            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
        });

        
	}

	function updateProfile( newUserData ) {

		var id = newUserData.id;

		var post = newUserData;
			delete newUserData.profile;
			post.a = 'update_profile';
			//post.table = 'client';
			post.column_id = 'id';
			post.id = id;

		$http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

				$log.info(data);

				if(Number(data.id)){
					$scope.sendingRequest = false;
					st.ventanaInfo.abrir("Perfil editado con exito", "success");
					setTimeout(function(){ window.location.reload()  }, 2000);
				}

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
        });
    }

    function updateAddressesData( newData ) {

		var na = doArray( newData );

        if ( na.length > 0 ){
        	$scope.addresses.data = na;
        	$scope.addresses.empty = false;
        }else {
        	$scope.addresses.empty = true;	
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