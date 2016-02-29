tymApp.controller( 'shoppingCartCtrl', ['$scope', '$cookies', '$rootScope', 'ConstantsService', '$http', function( $scope, $cookies, $rootScope, ConstantsService, $http ){

    'use strict';

    var todayFull = new Date();
    var todayDay = todayFull.getDate();

    todayFull.setDate( todayDay + 3 );

    var cookiesOptions = { path: "/" , expires: todayFull };


    $scope.read = function() {
        var post = 	{};
            post.a = 'read';

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

                console.log(data);

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
    }



    $scope.subtotal = 0;
    $scope.tax = 0;
    $scope.total = 0;
    $scope.limitOrderValueInvalid = false;

    var limitPayuOrderValue = ConstantsService.LIMIT_PAYU_ORDER_VALUE;
    var minimumOrderValue = ConstantsService.MINIMUM_ORDER_VALUE;
    var limitForFreeShipping = ConstantsService.LIMIT_FOR_FREE_SHIPPING;

    $rootScope.$on( ConstantsService.SHOPPINGCART_CHANGED, function(event, data){
        $scope.shoppingcart = data;

        if ( !$scope.shoppingcart.haveProducts ) {

            $cookies.remove('shoppingcart', cookiesOptions);
            $scope.shoppingcart = undefined;

        }else {

            var shoppingCartSubtotals;

            shoppingCartSubtotals = calculateShoppingcartSubtotals($scope.shoppingcart.products);

            $scope.shoppingcart.subtotal = shoppingCartSubtotals.productsSubtotal;
            $scope.shoppingcart.tax = shoppingCartSubtotals.productsTaxTotal;

            var auxSubtotal = $scope.shoppingcart.subtotal;

            if ( $scope.shoppingcart.hasDiscount ) {
                $scope.shoppingcart.subtotal -= $scope.shoppingcart.pointsDoDiscount;

                auxSubtotal += $scope.shoppingcart.pointsDoDiscount;
            }

            var shippingCharge = getShippingCharge(auxSubtotal, $scope.shoppingcart.instalationUsed, $scope.shoppingcart.deliveryUsed, $scope.shoppingcart.addDeliveryAndinstalation );

            console.info($scope.shoppingcart);

            $scope.shoppingcart.shippingCharge = shippingCharge;

            if ( $scope.shoppingcart.addDelivery || $scope.shoppingcart.addDeliveryAndinstalation ) {
                $scope.shoppingcart.total = $scope.shoppingcart.subtotal + $scope.shoppingcart.shippingCharge;
                $scope.shoppingcart.shippingFree = false;
            } else if ( $scope.shoppingcart.shippingFree != undefined && !$scope.shoppingcart.addDeliveryAndinstalation){
                $scope.shoppingcart.total = $scope.shoppingcart.total - $scope.shoppingcart.shippingCharge ;
                $scope.shoppingcart.shippingFree = true;
            }else {
                $scope.shoppingcart.total = $scope.shoppingcart.subtotal;
            }


            $scope.shippingCharge = $scope.shoppingcart.shippingCharge;
            $scope.subtotal = $scope.shoppingcart.subtotal;


            if (minimumOrderValue != undefined) {

                $scope.shoppingcart.minimumOrderValue = minimumOrderValue;

                if ($scope.shoppingcart.subtotal < minimumOrderValue)
                    $scope.shoppingcart.minimumOrderValueInvalid = true;
                else
                    $scope.shoppingcart.minimumOrderValueInvalid = false;

            }


            if (limitPayuOrderValue != undefined) {
                if ($scope.shoppingcart.total > limitPayuOrderValue)
                    $scope.shoppingcart.limitOrderValueInvalid = true;
                else
                    $scope.shoppingcart.limitOrderValueInvalid = false;
            }

            if ( limitForFreeShipping != undefined )
                $scope.shoppingcart.limitForFreeShipping = limitForFreeShipping;



            $scope.total = $scope.shoppingcart.total;

            $cookies.putObject('shoppingcart', $scope.shoppingcart, cookiesOptions);
        }


    });

    var shoppingCartInCookie = $cookies.getObject( 'shoppingcart' );

    if( shoppingCartInCookie != undefined ) {

        $scope.shoppingcart = shoppingCartInCookie;
        $scope.subtotal = $scope.shoppingcart.subtotal;
        $scope.shippingCharge = $scope.shoppingcart.shippingCharge;
        $scope.tax = $scope.shoppingcart.tax;
        $scope.total = $scope.shoppingcart.total;

    }

    function calculateShoppingcartSubtotals( products ) {

        var subtotal = 0;
        var tax = 0;

        angular.forEach( products, function(value ,key) {
                subtotal += ( value.price * value.cant );
                tax += ( value.tax * value.price );
        });

        var shoppingCartSubtotals = { productsSubtotal : subtotal,  productsTaxTotal : tax };

        return shoppingCartSubtotals;
    }


    $scope.removeProduct = function ( key ) {


        $scope.shoppingcart.products.splice( key, 1 );
        $scope.shoppingcart.numOfproductsTotal--;
        $scope.shoppingcart.numOfproductsSubtotal--;
  
        if ( $scope.shoppingcart.numOfproductsTotal == 0 ){
            $scope.shoppingcart.haveProducts = false;

        }

        $rootScope.$broadcast( ConstantsService.SHOPPINGCART_CHANGED, $scope.shoppingcart );

    };

    function getShippingCharge ( subtotal, instalationUsed, deliveryUsed, useInstalation  ) {

        var shippingCharge;

        if ( useInstalation || instalationUsed ) {
            shippingCharge = subtotal * ConstantsService.DELIVERY_INSTALATION_PERCENT;
            if ( instalationUsed ) {
                $scope.shoppingcart.instalationUsed = false;
            }else {
                $scope.shoppingcart.instalationUsed = true;
            }
        }else {
            shippingCharge = subtotal * ConstantsService.DELIVERY_PERCENT;

            if ( deliveryUsed ) {
                $scope.shoppingcart.deliveryUsed = false;
            }else {
                $scope.shoppingcart.deliveryUsed = true;
            }
        }

        return shippingCharge;
    }
    /**
    *  Update the every shoppingcart values
    * @param param0 the key of a product to change
    * @param param1 the type of change ('increase', 'decrease', 'delete') or default
    */
   $scope.recalculateTotals = function () {
       //var regex = /\./;

       if( (arguments != undefined) ) {
           switch ( arguments[1] ) {
               case 'addDelivery':
                   addDelivery();
                   break;
               case 'addDeliveryAndinstalation':
                   addDeliveryAndinstalation();
                   break;
               case 'decrease':
                   decreaseShoppingCart( arguments[0] );
                   break;
               case 'newValue':
                   increaseShoppingCart( arguments[0], arguments[2] );
                   break;
               case 'delete':
                   deleteShoppingCartProduct( arguments[0] );
                   break;
               default:
                   if( !(angular.isNumber( $scope.shoppingcart.products[ arguments[0] ].cant )) || ($scope.shoppingcart.products[ arguments[0] ].cant < 1) )
                       $scope.shoppingcart.products[ arguments[0] ].cant = 1;
           }

           if ($scope.shoppingcart.numOfproductsTotal == 0)
               $scope.shoppingcart.haveProducts = false;
       }

       $rootScope.$broadcast( ConstantsService.SHOPPINGCART_CHANGED, $scope.shoppingcart );
   };

   function addDeliveryAndinstalation(){

       if ( $scope.shoppingcart.addDeliveryAndinstalation ){
            $scope.shoppingcart.addDeliveryAndinstalation = false;
        }else{
            $scope.shoppingcart.addDeliveryAndinstalation = true;
            $scope.shoppingcart.addDelivery = false;
        }
   }

   function addDelivery(){
       if ( $scope.shoppingcart.addDelivery )
            $scope.shoppingcart.addDelivery = false;
        else
            $scope.shoppingcart.addDelivery = true;
   }

   function decreaseShoppingCart( key ) {

        if ( $scope.order.shoppingcart.products[key].cant > 1 ) {
            $scope.order.shoppingcart.products[key].cant--;
            $scope.order.shoppingcart.numOfproductsTotal--;
        }

    }

    function increaseShoppingCart( key, newQuantity ) {

        if ( newQuantity >= $scope.shoppingcart.products[key].cant ){
            var aux = newQuantity - $scope.shoppingcart.products[key].cant;
            $scope.shoppingcart.numOfproductsTotal += aux;
        }else{
            var aux = $scope.shoppingcart.products[key].cant - newQuantity;
            $scope.shoppingcart.numOfproductsTotal -= aux;
        }

        $scope.shoppingcart.products[key].cant = newQuantity;
    }

    function deleteShoppingCartProduct( key ){

        $scope.order.shoppingcart.products.splice( key, 1 );
        $scope.order.shoppingcart.numOfproductsTotal--;
        $scope.order.shoppingcart.numOfproductsSubtotal--;
    }


    $scope.close = function(){
        st.modal.cerrar();
    }

}]);
