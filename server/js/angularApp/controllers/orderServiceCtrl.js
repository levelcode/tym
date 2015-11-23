

carterApp.controller('orderServiceCtrl', ['$scope', '$http', '$timeout', '$cookies', '$window', function( $scope, $http, $timeout, $cookies, $window ){

  $scope.collectRequests = {};
  $scope.collectRequests.charged = false;
  $scope.sendingRequest = false;
  $scope.requestingCollect = {};
  $scope.showCollectRequests = true;
  $scope.confirmingWaste = false;

	function loadCollectRequests() {

		var id = $scope.driverId;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'order_service';
			post.join = 1;
			post.where = 1;
			post.driver_id = id;

		  $http.post("server/api/Ajax.php", post)
				.success(function (data, status, headers, config) {
					 

					 console.log(data);
					 var jsonObject = angular.fromJson(data);

					 $scope.collectRequests.charged = true;
					 $scope.loadingRequests = false;

					 updateCollectRequestData( jsonObject['requests'] );

						$scope.wasteTypes = jsonObject['waste_types'];
						$scope.units = jsonObject['units_of_measure'];
						$scope.packing = jsonObject['packaging_types'];

				}).
				error(function (data, status, headers, config) {
					 console.info(data + ":(");
				});
	}


  function cancelAll(){
	 $scope.showAddwasteForm = false;
	 $scope.showEditwasteForm = false;
	 $scope.showingWastes = false;
	 $scope.showCollectRequests = true;
	 $scope.confirmingWaste = false;
	 $scope.requestingCollect = {};
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

    		$timeout(function() {$scope.showWastesToCollect( CrFounded, notification.CrId );}, 125);
    		$timeout(function() {identifyRow( notification.wId, "waste" );}, 125);
			
		}
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

  function loadAddresses( id ) {

	 var post =  {};
		post.a = 'list_varios';
		post.from = 'order_service_addresses_by_client_id';
		post.join = 1;
		post.where = 1;
		post.client_id = id;

	 $http.post("server/api/Ajax.php", post)
				.success(function (data, status, headers, config) {
					 
					 console.log(data);
					 var jsonObject = angular.fromJson(data);

					 $scope.addresses = jsonObject['addresses'];// by edit collectRequest
				  
				}).
				error(function (data, status, headers, config) {
					 console.info(data + ":(");
				});
  }

  function removeoOthersSelections( thisNotId ) {

	 angular.forEach($scope.collectRequests.data, function (request, key) {
		
		var el = document.getElementById( "request_" + key );

		if ( key != thisNotId ){

				var iNowIt = angular.element(el).hasClass('identify');

				if ( iNowIt ) {
					 angular.element(el).removeClass("identify");
				}
		  }
	 });

  }

  function cancelProcess() {
	 $scope.showingWastes = false;
	 $scope.info = {};
	 $scope.showAddwasteForm = false;
	 $scope.showCollectRequests = true;
	 $scope.confirmingWaste = false;

  }


  function putCookieForPdf( request ){

	 $scope.pdfInfo = {};
	 console.log(request);
	 $scope.pdfInfo.generalInfo = { nrec: request.pickup_number };

	 //$scope.pdfInfo.generalInfo = { nrem: request.pickup_number };

	 $scope.pdfInfo.clientData = { cliName: request.client_name, 
								address_line1: request.address_line1, 
								city :'Bogotá', 
								cliIdentification : request.identification
							 };
	 $scope.pdfInfo.wastes = request.wastes;                    
							  
	 $cookies.putObject('remPdf', $scope.pdfInfo);
  }

angular.element(document).ready(function(){

  loadCollectRequests();
  $scope.loadingRequests = true;

  //Accordion config
  $scope.oneAtATime = false;
  $scope.status = {
	 isFirstOpen: true,
	 isFirstDisabled: false
  };

  $scope.openMailModal = function () {
	 st.modal.abrir({
				archivo: 'enviar-correo',
				completo: function(){
			 
				}
		  });

  }

  $scope.test = function() {
  	console.log('asdasd	');
  }
  
  $scope.openPdf = function( type ) {

	 if( type == "generate" ){

		var remPdfInCookie = $cookies.getObject('remPdf');

	  var post = {};

	  post.a = "create_remission";
	  post.collectRequestId = $scope.collectRequestId;

	  console.log(post);
		
		$http.post("server/api/Ajax.php", post)
		  .success(function (data, status, headers, config) {
			 console.log(data);

			 var response = angular.fromJson(data);

			 switch( response.status ) {
			  
				case 'REMISSION_CREATED':
				  st.ventanaInfo.abrir("Remisión enviada con éxito", "success");
				  $scope.sendingRequest = false;
				  
				  cancelAll();
				  $timeout(function() {identifyRow($scope.selectedRowId);} , 250);

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

  $scope.cancelAll = function() {
	 cancelAll();
  }
  $scope.showWastesToCollect = function( request, crId ){
	 $scope.showingWastes = true;

	 $scope.clientId = request.client_id;
	 $scope.collectRequestId = request.id;
	 $scope.collectRequestIdwastesToshow = request.id;
	 $scope.schId = request.sch_id;
	 $scope.vehicleId = request.vehicle_id;
	 $scope.schDate = request.sch_date;

	 putCookieForPdf( request );

	 loadAddresses( request.client_id );

	 identifyRow( crId, "collect_request" );

	 $scope.requestingCollect.addressLine1 = {  id : request.pickup_client_address_id , 
						  address_line1 : request.address_line1
						};

	 $scope.wastesAddress = $scope.requestingCollect.addressLine1;

	 console.log(request);

	 $scope.info = {};
	 $scope.info.collectGeneralinfo = {  clientName: request.client_name, 
													 NIT: 777778188-9,
													 address: request.address_line1,
													 city : 'Bogota',
													 phone : 7555888,
													 deliveryResponsible: "Jose Velez",
													 mobile : 3125587458
												  }
	 $scope.info.wastes = request.wastes;


  }

  $scope.addWaste = function() {
	 $scope.requestingCollect = {};
	 $scope.requestingCollect.addressLine1 = $scope.wastesAddress;
	 
	 $scope.showEditwasteForm = false;   
	 $scope.showAddwasteForm = true; 

  }

  $scope.editWaste = function( waste ) {
	 $scope.showAddwasteForm = false;    
	 $scope.showEditwasteForm = true;

	 $scope.requestingCollect = {};
	 
	 $scope.requestingCollect.addressLine1 = $scope.wastesAddress;

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
	 $scope.confirmWasteData = function( waste ) {
		$scope.confirmingWaste = true;

		if( waste.collect_status_id < 3 ) {
		  $scope.sendNewCollectrequest( waste );
		}

	 }

	 $scope.sendNewCollectrequest = function( collectRequest ) {

		$scope.sendingRequest = true;

		collectRequest.driver_id = $scope.driverId;
		collectRequest.clientId = $scope.clientId;

		//collectRequest.userId = $scope.userId;
		collectRequest.a ="create_collect_request";
		collectRequest.profile = "collector";
		collectRequest.type = 'new_collect_request';

		if ( $scope.showAddwasteForm ) {
		  collectRequest.type = 'new_waste';
		  collectRequest.collectRequestId = $scope.collectRequestId;
		  collectRequest.isAssigned = 1;
		  collectRequest.schId = $scope.schId;
		  collectRequest.vehicleId = $scope.vehicleId;
		  collectRequest.schDate = $scope.schDate;
		}

		if ( $scope.showEditwasteForm ) {
		  collectRequest.type = 'edit_waste';
		}

		if ( $scope.confirmingWaste ) {
		  collectRequest.type = 'confirm_waste';
		}

		var post = collectRequest;

			 console.log(collectRequest);

			 $http.post("server/api/Ajax.php", post)
				.success(function (data, status, headers, config) {
				  console.log(data);

				  var response = angular.fromJson(data);

				  switch( response.status ) {
					
					 case 'WASTE_CREATED':
						st.ventanaInfo.abrir("Residuo agregado con éxito", "success");
						$scope.sendingRequest = false;
						cancelAll();
						updateCollectRequestData( response.updated_collect_request );
						
						$timeout(function() {identifyRow($scope.selectedRowId, "collect_request");} , 250);
						break;
					 case 'WASTE_UPDATED':
						st.ventanaInfo.abrir("Residuo actualizado con éxito", "success");
						$scope.sendingRequest = false;
						$scope.cancelAll();
						updateCollectRequestData( response.updated_collect_request );
						$timeout(function() {identifyRow($scope.selectedRowId, "collect_request");} , 250);
						break;
					 case 'WASTE_CONFIRMED':
						st.ventanaInfo.abrir("Residuo confirmado con éxito", "success");
						$scope.sendingRequest = false;
						//st.modal.cerrar();
						//$scope.cancelAll();
						$scope.wastesToShowLoaded = true;
						updateCollectRequestData( response.updated_collect_request );

						$scope.info.wastes = doArray(response.updated_collect_request, true)[$scope.collectRequestIdwastesToshow].wastes;

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

});

}]);