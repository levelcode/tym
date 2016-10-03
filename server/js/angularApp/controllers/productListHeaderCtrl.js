tymApp.controller('productListHeader', [ '$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){

	var vehicle = { brand : 'ninguno' };

	var model = { model : 'ninguno' };

	var year = 'ninguno';

	$scope.selectedCar = { vehicle, model, year};
	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;
	});

	$rootScope.$on('product_category_changed', function( event, data ){
		console.log(data);
		$scope.interestYouItems = data;
	});

	$scope.openProductType = function( productType ) {
        $rootScope.$broadcast( ConstantsService.CHANGE_PRODUCTS, productType );
    }

	$scope.sendToProductDetail = function( product, productType, productSubType ) {
		var data = { info: product, type: productType };
		var url = undefined;
		console.log(product);
		console.log(productSubType);

		switch (productType) {
			case 'rin':
				url = "/producto/" + productType + '/' + product.diameter + '/' + product.referencie + '/' + product.id;
				break;
			case 'tire':
				url = "/producto/" + productType + '/' + product.diameter + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
				break;
			default:
			case 'bomperestribos':
				url = "/producto/" + productType + '/' + productSubType + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
				break;
			case 'accesorios':
				url = "/producto/" + productType + '/' + productSubType + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
				break;
			case 'barras':
				url = "/producto/" + productType + '/' + productSubType + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
				break;
			case 'portaequipajes':
				url = "/producto/" + productType + '/' + product.size + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
				break;
			case 'parrillas':
				url = "/producto/" + productType + '/' + product.size + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
				break;
		}
		if(url != undefined)
			window.location = url;
	}

}]);
