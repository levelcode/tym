

carterApp.controller('datePickerCtrl', ['$scope', '$rootScope', function( $scope, $rootScope ){
 
 // angular.element(document).ready(function(){

   $scope.minDate = new Date();

     //var d = today.getFullYear() + '-' + (today.getMonth()) + '-'+ today.getDate();

    $scope.emitDate = function( date, isValid ) {

        var d = new Date( date );
        console.log(d);
        var farmattedDate = d.getFullYear() + '-' + (d.getMonth() + 1) + '-'+ d.getDate();

        if( isValid ) {
            $rootScope.$emit('DATE_FOR_COLLECT_SELECTED', {date : farmattedDate});
        }
    }
    /*
    $scope.today = function() {
    $scope.dt = new Date();
    };
    $scope.today();

    $scope.clear = function () {
    $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function(date, mode) {
    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
    };

    $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();
    $scope.maxDate = new Date(2020, 5, 22);

    $scope.open = function($event) {
        $scope.status.opened = true;
    }

    $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];

    $scope.status = {
    opened: false
    };

    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var afterTomorrow = new Date();
    afterTomorrow.setDate(tomorrow.getDate() + 2);
    $scope.events =
    [
      {
        date: tomorrow,
        status: 'full'
      },
      {
        date: afterTomorrow,
        status: 'partially'
      }
    ];

    $scope.getDayClass = function(date, mode) {
    if (mode === 'day') {
      var dayToCheck = new Date(date).setHours(0,0,0,0);

      for (var i=0;i<$scope.events.length;i++){
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
    };*/
 // });
}]);
