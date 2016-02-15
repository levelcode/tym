tymApp.controller( 'menuProductCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){

    $showRinType = false;
    $showTireType = false;

    $scope.openProductType = function( productType ) {

        $rootScope.$broadcast( ConstantsService.CHANGE_PRODUCTS, productType );

    }

}]);
