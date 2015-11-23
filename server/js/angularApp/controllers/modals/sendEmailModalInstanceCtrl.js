// Please note that $modalInstance represents a modal window (instance) dependency.
// It is not the same as the $modal service used above.

carterApp.controller('sendEmailModalInstanceCtrl', [ '$scope', '$modalInstance', 'items', function( $scope, $modalInstance, items ){

  //$scope.userData = items;


  $scope.send = function () {
    $modalInstance.close($scope.userData);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);