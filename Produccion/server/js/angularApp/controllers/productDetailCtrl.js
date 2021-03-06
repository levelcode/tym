tymApp.controller('productDetailCtrl', ['$scope', '$rootScope', '$cookies', '$rootScope', '$log', 'UtilService', 'ConstantsService', '$http', '$sce', function( $scope, $rootScope, $cookies, $rootScope, $log, UtilService, ConstantsService, $http, $sce ){

	var vehicle = { brand : 'ninguno' };
	var model = { model : 'ninguno' };
	var year = 'ninguno';
	$scope.loadingCompatibles = true;
	$scope.selectedSize = undefined;

	$scope.selectedCar = { vehicle, model, year};

    var shoppingCartInCookie = $cookies.getObject( 'shoppingcart' );

    if( shoppingCartInCookie != undefined )
        $scope.shoppingcart = shoppingCartInCookie;

    $scope.addToShoppingCart = function( productId, name, PLU, barcode, categoryId, presentation, cant, price, discount, tax, img, type, size, productInfo ) {

        var isNumber = UtilService.isInteger( cant );

        if ( isNumber ) {

            var quantity = parseInt(cant, 10);

            if (($scope.shoppingcart == undefined || !$scope.shoppingcart.haveProducts)) {

                $scope.shoppingcart = {};
                $scope.shoppingcart.products = [{}];
                $scope.shoppingcart.subtotal = 0;
                $scope.shoppingcart.shippingCharge = 0;
				$scope.shoppingcart.instalationValue = 0;
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
				$scope.shoppingcart.toSend = undefined;

                var firtsProduct = _chargeProductObject(productId, name, PLU, barcode, categoryId, presentation, quantity, price, discount, tax, img, type, size, productInfo);

                $scope.shoppingcart.products[$scope.shoppingcart.numOfproductsSubtotal] = firtsProduct;
                $scope.shoppingcart.numOfproductsSubtotal++;
                $scope.shoppingcart.numOfproductsTotal += quantity;
                $scope.shoppingcart.haveProducts = true;

            } else {
                if (($scope.shoppingcart != undefined) && ($scope.shoppingcart.products != undefined)) {

                    var currentProduct = _chargeProductObject(productId, name, PLU, barcode, categoryId, presentation, quantity, price, discount, tax, img, type, size, productInfo);

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

    function _chargeProductObject( productId, name, PLU, barcode, categoryId, presentation, cant, price, discount, tax, img, type, size, productInfo ) {
		console.log(productInfo);
        var priceUnit =  parseFloat( price );
        var discount = parseInt( discount );
        var taxUnit = parseFloat( tax );

		console.log(productInfo);
		var currentInstalationPrice = 0;
		if(productInfo.price_instalation != undefined )
			currentInstalationPrice = productInfo.price_instalation;
		if(productInfo.instalation_price != undefined )
			currentInstalationPrice = productInfo.instalation_price;
		if(productInfo.instalation != undefined )
			currentInstalationPrice = productInfo.instalation;


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
		currentProduct.size = (size == undefined) ? '': size;
		currentProduct.addInstalation = false;
		currentProduct.instalationValue = parseInt(currentInstalationPrice);
		currentProduct.subcategory = (productInfo.name != undefined) ? productInfo.name: (productInfo.subType != undefined) ? productInfo.subType : productInfo.from;
		currentProduct.from = (productInfo.from != undefined) ? productInfo.from: '';


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

	$scope.show = function( data ){
		console.log(data);
		$scope.response = data;
		$scope.showComptariblesProducts = false	;
		$scope.selectedProductType = data.type;
		$scope.selectedProduct = data.info;
		if(data.subType != undefined){
			$scope.selectedProduct.subType = data.subType;
		}
		$scope.selectedProduct.img = data.images[0];
		$scope.selectedProductImages = data.images;

		if( data.type == 'rin' ){
			searchCompatibleTires( data.info.diameter, data.info.width );
		};
	}
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

        $http.post("/admin/server/api/Ajax.php", post)
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

	// $scope.sendToProductDetail = function( product, productType) {
	// 	if( angular.isString(product) )
	// 		product = angular.fromJson();
	// 	var data = { info: product, type: productType };
	// 	$scope.show(data);
	// }

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
				case 'get-product':
					getProductByIdAndReference(getParameterByName("category", $scope.queryString), getParameterByName("referencie", $scope.queryString), getParameterByName("product-id", $scope.queryString), getParameterByName("subcategory", $scope.queryString));
				break;
			}
		}else {
			window.location = "/";
		}
	}

	function getProductByIdAndReference(productCategory, referencie, productId, subcategory){
		$scope.loadingData = true;
		var fromCromados = false;
		var idItems =  productId.split('-');
		if(idItems.length > 1){
			subcategory = 'cromados';
			productId = idItems[0];
		}

		var post = {};
			post.a = 'unique_element';
			post.from = productCategory;
			post.action = "get_product";
			post.data = { category : productCategory, ref : referencie, id : productId, sub: subcategory};
		console.log(post);
        $http.post("/admin/server/api/Ajax.php", post)
        .success(function (data, status, headers, config) {
            console.log(data.data.img);
            $scope.loadingData = false;
            switch( data['status'] ) {
            	case 'SUCCESS':
	            	var jsonObject = angular.fromJson(data);
					var result = {};
					result.type = productCategory;
					result.subType = subcategory;
					result.info = jsonObject.data;
					result.images = jsonObject.images;
					loadSizesAndUnids(subcategory, data.data);
					console.log(result);
					console.log(jsonObject.data.img);
					$scope.show(result);
		            break;
				default:
					console.log(data + ' ' + status);
					break;
            }
        }).
        error(function (data, status, headers, config) {
            console.info(data + ":(");
    	});
	}

	function loadSizesAndUnids(subcategory, data){
		console.log(data);
		var productOptions = [];
		switch (subcategory) {
			case 'plumillas':
					var parentItems = data.size.split(',');
					console.log(parentItems);
					angular.forEach(parentItems, function(value, key){
						var childItems = value.split('/');
						var sizeAvailable = childItems[0];
						var unitsAvailable = childItems[1];
						var currentItem = {units:unitsAvailable, size:sizeAvailable};
						productOptions.push(currentItem);
					})
					$scope.productOptions = productOptions;
				break;
			case 'pijamas para vehiculos':
				var parentItems = data.size.split(',');
				console.log(parentItems);
				angular.forEach(parentItems, function(value, key){
					var childItems = value.split('/');
					var sizeAvailable = childItems[0];
					var unitsAvailable = childItems[1];
					var currentItem = {units:unitsAvailable, size:sizeAvailable};
					productOptions.push(currentItem);
				})
				$scope.productOptions = productOptions;
				break;
			default:

		}
	}
	$scope.$on('UPDATE_STOCK', function(event, data){
		$scope.selectedSize = data;
	});
	$scope.changeImage = function(newImage){
		$scope.selectedProduct.img = newImage;
	}
}]);
