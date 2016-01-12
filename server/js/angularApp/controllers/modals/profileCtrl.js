tymApp.controller( 'profileCtrl', ['$scope', '$cookies', function( $scope, $cookies ){
    //$scope.mainTitle = "Estos son los productos que has comprado";
    $scope.mainTitle = "No tienes compras registradas";
    $scope.dataLoaded = false;

    $scope.closeSession = function() {
        window.location = "/salir";
    }
}]);
