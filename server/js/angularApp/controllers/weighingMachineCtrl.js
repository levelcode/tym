
carterApp.controller( 'weighingMachineCtrl', ['$scope', '$http', '$timeout', '$cookies', '$window', '$modal', '$log', function( $scope, $http, $timeout, $cookies, $window, $modal, $log ){
	'use strict';

	$scope.loadingRequests = false;
	$scope.collectRequests = {};
	$scope.collectRequests.charged = true;
	$scope.showingWastes = false;
	$scope.showCollectRequests = false;
	
    $scope.showEditwasteForm = false;
    $scope.confirmingWaste = false;
    $scope.animationsEnabled = true;

	//Accordion config
	$scope.oneAtATime = false;
	$scope.status = {
		isFirstOpen: true,
		isFirstDisabled: false
	};


	angular.element(document).ready(function(){

		  $scope.showWastesToConfirm = function( request, crId ){
		    $scope.showingWastes = true;

		    $scope.clientId = request.client_id;
		    $scope.collectRequestId = request.id;
		    $scope.collectRequestIdwastesToshow = request.id;
		    $scope.schId = request.sch_id;
		    $scope.vehicleId = request.vehicle_id;
		    $scope.schDate = request.sch_date;

		    putCookieForPdf( request );

		    identifyRow( crId, "collect_request" );

		    var addressLine1 =  { 	id : arguments[0].pickup_client_address_id , 
									address_line1 : arguments[0].address_line1
								};

			$scope.addressLine1 = addressLine1;

		    console.log(request);

		    var goTo = "weighing-machine";
		    changeTab( goTo );

		    $scope.info = {};
		    $scope.info.collectGeneralinfo = {  companyName: request.driver[0].transport_company, 
		                                        companyNIT: request.driver[0].transport_company_nit,
		                                        companyAddress: request.main_address,
		                                        remissionEmail: request.email,
		                                        companyPhone: request.driver[0].transport_company_phone,
		                                        driverName: request.driver[0].name + ' ' + request.driver[0].last_name,
		                                        plate: request.plate,
		                                        driverPhone: request.driver[0].mobile_phone,
		                                        clientName: request.client_name,
		                                        clientNIT: request.identification,
		                                        collectAddress: request.address_line1,
		                                        collectCity : 'Bogota',
		                                        clientPhone : 7555888,
		                                        deliveryResponsible: request.person_in_charge,
		                                        mobile : 3125587458
		                                      }
		    $scope.info.wastes = request.wastes;
		    $scope.showCollectRequests = true;

		}

		$scope.saveVehicleWeights = function( vehicleInfo ) {

			st.ventanaInfo.abrir("Guardando ...", "success");

			$scope.sendingRequest = true;
			console.log(vehicleInfo);
			var id = $scope.userId;

			var post = 	{};
				post.a = 'add_vehicle_extra_info';
				post.userId = id;
				post.vehicleId = $scope.vehicleId;
				post.collectRequestId = $scope.collectRequestId;
				post.vehicleExtraInfo = {
					full: vehicleInfo.weightFull,
					empty: vehicleInfo.weightEmpty,
					unitId: vehicleInfo.unit.id
				};
				post.wastes = $scope.info.wastes;

				console.log(post);
	        $http.post("server/api/Ajax.php", post)
	            .success(function (data, status, headers, config) {

	            	$scope.sendingRequest = false;

	            	switch( data.status ) {
	            		case 'SUCCESS':
	            				st.ventanaInfo.abrir("Guardado con éxito", "success");
	            			break;
            			case 'NO_COMPLETED':
            					st.ventanaInfo.abrir("Intentalo de nuevo", "error");
	            			break;

	            	}

	                console.log(data);

	            }).
	            error(function (data, status, headers, config) {
	                console.info(data + ":(");
	            });
		}

	    $scope.editWaste = function( waste ) {
	    	
		    
		    $scope.showEditwasteForm = true;

		    $scope.requestingCollect = {};

		    $scope.requestingCollect.waste = {};

		    $scope.requestingCollect.waste.id = arguments[0]['id'];

		    var wasteType = {   id: arguments[0]['waste_type_id'], 
		              type: arguments[0]['type']
		             }      
		    $scope.requestingCollect.waste.wasteType =  wasteType;

		    $scope.requestingCollect.waste.quantity = parseInt(arguments[0]['quantity']);

		    var unit = {  id: arguments[0]['unit_of_measure_id'],
		            unit: arguments[0]['unit']
		          };
		    $scope.requestingCollect.waste.unit = unit;

		    var packing = { id: arguments[0]['packaging_type_id'],
		            packing: arguments[0]['packing']
		          };
		    $scope.requestingCollect.waste.packing = packing;
		}

		$scope.cancelAll = function(){
			cancelAll();
		}

	    $scope.confirmWasteData = function( waste ) {
			$scope.confirmingWaste = true;

			if( waste.collect_status_id <= 3 ) {
				$scope.sendNewCollectrequest( waste );
			}

	    }

	    $scope.openMailModal = function () {

	    	var modalInstance = $modal.open({
			      animation: $scope.animationsEnabled,
			      templateUrl: 'send-email.html',
			      controller: 'sendEmailModalInstanceCtrl',
			      size: "sm",//sm, lg
			      resolve: {
			        items: function () {
			        	
			          	return {};
			        }
			      }	
		    	});

			    modalInstance.result.then(function ( mailData ) {

			    	$scope.sendingRequest = true;
					$scope.mailData = mailData;

					$log.info(mailData);

					// if ( mailData != undefined ) {
						sendRemissionEmail( mailData );
					// }

					}, function () {
					$log.info('Modal dismissed at: ' + new Date());
			    });
			
		}

	    $scope.sendNewCollectrequest = function( collectRequest ) {

			$scope.sendingRequest = true;

			collectRequest.driver_id = $scope.driverId;
			collectRequest.clientId = $scope.clientId;

			//collectRequest.userId = $scope.userId;
			collectRequest.a ="create_collect_request";
			collectRequest.profile = "weighing_machine";
			collectRequest.type = 'new_collect_request';

			if ( $scope.showEditwasteForm ) {
				collectRequest.type = 'edit_waste';
				$scope.selectedWasteRowId = collectRequest.waste.id;
			}

			if ( $scope.confirmingWaste ) {
				collectRequest.type = 'confirm_waste';
				$scope.selectedWasteRowId = collectRequest.id;
			}

			var post = collectRequest;

			console.log(collectRequest);

			$http.post("server/api/Ajax.php", post)
			.success(function (data, status, headers, config) {
			  console.log(data);

			  var response = angular.fromJson(data);

			  switch( response.status ) {
			   
			    case 'WASTE_CREATED':
			      st.ventanaInfo.abrir("Residuo agragedo con éxito", "success");
			      $scope.sendingRequest = false;
			      cancelAll();
			      updateCollectRequestData( response.updated_collect_request );
			      
			      $timeout(function() {identifyRow($scope.selectedRowId, "collect_request");} , 250);
			      break;
			    case 'WASTE_UPDATED':
			      st.ventanaInfo.abrir("Residuo actualizado con éxito", "success");
			      $scope.sendingRequest = false;
			      //$scope.cancelAll();
			      updateCollectRequestData( response.updated_collect_request );
			      $scope.showEditwasteForm = false;
			      $scope.wastesToShowLoaded = true;

			      var wastesToShow = doArray(response.updated_collect_request, true);

					if ( wastesToShow.length > 0){
						$scope.info.wastes  = wastesToShow[$scope.collectRequestIdwastesToshow].wastes;
					}else{
						$scope.info.wastes  = [];
						$scope.cancelAll();
					}
			      $timeout(function() {identifyRow($scope.selectedRowId, "collect_request");} , 250);

			      $timeout(function() {identifyRow($scope.selectedWasteRowId, "waste");} , 250);
			      break;
			    case 'WASTE_CONFIRMED':
			      st.ventanaInfo.abrir("Residuo confirmado con éxito", "success");
			      $scope.sendingRequest = false;
			      //st.modal.cerrar();
			      //$scope.cancelAll();
			      $scope.wastesToShowLoaded = true;
			      updateCollectRequestData( response.updated_collect_request );

			      var wastesToShow = doArray(response.updated_collect_request, true);

					if ( wastesToShow.length > 0){
						$scope.info.wastes  = wastesToShow[$scope.collectRequestIdwastesToshow].wastes;
					}else{
						$scope.info.wastes  = [];
						$scope.cancelAll();
					}

					$timeout(function() {identifyRow($scope.selectedWasteRowId, "waste");} , 250);
			      //$timeout(function() {$window.location.reload();} , 2000 );
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
	    $scope.openPdf = function( type ) {

			if( type == "generate" ){

				var remPdfInCookie = $cookies.getObject('remPdf');

				var post = {};

				post.a = "create_remission";
				post.collectRequestId = $scope.collectRequestId;
				post.wastes = remPdfInCookie.wastes;

				console.log(post);

				$http.post("server/api/Ajax.php", post)
					.success(function (data, status, headers, config) {
						console.log(data);

						var response = angular.fromJson(data);

						switch( response.status ) {

						case 'REMISSION_CREATED':
						st.ventanaInfo.abrir("Remisión generada con éxito", "success");
						$scope.sendingRequest = false;

						cancelAll();
						$timeout(function() {identifyRow($scope.selectedRowId, "collect_request");} , 250);

						remPdfInCookie.generalInfo.nrem = '0000' + response.remission_id;// generate this
						$cookies.putObject('remPdf', remPdfInCookie);

						$timeout(function() {$window.open('recursos/pdf/documentos/remision');} , 250);


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

			if( type == "preview" )
				$timeout(function() {$window.open('recursos/pdf/documentos/remision');} , 250);


			}

	    $scope.goToWeighingMachine = function( waste ){
	    	
	    	$scope.showCollectRequests = false;
			$scope.showEditwasteForm = false;

	    	$scope.requestingCollect = {};

		    $scope.requestingCollect.waste = {};

		    $scope.requestingCollect.waste.id = arguments[0]['id'];

		    var wasteType = {   id: arguments[0]['waste_type_id'], 
		              type: arguments[0]['type']
		             }      
		    $scope.requestingCollect.waste.wasteType =  wasteType;

		    $scope.requestingCollect.waste.quantity = parseInt(arguments[0]['quantity']);

		    var unit = {  id: arguments[0]['unit_of_measure_id'],
		            unit: arguments[0]['unit']
		          };
		    $scope.requestingCollect.waste.unit = unit;

		    var packing = { id: arguments[0]['packaging_type_id'],
		            packing: arguments[0]['packing']
		          };
		    $scope.requestingCollect.waste.packing = packing;
	    }

		loadCollectRequests();

	});

	function sendRemissionEmail( mailData ) {

		var mail = {};
		mail.clientEmail = $scope.info.collectGeneralinfo.remissionEmail;
		mail.customEmail = mailData;

		var post = {};
		post.a = "send_remission";
		post.data = mail;

		$http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                console.log(data);

                $scope.sendingRequest = false;
                var jsonObject = angular.fromJson( data );

                switch( data.status ) {
                	case "REMISSION_NOT_GENERATED":
                		st.ventanaInfo.abrir("Primero debes generar una remision", "error");
                	break;
                	case "REMISSION_NOT_FOUNDED":
                		st.ventanaInfo.abrir("Primero debes generar una remision", "error");
                	break;
                	case "REMISSION_NOT_ENCODED":
                		st.ventanaInfo.abrir("A ocurrido un error", "error");
                	break;
                	case "REMISSION_NOT_SENDED":
                		st.ventanaInfo.abrir("A ocurrido un error", "error");
                	break;
                	case "REMISSION_SENDED":
                		st.ventanaInfo.abrir("Resmision enviada con éxito ", "success");
                	break;
                	default:
			        st.ventanaInfo.abrir("Intentalo de nuevo", "error", 1000);
			        $timeout(function() {$window.location.reload();} , 1000 );
			      break;

                }


            }).
            error(function (data, status, headers, config) {
            	st.ventanaInfo.abrir("Intentalo de nuevo", "error");
                console.info(data + ":(");
            });

	}

	function cancelAll(){
		$scope.showCollectRequests = false;
		
		$scope.showEditwasteForm = false;
		$scope.showingWastes = false;
		
		$scope.requestingCollect = {};
		var goTo = "homem";
		changeTab( goTo )
	}

	function putCookieForPdf( request ){

		$scope.pdfInfo = {};
		console.log(request);
		$scope.pdfInfo.generalInfo = { nrec: request.pickup_number };

		//$scope.pdfInfo.generalInfo = { nrem: request.pickup_number };

		$scope.pdfInfo.clientData = { cliName: request.client_name, 
								address_line1: request.address_line1, 
								city :'Bogotá', 
								cliIdentification : request.identification,
								personInCharge : request.person_in_charge
							 };
		$scope.pdfInfo.wastes = request.wastes;
		$scope.pdfInfo.driver = searchDriverById( request.driver_id );                                          
							  
		$cookies.putObject('remPdf', $scope.pdfInfo);
	}

	function identifyRow( id, type ) {

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

  	function searchDriverById( driverId ) {

		var driver;

		angular.forEach( $scope.vehicles , function ( value, key ) { 

		    if( value.driver_id == driverId ){
		      driver = value;
		    }

		});

		return driver;

	}
  	
	function removeoOthersSelections( thisNotId ) {

		angular.forEach($scope.collectRequests, function (request, key) {
		  
		  var el = document.getElementById( "request_" + request.id);

		  if (request.id != thisNotId ){

		        var iNowIt = angular.element(el).hasClass('identify');

		        if ( iNowIt ) {
		            angular.element(el).removeClass("identify");
		        }
		    }
		});	

	} 
	function changeTab( goTo ) {

		var el = document.getElementById( goTo );
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

	function loadCollectRequests() {

		$scope.loadingRequests = true;
		var id = $scope.userId;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'weighing_machine';
			post.join = 1;
			post.where = 1;
			post.user_id = id;

        $http.post("server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {
                

                console.log(data);
                var jsonObject = angular.fromJson(data);

                $scope.collectRequests.charged = true;
                $scope.loadingRequests = false;

                console.info(jsonObject['requests']);

                if ( !angular.isArray(jsonObject['requests']) )
                	updateCollectRequestData( jsonObject['requests'] );
                else
                	$scope.collectRequests = doArray(jsonObject['requests']);


            	$scope.wasteTypes = jsonObject['waste_types'];
               	$scope.units = jsonObject['units_of_measure'];
               	$scope.packing = jsonObject['packaging_types'];
               	$scope.vehicles = jsonObject['vehicles'];
               	$scope.vehiclesWeightUnits = jsonObject['vehicle_weight_units'];

                console.log($scope.collectRequests);
            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	function updateCollectRequestData( newData ) {

		var na = doArray( newData );

        if ( na.length > 0 ){
        	$scope.collectRequests = na;
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


    		$timeout(function() {$scope.showWastesToConfirm( CrFounded, notification.CrId );}, 125);
    		$timeout(function() {identifyRow( notification.wId, "waste" );}, 125);
			
		}
	}

	function doArray( data, preserveKey, items ) {

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