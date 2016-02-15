tymApp.factory( 'ConstantsService', function(){ // no inject $scope dependency,

    'use strict';

    var constantService = {
        MINIMUM_ORDER_VALUE : 10000,
        LIMIT_PAYU_ORDER_VALUE : 2800000,
        LIMIT_FOR_FREE_SHIPPING : 30000,
        SHIPPING_CHARGE : 1000,
        SHOPPINGCART_CHANGED : "SHOPPINGCART_CHANGED",
        UPDATE_ORDER : "UPDATE_ORDER",
        SALE_CHANGED : "SALE_CHANGED",
        POINTS_BASE : 0.02,
        PRODUCTS_CHARGED : 'PRODUCTS_CHARGED',
        CHANGE_PRODUCTS : 'CHANGE_PRODUCTS',
        DELIVERY_PERCENT : 0.02,
        DELIVERY_INSTALATION_PERCENT : 0.05,
        VIEW_DETAIL : 'VIEW_DETAIL'
    };

    return constantService;

});
