tymApp.controller( 'menuProductCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){
    $showRinType = false;
    $showTireType = false;
    var interestYouItems = null;

    $scope.openProductType = function( productType ) {
        $rootScope.$broadcast( ConstantsService.CHANGE_PRODUCTS, productType );

        var result = undefined;
        console.log(productType);
        switch (productType) {
            case 'rin':
                result = 'rines';
                break;
            case 'tire':
                result = 'llantas';
                break;
            case 'accesorios':
                result = 'accesorios';
                break;
            default:

        }

        $rootScope.$emit('product_category_changed', interestYouItems[result]);
    }
    $rootScope.$on('interest_you_items_loaded', function( event, data ){
		console.log('loading data items');
		interestYouItems = data;
	});


}]);
