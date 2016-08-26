tymApp.controller('monthPromotionCtrl', ['$scope', '$http', '$sce', '$timeout', function( $scope, $http, $sce, $timeout ){

	$scope.loadingData = false;

	angular.element(document).ready(function(){
		loadPromotion();
	});

	function loadPromotion( ){
		$scope.loadingData = true;

		var post = 	{};
			post.a = 'list_varios';
			post.from = 'home';
			post.action = "get_main_page_promotion";

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

                console.log(data);
                $scope.loadingData = false;

                switch( data['status'] ) {
                	case 'PROMOTION_LOADED':
		            	var jsonObject = angular.fromJson(data);
			            //updatetDataToShow( jsonObject['menu_items'], "menu_items" );
			            $scope.promotions = jsonObject['promotions'];
		            break;
		            case 'ERROR':
		            	$timeout(function() {$window.location.reload();} , 1000 );
		            break;
                }

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });

	}

	function search(subcategory){
		return subcategory == $scope.aux;
	}
	$scope.sendToProductDetail = function( product, productType ) {
		var data = { info: product, type: productType };
		$scope.aux = productType;
		console.log(product);
		var accesoriesItems  = [
			'kit completo',
		 	'marco placa',
			'rejilla frontal',
			'cubierta stops traseros',
			'exploradoras',
			'barra de exploradoras',
			'tanques',
			'barra antivolco',
			'plumillas',
			'barra luces led',
			'portabicicleta',
			'portabicicleta de techo',
			'filtro de aire',
			'pijamas para vehiculos',
			'pitos',
			'reflejo logo',
			'rines ciegos',
			'tapete maletero',
			'tanques',
			'cromados',
			'pisa alfombras',
			'cortina maletero'
		];
		var url = undefined;

		var subcategory = accesoriesItems.find(search);
		console.log(subcategory);
		console.log(product.size);
		if(subcategory != undefined){
			alert('founded');
			console.log();
			url = "/producto/accesorios" + productType + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
		}else{
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
				// case 'accesorios':
				// 	url = "/producto/" + productType + '/' + productSubType + '/' + product.referencie.trim().replace(' ', '-') + '/' + product.id;
				// 	break;
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
		}
		console.log(url);
		// window.location = url;
	}

}]);
