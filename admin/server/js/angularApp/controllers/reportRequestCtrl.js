

carterApp.controller('reportRequestCtrl', ['$scope', '$http', '$timeout', '$window', '$rootScope', '$cookies', function( $scope, $http, $timeout, $window, $rootScope, $cookies ){

  'use strict';

  $(document).on("click" , "#btn-cancel-delete", function(){
     st.modal.cerrar();
  });
  $(document).on("click" , "#btn-ok-delete", function(){
    $scope.sendScheduledWastes();
  });

  angular.element(document).ready(function(){


		$scope.collectRequests = [];
		$scope.collectRequests.charged = false;
    $scope.loadingRequests = false;
    $scope.collectRequests.empty = false;
    $scope.wastedDoSchedule = {};
    $scope.wastedDoScheduleNumOfObjects = Object.size($scope.wastedDoSchedule);
    $scope.assingingVehicle = false;
    $scope.sendingRequest = false;
    $scope.DropdownNumbers = [];
    $scope.driverInfo = {};
    $scope.editingScheduledWastes = false;
    $scope.deleteingScheduledWaste = false;
    $scope.updateWastedDoScheduleList = false;


		loadCollectRequests();

    $scope.assingVehicle = function() {
      $scope.assingingVehicle = true;
      $scope.vehicleSelected = {};

      $scope.minDate = new Date();

      goToTab('assing_tab');
    }

    $scope.emitDate = function( date, isValid ) {

      var d = new Date( date );
      console.log(d);
      var formattedDate = d.getFullYear() + '-' + (d.getMonth() + 1) + '-'+ d.getDate();

      if( isValid ) {
          $rootScope.$emit('DATE_FOR_COLLECT_SELECTED', {date : formattedDate});
      }
    }


    $scope.addToListDoSchedule = function( requestInfo ) {

      if ( Object.size($scope.wastedDoSchedule) > 0 ) {

        if ( $scope.wastedDoSchedule[requestInfo.waste_id] != undefined ){
            delete $scope.wastedDoSchedule[requestInfo.waste_id];
        }else {
          $scope.wastedDoSchedule[requestInfo.waste_id] = requestInfo;
        }

      }else {
        $scope.wastedDoSchedule[requestInfo.waste_id] = requestInfo;
      }

      $scope.wastedDoScheduleNumOfObjects = Object.size( $scope.wastedDoSchedule );
      createDropdown( $scope.wastedDoScheduleNumOfObjects );
      console.log( $scope.wastedDoSchedule );
      console.log( $scope.wastedDoScheduleNumOfObjects );

    }

    $scope.showDriverInfo = function( info ) {
      console.log(info);

      var today = new Date();

      $scope.driverInfo.name = info.name + ' ' + info.last_name;
      $scope.driverInfo.identification = info.identification;
      $scope.driverInfo.mobile = info.mobile_phone;
      $scope.driverInfo.company = info.transport_company;

      $scope.vehicleSelected = info;
      //$scope.driverInfo.date = today.getFullYear() + ' / ' + (today.getMonth() + 1 ) + ' / ' + today.getDate();

    }

    $scope.assigNumber = function( info ) {
      
      console.info($scope.wastedDoSchedule);

      console.info(info);
    }

    $scope.cancelAll = function() {
      $scope.assingingVehicle = true;
      $scope.wastedDoSchedule = {};
      $scope.wastedDoScheduleNumOfObjects = Object.size($scope.wastedDoSchedule);
      $scope.assingingVehicle = false;
      $scope.DropdownNumbers = [];
      $scope.driverInfo = {};
      $scope.vehicleSelected = {};
      //$scope.dateOfCollect = {};
      $scope.deleteingScheduledWaste = false;
      $scope.editingScheduledWastes = false;
      $scope.deleteScheduledCollestRequestInfo = undefined;
      $scope.updateWastedDoScheduleList = false;
      goToTab('list_tab');
    }

    $scope.editListOfscheduledWastes = function( scheduledPlate, scheduledDate  ){

      $scope.editingScheduledWastes = true;
      $scope.wastedDoSchedule = searchWastesBySchedulePlate( scheduledPlate, scheduledDate );
      $scope.wastedDoScheduleNumOfObjects = Object.size($scope.wastedDoSchedule);
      createDropdown( $scope.wastedDoScheduleNumOfObjects );
      goToTab('assing_tab');

      console.log($scope.wastedDoSchedule);

    }

    $scope.unassigningCollectInfo = function( wasteInfo, fromList ) {
      console.log(wasteInfo);

      $scope.deleteingScheduledWaste = true;

        st.modal.abrir({
        archivo: 'delete-confirmation',
        completo: function(){
          
        }
      });

      $scope.deleteScheduledCollestRequestInfo = wasteInfo;

      if( fromList ) {
        $scope.updateWastedDoScheduleList = true;
      }
    }

    $scope.showPdfForCollector = function( request ) {

       putCookieForPdf( request );

       $timeout(function() {$window.open('recursos/pdf/documentos/logistic_remission');} , 250); 
    }

    $scope.sendScheduledWastes = function() {

       $scope.sendingRequest = true;

      var  scheduleToSend = {};
        scheduleToSend.vehicle = $scope.vehicleSelected;
        scheduleToSend.wastesData = doArray($scope.wastedDoSchedule);
        scheduleToSend.date = $scope.dateOfCollect;

      var post = {};

      post.scheduleToSend = scheduleToSend;
      post.a = "create_schedule_collect_request";

      post.type = "new_schedule_collect_request";

      if( $scope.editingScheduledWastes )
          post.type = "update_schedule_collect_request"; 

      if( $scope.deleteingScheduledWaste ){
          post.type = "unassigning_schedule_collect_request";               
          scheduleToSend.wastesData = $scope.deleteScheduledCollestRequestInfo;
      }

        console.log(scheduleToSend);
      $http.post("server/api/Ajax.php", post)
        .success(function (data, status, headers, config) {
          console.log(data);

          var response = angular.fromJson(data);

          switch( response.status ) {
            case 'CREATED':
              st.ventanaInfo.abrir("Asignación de recoleción enviada con éxito", "success");
              $scope.sendingRequest = false;
              $scope.cancelAll(); 
              updateCollectRequestData( response.updated_collect_request );
              //$timeout(function() {$window.location.reload();} , 2000 );
              break;
            case 'SCHEDULE_UPDATED':
               st.ventanaInfo.abrir("Asignación editada con éxito", "success");
               $scope.sendingRequest = false;
               $scope.cancelAll(); 
                updateCollectRequestData( response.updated_collect_request );
             
              break;
            case 'SCHEDULED_WASTE_COLLECT_REQUEST_DELETED':
                st.ventanaInfo.abrir("Asignación borrada con éxito", "success");
                $scope.sendingRequest = false;
                st.modal.cerrar();
                $scope.cancelAll();
                updateCollectRequestData( response.updated_collect_request );
                if( $scope.updateWastedDoScheduleList ) {
                  updateScheduledList();  
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
            $timeout(function() {$window.location.reload();} , 1000 );
        });
    }

    $rootScope.$on('DATE_FOR_COLLECT_SELECTED', function (event, data) {
      console.log(data);

      //$scope.dateOfCollect = new Date(data.date);
    });

	});

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
   $scope.pdfInfo.wastes = searchWastesBySchedulePlate( request.plate, request.sch_date );
    $scope.pdfInfo.driver = searchDriverById( request.driver_id );                      
                
   $cookies.putObject('remPdf', $scope.pdfInfo);
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

  function updateScheduledList() {

    angular.forEach( $scope.wastedDoSchedule, function (key, value){

      if( value.waste_id ==  $scope.deleteScheduledCollestRequestInfo.waste_id )
        delete $scope.wastedDoSchedule[key];

    });
  }

  function searchWastesBySchedulePlate( plate, date ){

    var result = {};
    angular.forEach( $scope.collectRequests, function (value, key) {

      if( value.plate == plate && value.sch_date == date )
        result[value.waste_id] = value;

    });
    
    return result;    

  }

  function createDropdown( numOfItems ) {

    var na = [];

    for ( var i = 0 ; i < numOfItems; i++ ) {
      na[i] = {value: i + 1, selected:0};
    }

    $scope.DropdownNumbers = na;

  }


  function goToTab( tabId ) {
    var el = document.getElementById( tabId );
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
		var id = $scope.clientId;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'report_request';
			post.join = 1;
			post.where = 1;
			post.client_id = id;

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

                $scope.vehicles = jsonObject['vehicles'];

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

	}

  Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
  };


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

      loadNotification(na);

      return na;

	}

  function doArrayProp( data ) {

    var i = 0, j = 0,
    na = [];

      angular.forEach(data, function (value1, key1) {
          var pro = [];

          angular.forEach(value1, function (value2, key2) {

            pro.push(value2);

          });
        
            na[key1] = pro;
            i++;
          
      });

      console.log(na);

      return na;

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
        //$timeout(function() {$scope.newCollectRequest( CrFounded, 1, notification.CrId );}, 125);
        $timeout(function() {$scope.identifyRow( notification.wId, "waste" );}, 125);
      
    }
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

}]);