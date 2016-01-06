/**
 * Created by Adrian on 17/02/2015.
 */

tymApp.controller('CheckoutPanelCtrl', ['$scope', '$rootScope', '$log', '$cookies', '$http', 'ConstantsService', '$window', 'UtilService', function( $scope ,$rootScope ,$log ,$cookies, $http, ConstantsService, $window, UtilService ) {

    "use strict";

    $scope.shippingData = true;
    $scope.paymentMethod = false;
    $scope.orderSummary = false;

    $scope.shippingDataComplete = false;
    $scope.paymentMethodComplete = false;
    $scope.orderSummaryEnable = false;

    $scope.checkoutCurrentStep = "shippingData";

    $scope.loadingAddresses = false;
    $scope.addressesCharged = false;
    $scope.addressesEmpty = false;

    var orderInCookie = $cookies.getObject("order");
    var shoppingcartInCookie = $cookies.getObject("shoppingcart");


    if( ((orderInCookie != undefined) && (shoppingcartInCookie != undefined)) && !orderInCookie.sended) {
            orderInCookie.shoppingcart = shoppingcartInCookie;
            $scope.order = orderInCookie;

            if ( orderInCookie.currentStep == undefined )
                orderInCookie.currentStep = $scope.checkoutCurrentStep;

            $scope.checkoutCurrentStep = orderInCookie.currentStep;

            updateOrder( orderInCookie );

            switchCheckoutPanelSection( $scope.checkoutCurrentStep );
    }else {
        $scope.order = {};

        loadAddresses();

        if ( shoppingcartInCookie != undefined )
            $scope.order.shoppingcart = shoppingcartInCookie;
        else
            window.location = "/account/log_in";

        updateOrder( $scope.order );
    }

    $log.log($scope.order);

    function switchCheckoutPanelSection( panelSelection ) {

        switch (panelSelection) {
            case "shippingData":
                loadAddresses();
                if(!$scope.shippingData) {
                    $scope.shippingData = true;
                    $scope.paymentMethod = false;
                    $scope.orderSummary = false;
                    gotoAnchor();
                }
                break;
            case "paymentMethod":
                if(!$scope.paymentMethod) {
                    $scope.paymentMethod = true;
                    $scope.shippingData = false;
                    $scope.orderSummary = false;
                    gotoAnchor();
                }
                break;
            case "orderSummary":
                if(!$scope.orderSummary) {
                    $scope.orderSummary = true;
                    $scope.paymentMethod = false;
                    $scope.shippingData = false;
                    gotoAnchor();
                }
                break;
        }

    }

    $scope.openSection = function ( panelSelectionName ){
        switchCheckoutPanelSection( panelSelectionName )
    };

    $scope.stepCompleted = function ( newOrder, sectionName ) {
        switch ( sectionName ) {
            case "shippingData":
                newOrder.shippingData.status = true;
                newOrder.currentStep = "paymentMethod";
                $scope.shippingDataComplete = true;

                //select farmacy more nearby

                updateOrder( newOrder );
                switchCheckoutPanelSection( newOrder.currentStep );
            break;
            case "paymentMethod":
                newOrder.paymentMethod.status = true;
                newOrder.currentStep = "orderSummary";
                $scope.paymentMethodComplete = true;

                updateOrder( newOrder );
                switchCheckoutPanelSection( newOrder.currentStep );
            break;
            case "orderSummary":
                $scope.sendingOrder = true;

                var order = newOrder;

                order.date = UtilService.getDateMySql();
               
                order.from = 'WEB';

                order.points = order.shoppingcart.subtotal * ConstantsService.POINTS_BASE;

                $http.post("admin/server/api/Ajax.php" , { data : order} )
                    .success(function(data, status, headers, config) {

                        if ( data == "true" ) {
                            newOrder.sended = true;
                            $scope.sendingOrder = false;
                            $cookies.remove('shoppingcart');
                            gotoAnchor();
                            updateOrder( newOrder );
                        }else{
                            $scope.sendingOrder = false;
                            console.info(data);
                        }


                    }).
                    error(function(data, status, headers, config) {
                        $window.location.reload();
                        console.info(data + ":(");
                    });


            break;
        }
    };

    function updateOrder ( order ){
        $cookies.putObject("order", order);
    }

    $scope.changeUseAccountDataStatus = function(){

        updateOrder( $scope.order );

    };

    /**
     *  Update the every shoppingcart values
     * @param param0 the key of a product to change
     * @param param1 the type of change ('increase', 'decrease', 'delete') or default
     */
    $scope.recalculateTotals = function () {
        //var regex = /\./;

        if( (arguments != undefined) ) {
            switch ( arguments[1] ) {

                case 'decrease':
                    decreaseShoppingCart( arguments[0] );
                    break;
                case 'increase':
                    increaseShoppingCart( arguments[0] );
                    break;
                case 'delete':
                    deleteShoppingCartProduct( arguments[0] );
                    break;
                default:
                    if( !(angular.isNumber( $scope.order.shoppingcart.products[ arguments[0] ].cant )) || ($scope.order.shoppingcart.products[ arguments[0] ].cant < 1) )
                        $scope.order.shoppingcart.products[ arguments[0] ].cant = 1;
            }

            if ($scope.order.shoppingcart.numOfproductsTotal == 0)
                $scope.order.shoppingcart.haveProducts = false;
        }

        $rootScope.$broadcast( ConstantsService.SHOPPINGCART_CHANGED, $scope.order.shoppingcart );
    };


    function decreaseShoppingCart( key ) {

        if ( $scope.order.shoppingcart.products[key].cant > 1 ) {
            $scope.order.shoppingcart.products[key].cant--;
            $scope.order.shoppingcart.numOfproductsTotal--;
        }

    }

    function increaseShoppingCart( key ) {

        $scope.order.shoppingcart.products[key].cant++;
        $scope.order.shoppingcart.numOfproductsTotal++;

    }

    function deleteShoppingCartProduct( key ){

        $scope.order.shoppingcart.products.splice( key, 1 );
        $scope.order.shoppingcart.numOfproductsTotal--;
        $scope.order.shoppingcart.numOfproductsSubtotal--;
    }

    $scope.reedemPoints = function( Points ) {

        var PointsInt = parseInt(Points);

        var residue = PointsInt % 100;

        var pointsToUse = PointsInt - residue;

        if ( $scope.order.shoppingcart.hasDiscount ) {

            $scope.order.shoppingcart.hasDiscount = false;
            $scope.order.shoppingcart.subtotal += pointsToUse;

        }else {
            $scope.order.shoppingcart.pointsDoDiscount = pointsToUse;
            $scope.order.shoppingcart.hasDiscount = true;
        }

        $rootScope.$broadcast( ConstantsService.SHOPPINGCART_CHANGED, $scope.order.shoppingcart );
    };

    function gotoAnchor() {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    }

    function loadAddresses() {

        $scope.loadingAddresses = true;

        $http.get("admin/server/api/Ajax.php")
            .success(function (data, status, headers, config) {

                $scope.loadingAddresses = false;

                var result = angular.fromJson(data);

                if ( result.status == 'CHARGED' ) {
                    $scope.addressesCharged = true;

                    $scope.addresses = angular.fromJson(result.addresses);

                    console.info($scope.addresses);
                }

                if ( result.status == 'EMPTY' ) {
                    $scope.addressesEmpty = true;
                }

                if ( result.status == 'SESSION_EXPIRED' ) {
                    window.location = "/account";
                }


            }).
            error(function (data, status, headers, config) {
                //$window.location.reload();
                console.info(data + ":(");
            });
    }

}]);
