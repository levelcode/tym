tymApp.controller( 'menuProductCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){
    $showRinType = false;
    $showTireType = false;
    
    $scope.openProductType = function( productType ) {
        $rootScope.$broadcast( ConstantsService.CHANGE_PRODUCTS, productType );

        var result = undefined;
        console.log(productType);
        switch (productType) {
            case 'rin':
            console.log('selected');
                result = 'rines';
                break;
            default:

        }

        $rootScope.$emit('product_category_changed', items[result]);
    }
    $rootScope.$on('interest_you_items_loaded', function( event, data ){
		console.log('loading data items');
		items = data;
	});


}]);
