// Please note that $modalInstance represents a modal window (instance) dependency.
// It is not the same as the $modal service used above.

carterApp.controller('editProfileModalInstanceCtrl', [ '$scope', '$modalInstance', 'items', function($scope, $modalInstance, items){

  $scope.userData = items;

  selectUserProfile( items );

  function selectUserProfile( items ) {

    switch ( items.user_type_id ) {

              case '1':
                $scope.userData.profile = "Acopiador";
                break;
              case '2':
                $scope.userData.profile = "Logística";
                break;
              case '3':
                $scope.userData.profile = "Recolector";
                break;
              case '4':
                $scope.userData.profile=  "Báscula";
                break;
              case '5':
                $scope.userData.profile = "Admin";
                break;
              case '6':
                $scope.userData.profile = "Root";
                break;

    } 
  }

  $scope.save = function () {
    $modalInstance.close($scope.userData);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);