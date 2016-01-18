
tymApp.controller('ShoppingCartAxuCtrl', ['$scope', '$window', '$log', '$rootScope', 'ConstantsService', '$cookies', function( $scope, $window, $log, $rootScope, ConstantsService, $cookies ){

    var todayFull = new Date();
    var todayDay = todayFull.getDate();

    todayFull.setDate( todayDay + 3 );

    var cookiesOptions = { path: "/" , expires: todayFull };

    $scope.numOfProducts = 0;

    var shoppingCartInCookie = $cookies.getObject( 'shoppingcart' );

    if( shoppingCartInCookie != undefined ) {

        $scope.shoppingcart = shoppingCartInCookie;
        $scope.numOfProducts = $scope.shoppingcart.numOfproductsSubtotal;
    }

    $rootScope.$on( ConstantsService.SHOPPINGCART_CHANGED, function(event, data){
        $scope.shoppingcart = data;

        if ( !$scope.shoppingcart.haveProducts ) {

            $cookies.remove('shoppingcart', cookiesOptions);
            $scope.numOfProducts = 0;

        }else {
            $scope.numOfProducts = $scope.shoppingcart.numOfproductsSubtotal;
        }

    });

}]);
