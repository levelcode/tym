
carterApp.controller( 'collectRequesCtrl', ['$scope', '$http', '$window', '$timeout', '$cookies', function( $scope, $http, $window, $timeout, $cookies ){

	'use strict';

	$(document).on("click" , "#btn-cancel-delete", function(){
		 st.modal.cerrar();
	});
	$(document).on("click" , "#btn-ok-delete", function(){
		$scope.sendNewCollectrequest( $scope.dataForDelete );
	});

	$(document).ready(function() {
		doScroll();
	});


	angular.element(document).ready(function(){

		$scope.collectRequests = {};
		$scope.requestingCollect = {};
		$scope.requestingCollect.waste = {};
		$scope.collectRequests.charged = false;
		$scope.collectRequests.empty = false;
		$scope.loadingRequests = true;
		$scope.newCollectRequested = false;
		$scope.sendingRequest = false;
		$scope.addingNewWaste = false;
		$scope.editWaste = false;
		$scope.wastesToShowLoaded = false;
		$scope.deletingCollectRequest = false;
		$scope.deletingWaste = false;
		$scope.wastesToAdd = [];
		$scope.wastesToAddArray = [];
		$scope.multipleWastes = false;
		$scope.notifications = {};

		//doScroll();

		$scope.newCollectRequest = function() {

			doScroll();
			$scope.cancelAll();
			
			if ( arguments.length == 3  && arguments[1] ) {
				//$scope.editWaste = true;

				if( $scope.editWaste )
					$scope.editWaste = false;	
				else
					$scope.editWaste = true;
				
				$scope.newCollectRequested = false;
				$scope.addingNewWaste = false;

				$scope.identifyRow(arguments[2], "collect_request");

				var el = document.getElementById('tab_profile');
				var ev = document.createEvent("MouseEvent");
		            ev.initMouseEvent(
		                "click",
		                true /* bubble */, true /* cancelable */,
		                window, null,
		                0, 0, 0, 0, /* coordinates */
		                false, false, false, false, /* modifier keys */
		                0 /*left*/, null
		            );
            	el.dispatchEvent(ev);

            	var addressLine1 =  { 	id : arguments[0].pickup_client_address_id , 
										address_line1 : arguments[0].address_line1
									};
				
				$scope.addressLine1ForEditWaste = addressLine1;
				$scope.collectRequestIdwastesToshow = arguments[0].id;									
				$scope.wastesToshow = arguments[0].wastes;
				$scope.wastesToShowLoaded = true;

				console.log($scope.wastesToshow);
				return false;
			}


			$scope.requestingCollect = {};

			if( $scope.newCollectRequested )
				$scope.newCollectRequested = false;	
			else
				$scope.newCollectRequested = true;

			removeAllSelections();
			tabHome();

			selectNewCollectRequestButton( $scope.newCollectRequested );
		}

		$scope.preSaveWaste = function ( newWaste ) {

			$scope.multipleWastes = true;

			if( $scope.editWaste  && ( $scope.editWastePosition != undefined ) ) {

				$scope.wastesToAddArray[ $scope.editWastePosition ] = newWaste;
				st.ventanaInfo.abrir("Residuo editado con exito", "success", 1000);
				$scope.editWaste = false;

			}else {
				console.log(newWaste);

				$scope.wastesToAdd.push(newWaste);
				$scope.wastesToAddArray = doArray($scope.wastesToAdd);
				st.ventanaInfo.abrir("Residuo listado con exito", "success", 1000);		
	
			}

			
			$scope.requestingCollect.waste = {};

			//console.log($scope.wastesToAddArray);
			//console.log($scope.wastesToAddArray);			
		}

		$scope.editPreSavedWastes = function ( wasteToEdit, position ) {

			$scope.editWaste = true;
			$scope.editWastePosition = position;
			$scope.requestingCollect.waste.wasteType =  wasteToEdit.wasteType;
			$scope.requestingCollect.waste.quantity = wasteToEdit.quantity;
			$scope.requestingCollect.waste.unit = wasteToEdit.unit;
			$scope.requestingCollect.waste.packing = wasteToEdit.packing;
			
		}

		$scope.deletePreSavedWastes = function ( position ) {

			if ( $scope.wastesToAddArray.length == 1 ){
				$scope.editWaste = false;
				$scope.addingNewWaste = false;
			}
				
			$scope.wastesToAddArray.splice( position, 1 );

		}

		$scope.anw = function (){

		
			$scope.cancelAll();
			doScroll();

			if( $scope.addingNewWaste )
				$scope.addingNewWaste = false;
			else
				$scope.addingNewWaste = true;

			tabHome();
			$scope.identifyRow(arguments[1], "collect_request");

			$scope.requestingCollect = {};

			var addressLine1 =  { 	id : arguments[0].pickup_client_address_id , 
									address_line1 : arguments[0].address_line1
								};

			$scope.requestingCollect.addressLine1 =  addressLine1;
			$scope.requestingCollect.collectRequestId = arguments[0].id;

			console.log(arguments[0]);

		}

		$scope.cancelAll = function() {

			$scope.newCollectRequested = false;
			$scope.sendingRequest = false;
			$scope.addingNewWaste = false;
			$scope.editWaste = false;
			$scope.wastesToAddArray = [];
			$scope.requestingCollect = {};
			$scope.multipleWastes = false;
			$scope.wastesToAdd = [];
			$scope.deletingCollectRequest = false;

			selectNewCollectRequestButton( $scope.newCollectRequested );
			//removeAllSelections();

		}

		$scope.dcr = function() {

			$scope.dataForDelete = arguments[0];
			$scope.deletingCollectRequest = true;

			st.modal.abrir({
				archivo: 'delete-confirmation',
				completo: function(){
					
				}
			});
		}

		$scope.identifyRow = function( id, type ) {


			switch( type ) {

				case 'collect_request':
					$scope.selectedRowId = id;

					console.log($scope.selectedRowId);

			        var el = document.getElementById( "request_" + id );

			        var iNowIt = angular.element(el).hasClass('identify');

			        removeoOthersSelections( id );
			      
		            angular.element(el).addClass("identify");

	            	break;
	            case "waste":
	            	$scope.selectedWasteRowId = id;


					console.log("selecting waste row id " + $scope.selectedWasteRowId);

			        var el = document.getElementById( "waste_" + id );

			        var iNowIt = angular.element(el).hasClass('identify');

			        //removeoOthersSelections( id );
			      
		            angular.element(el).addClass("identify");
		            
	            	break;
        	}

    	}

    	$scope.checkIfDisabled = function( tabId ) {
    		console.log(tabId);
    	}


		$scope.dw = function() {

			console.log('deleting waste');
			$scope.deletingCollectRequest = false;
			$scope.dataForDelete = arguments[0];
			$scope.deletingWaste = true;

			st.modal.abrir({
				archivo: 'delete-confirmation',
				completo: function(){
					
				}
			});
		}

		$scope.ew = function() {

			$scope.requestingCollect = {};

			var addressLine1 =  $scope.addressLine1ForEditWaste;
			$scope.requestingCollect.addressLine1 =  addressLine1;

			$scope.requestingCollect.waste = {};

			$scope.requestingCollect.waste.id = arguments[0]['id'];

			var wasteType = { 	id: arguments[0]['waste_type_id'], 
								type: arguments[0]['type']
							 }			
			$scope.requestingCollect.waste.wasteType =  wasteType;

			$scope.requestingCollect.waste.quantity = parseInt(arguments[0]['quantity']);

			var unit = {	id: arguments[0]['unit_of_measure_id'],
							unit: arguments[0]['unit']
						};
			$scope.requestingCollect.waste.unit = unit;

			var packing = {	id: arguments[0]['packaging_type_id'],
							packing: arguments[0]['packing']
						};
			$scope.requestingCollect.waste.packing = packing;

			tabHome();

			$('#cargo_contacto').focus();
			return false;
		}

		selectNewCollectRequestButton( $scope.newCollectRequested );
        loadCollectRequests($scope.newCollectRequested);


        $scope.sendNewCollectrequest = function( collectRequest ) {

        	$scope.sendingRequest = true;

        	collectRequest.clientId = $scope.userId;
			collectRequest.a ="create_collect_request";
			collectRequest.multipleWastes = 0;
			collectRequest.type = 'new_collect_request';

			if ( $scope.addingNewWaste ) {
				collectRequest.type = 'new_waste';
			}

			if ( $scope.editWaste ) {
				collectRequest.type = 'edit_waste';
			}

			if ( $scope.deletingCollectRequest ) {
				collectRequest.type = 'delete_collect_request';	
			}

			if ( $scope.deletingWaste ) {
				collectRequest.type = 'delete_waste';	
			}

			if ( $scope.multipleWastes ) {
				collectRequest.multipleWastes = 1;
				collectRequest.waste = $scope.wastesToAddArray;
			}

			var post = collectRequest;

        	console.log(collectRequest);

        	$http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
            	console.log(data);

            	var response = angular.fromJson(data);

            	switch( response.status ) {
	            	case 'CREATED':
	            		st.ventanaInfo.abrir("solicitud de recolección enviada con éxito", "success");
	            		$scope.sendingRequest = false;
	            		$scope.cancelAll();
	            		updateCollectRequestData( response.updated_collect_request );
	            		break;
	            	case 'WASTE_CREATED':
	            		st.ventanaInfo.abrir("Residuo agragedo con éxito", "success");
	            		$scope.sendingRequest = false;
	            		$scope.cancelAll();
	            		updateCollectRequestData( response.updated_collect_request );
	            		
	            		$timeout(function() {$scope.identifyRow($scope.selectedRowId, "collect_request");} , 250);
	            		break;
	            	case 'WASTE_UPDATED':
	            		st.ventanaInfo.abrir("Residuo actualizado con éxito", "success");
	            		$scope.sendingRequest = false;
	            		$scope.cancelAll();
	            		updateCollectRequestData( response.updated_collect_request );
	            		$timeout(function() {$scope.identifyRow($scope.selectedRowId, "collect_request");} , 250);
	            		break;
            		case 'COLLECT_REQUEST_DELETED':
	            		st.ventanaInfo.abrir("Solicitud de recoleción borrada con éxito", "success");
	            		$scope.sendingRequest = false;
	            		st.modal.cerrar();
	            		$scope.cancelAll();
	            		updateCollectRequestData( response.updated_collect_request );
	            		$timeout(function() {$scope.identifyRow($scope.selectedRowId, "collect_request");} , 250);
	            		break;
            		case 'WASTE_DELETED':
	            		st.ventanaInfo.abrir("Residuo borrado con éxito", "success");
	            		$scope.sendingRequest = false;
	            		st.modal.cerrar();
	            		$scope.wastesToShowLoaded = true;
	            		updateCollectRequestData( response.updated_collect_request );

	            		$timeout(function() {$scope.identifyRow($scope.selectedRowId, "collect_request");} , 125);
	            		
	            		var wastesToShow = doArray(response.updated_collect_request, true);

	            		if ( wastesToShow.length > 0){
	            			$scope.wastesToshow = wastesToShow[$scope.collectRequestIdwastesToshow].wastes;
	            		}else{
	            			$scope.wastesToshow = [];
	            			$scope.cancelAll();
            			}
            			
	            		break;
	            		default:
		            		st.ventanaInfo.abrir("Intentalo de nuevo", "error", 1000);
		            		$timeout(function() {$window.location.reload();} , 1000 );
	            		break;
            	}
                	
            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });

        }
    });

	function selectNewCollectRequestButton ( requested ) {

		if( requested )
			$scope.buttontext = "Cancelar";
		else
			$scope.buttontext = "Nueva solicitud de recolección";
	}

	function loadCollectRequests() {

		var id = $scope.userId;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'collect_request';
			post.join = 1;
			post.where = 1;
			post.client_id = id;

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                

                console.log(data);
                var jsonObject = angular.fromJson(data);
                console.log(jsonObject);

                $scope.collectRequests.charged = true;
                $scope.loadingRequests = false;

                updateCollectRequestData( jsonObject['requests'] );

                if( jsonObject['addresses'].length == 0 ) 
					$scope.addresses = {id:1234, address_line1: "Sin direcciones registradas"};                	
				else 
                	$scope.addresses = jsonObject['addresses'];                	

               	$scope.addresses = jsonObject['addresses'];
               	$scope.wasteTypes = jsonObject['waste_types'];
               	$scope.units = jsonObject['units_of_measure'];
               	$scope.packing = jsonObject['packaging_types'];

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	function tabHome() {

		var el = document.getElementById('tab_home');
		var ev = document.createEvent("MouseEvent");
            ev.initMouseEvent(
                "click",
                true /* bubble */, true /* cancelable */,
                window, null,
                0, 0, 0, 0, /* coordinates */
                false, false, false, false, /* modifier keys */
                0 /*left*/, null
            );
    	el.dispatchEvent(ev);
	}

	function removeAllSelections() {

		angular.forEach($scope.collectRequests.data, function (request, key) {
		 	
		 	var el = document.getElementById( "request_" + key );

	        var iNowIt = angular.element(el).hasClass('identify');

	        if ( iNowIt ) {
	            angular.element(el).removeClass("identify");
	        }
		});

	}
	function removeoOthersSelections( thisNotId ) {

		angular.forEach($scope.collectRequests.data, function (request, key) {
		 	
		 	var el = document.getElementById( "request_" + request.id );

		 	if ( request.id != thisNotId ){

		        var iNowIt = angular.element(el).hasClass('identify');

		        if ( iNowIt ) {
		            angular.element(el).removeClass("identify");
		        }
	    	}
		});

	}

	function doScroll() {

		$('a[rel="relativeanchor"]').click(function(){
		    $('html, body').animate({
		        scrollTop: $( $.attr(this, 'href') ).offset().top
	    	}, 800);
		    return false;
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

	function updateCollectRequestData( newData ) {

		var na = doArray( newData );

        if ( na.length > 0 ){
        	$scope.collectRequests.data = na;
        	$scope.collectRequests.empty = false;
        }else {
        	$scope.collectRequests.empty = true;	
        }
        
    	loadNotification( na );	

	}

	function loadNotification( collectRequests ) {

		var notification = $cookies.getObject( 'notificationData' );

		console.log(notification);
		if ( notification != undefined ) {

			var CrFounded;

			angular.forEach( collectRequests, function( value, key ){
				if( value.id == notification.CrId ){
					CrFounded = value;					
				}	
			});
    		$timeout(function() {$scope.newCollectRequest( CrFounded, 1, notification.CrId );}, 125);
    		$timeout(function() {$scope.identifyRow( notification.wId, "waste" );}, 125);
			
		}
	}
	
}]);