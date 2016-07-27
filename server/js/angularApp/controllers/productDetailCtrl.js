tymApp.controller('productDetailCtrl', ['$scope', '$rootScope', '$cookies', '$rootScope', '$log', 'UtilService', 'ConstantsService', '$http', '$sce', function( $scope, $rootScope, $cookies, $rootScope, $log, UtilService, ConstantsService, $http, $sce ){

	var vehicle = { brand : 'ninguno' };
	var model = { model : 'ninguno' };
	var year = 'ninguno';
	$scope.loadingCompatibles = true;

	$scope.selectedCar = { vehicle, model, year};

    var shoppingCartInCookie = $cookies.getObject( 'shoppingcart' );

    if( shoppingCartInCookie != undefined )
        $scope.shoppingcart = shoppingCartInCookie;

    $scope.addToShoppingCart = function( productId, name, PLU, barcode, categoryId, presentation, cant, price, discount, tax, img, type, size ) {

        var isNumber = UtilService.isInteger( cant );

        if ( isNumber ) {

            var quantity = parseInt(cant, 10);

            if (($scope.shoppingcart == undefined || !$scope.shoppingcart.haveProducts)) {

                $scope.shoppingcart = {};
                $scope.shoppingcart.products = [{}];
                $scope.shoppingcart.subtotal = 0;
                $scope.shoppingcart.shippingCharge = 0;
					$scope.shoppingcart.shippingChargeAndInstalation = 0;
					$scope.shoppingcart.addDelivery = false;
					$scope.shoppingcart.addDeliveryAndinstalation = false;
                $scope.shoppingcart.tax = 0;
                $scope.shoppingcart.total = 0;
                $scope.shoppingcart.numOfproductsSubtotal = 0;
                $scope.shoppingcart.numOfproductsTotal = 0;
                $scope.shoppingcart.limitOrderValueInvalid = false;
                $scope.shoppingcart.minimumOrderValueInvalid = false;
                $scope.shoppingcart.hasDiscount = false;
                $scope.shoppingcart.sended = false;

                var firtsProduct = _chargeProductObject(productId, name, PLU, barcode, categoryId, presentation, quantity, price, discount, tax, img, type, size);

                $scope.shoppingcart.products[$scope.shoppingcart.numOfproductsSubtotal] = firtsProduct;
                $scope.shoppingcart.numOfproductsSubtotal++;
                $scope.shoppingcart.numOfproductsTotal += quantity;
                $scope.shoppingcart.haveProducts = true;

            } else {
                if (($scope.shoppingcart != undefined) && ($scope.shoppingcart.products != undefined)) {

                    var currentProduct = _chargeProductObject(productId, name, PLU, barcode, categoryId, presentation, quantity, price, discount, tax, img, type, size);

                    var products = $scope.shoppingcart.products;
                    var quantityProductIncreased = false;

                    angular.forEach(products, function (product, key) {
                        if (product != undefined) {
                            if ((productId == product.id) && (PLU == product.PLU)) {
                                quantityProductIncreased = true;
                                $scope.shoppingcart.products[key].cant += quantity;
                                $scope.shoppingcart.numOfproductsTotal += quantity;
                            }

                        }
                    });

                    if (!quantityProductIncreased) {
                        $scope.shoppingcart.products[$scope.shoppingcart.numOfproductsSubtotal] = currentProduct;
                        $scope.shoppingcart.numOfproductsSubtotal++;
                        $scope.shoppingcart.numOfproductsTotal += quantity;
                    }

                }
            }

            $rootScope.$broadcast(ConstantsService.SHOPPINGCART_CHANGED, $scope.shoppingcart);
			st.ventanaInfo.abrir('<img data-modal="carrito-compras" style="float:left;" src="/recursos/img/imgpsh_fullsize.png"><p style="margin: 10px 0 10px;" class="txt-15">Producto añadido al<span style="font-size: 13px;" class="c-color text-uppercase" > Carrito de compras </span></p>', 2000)
        }else {

        }

    };

    function _chargeProductObject( productId, name, PLU, barcode, categoryId, presentation, cant, price, discount, tax, img, type, size ) {

        var priceUnit =  parseFloat( price );
        var discount = parseInt( discount );
        var taxUnit = parseFloat( tax );

        var currentProduct = new Object();

        currentProduct.id = productId;
        currentProduct.PLU = PLU;
        currentProduct.name = name;
        currentProduct.barcode = barcode;
        currentProduct.categoryId = categoryId;
		currentProduct.img = img;
		currentProduct.type = type;
        currentProduct.presentation = presentation;
        currentProduct.cant = cant;
        currentProduct.tax = taxUnit == 0 ? 0 : taxUnit;
        currentProduct.price = priceUnit;
        currentProduct.discount = discount == 0 ? 0 : discount;
		currentProduct.size = size.toLowerCase();

        return currentProduct;
    }

    // angular.element(document).ready(function() {
    //     //charge_products();
    // });

    function charge_products() {

        var productsEncoded = $scope.productsEncoded;

        if ( productsEncoded != undefined ) {
            var productsJSON = productsEncoded.replace(/cInit/g, "[").replace(/llInit/g, "{").replace(/llEnd/g, "}").replace(/coInit/g, ",").replace(/cEnd/g, "]").replace(/cDInit/g, "\"").replace(/dPoS/g, ":");

            var productsDecoded = angular.fromJson(productsJSON);

            $scope.productsDecoded = productsDecoded;

            //$emit('');
        }
        //angular.element(document).controller('ngModel').$render();
        $log.info( $scope.productsDecoded );

    }


	/*
	listeners
	*/
	$rootScope.$on('vehicle_chaged', function( event, data ){
		$scope.selectedCar = data;
	});

	$rootScope.$on( ConstantsService.VIEW_DETAIL, function( event, data ){
		console.log(data);
		$scope.showComptariblesProducts = false	;
		$scope.selectedProductType = data.type;
		$scope.selectedProduct = data.info;
		$scope.selectedProduct.img = data.images[0];
		$scope.selectedProductImages = data.images;

		if( data.type == 'rin' ){
			searchCompatibleTires( data.info.diameter, data.info.width );
		}
	});

	function searchCompatibleTires( diameter, width ) {
		console.log( diameter + '-' + width );
		$scope.tiresCompatible = null;
		$scope.loadingCompatibles = true;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'home';
			post.action = "get_compatible_tires_with_rin";
			post.diameter = diameter;
			post.width = width;

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

                console.log(data);
                $scope.loadingCompatibles = false;

                switch( data['status'] ) {
                	case 'PRODUCTS_LOADED':
										$scope.showCompatiblesProducts = true;
			            	var jsonObject = angular.fromJson(data);
										var tiresCompatible = jsonObject['tires_compatibles'];
										$scope.tiresCompatible = tiresCompatible;
										// var str = '<li><a href="#"><img src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200"><span>205-50-R15</span></a></li><li><a href="#"><img src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200"><span>185-55-R15</span></a></li><li><a href="#"><img src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200"><span>195-50-R15</span></a></li><li>';
										// var realStr = '';
										// for( var i = 0 ; i < tiresCompatible.length; i++ ){
										// 	realStr += '<li><a ng-click="sendToProductDetail( \''+tiresCompatible[i].id+'\', \'tire\' )"><img src="admin/recursos/img/tire-products/' + tiresCompatible[i].img + '.gif" alt="" class="img-responsive" width="200"><span>'+ tiresCompatible[i].type +'</span></a></li>';
										// }
										// $('#slider-productos-compatibles').html(realStr);

			            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
	}

	$scope.sendToProductDetail = function( product, productType ) {

		if( angular.isString(product) )
			product = angular.fromJson();

		var data = { info: product, type: productType };

		$rootScope.$broadcast( ConstantsService.VIEW_DETAIL, data);

	}

	function getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	angular.element(document).ready(function(){
		$scope.loadingData = true;
		console.info($scope.queryString);
		chooseAction( getParameterByName("action", $scope.queryString));
	});


	function chooseAction( action ){
		if( action != undefined ){
			switch( action ){
				case 'get-rin-product':
					getProductByIdAndReference(getParameterByName("category", $scope.queryString), getParameterByName("referencie", $scope.queryString), getParameterByName("product-id", $scope.queryString));
				break;
			}
		}else {
			window.location = "/";
		}
	}

	function getProductByIdAndReference(productCategory, referencie, productId){
		$scope.loadingData = true;
		var post = {};
			post.a = 'unique_element';
			post.from = productCategory;
			post.action = "get_product";
			post.data = { category : productCategory, ref : referencie, id : productId };
        $http.post("/admin/server/api/Ajax.php", post)
        .success(function (data, status, headers, config) {
            console.log(data);
            $scope.loadingData = false;
            switch( data['status'] ) {
            	case 'SUCCESS':
	            	var jsonObject = angular.fromJson(data);
					var result = {};
					result.type = productCategory;
					result.info = jsonObject.data;
					result.images = jsonObject.images;
					$rootScope.$broadcast( ConstantsService.VIEW_DETAIL,result);
		            break;
				default:
					console.log(jsonObject);
					break;
            }
        }).
        error(function (data, status, headers, config) {
            console.info(data + ":(");
    	});
	}

	$scope.changeImage = function(newImage){
		$scope.selectedProduct.img = newImage;
	}
}]);
