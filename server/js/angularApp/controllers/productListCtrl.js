-tymApp.controller('productListCtrl', ['$scope', '$rootScope', 'ConstantsService', function( $scope, $rootScope, ConstantsService ){
2	 
-
3	 
-	$scope.productsLoaded = false;
4	 
-	$scope.rinProductsSelected = false;
5	 
-	$scope.seatProductsSelected = false;
6	 
-	$scope.lightProductsSelected = false;
7	 
-
8	 
-	$scope.rinEmpty = false;
9	 
-	$scope.tireEmpty = false;
10	 
-	$scope.seatEmpty = false;
11	 
-	$scope.lightEmpty = false;
12	 
-	$scope.tankEmpty = false;
13	 
-	/*
14	 
-	listeners
15	 
-	*/
16	 
-	$rootScope.$on('vehicle_chaged', function( event, data ){
17	 
-		$scope.selectedCar = data;
18	 
-	});
19	 
-
20	 
-	$rootScope.$on( ConstantsService.CHANGE_PRODUCTS, function( event, data ) {
21	 
-		chooseProductsToShow( data );
22	 
-	});
23	 
-
24	 
-	$rootScope.$on( ConstantsService.PRODUCTS_CHARGED, function( event, data ){
25	 
-		//$scope.rinProducts = data;
26	 
-		$scope.productsLoaded = true;
27	 
-
28	 
-		angular.forEach( data, function( value, key ){
29	 
-			switch ( key ) {
30	 
-				case 'rin_products':
31	 
-					$scope.rinProducts = value;
32	 
-					if ( value.length == 0){
33	 
-						$scope.rinEmpty = true;
34	 
-					}
35	 
-					break;
36	 
-				case 'tire_products':
37	 
-					$scope.tireProducts = value;
38	 
-					if ( !(value.length > 0) ){
39	 
-						$scope.tireEmpty = true;
40	 
-					}
41	 
-					break;
42	 
-				case 'seat_products':
43	 
-					$scope.seatProducts = value;
44	 
-					if ( !(value.length > 0) ){
45	 
-						$scope.seatEmpty = true;
46	 
-					}
47	 
-					break;
48	 
-				case 'light_hid_products':
49	 
-					$scope.lightProducts = value;
50	 
-					if ( !(value.length > 0) ){
51	 
-						$scope.lightEmpty = true;
52	 
-					}
53	 
-				case 'tank_products':
54	 
-					$scope.tankProducts = value;
55	 
-					if ( !(value.length > 0) ){
56	 
-						$scope.tankEmpty = true;
57	 
-					}
58	 
-					break;
59	 
-				default:
60	 
-			}
61	 
-		});
62	 
-
63	 
-		chooseProductsToShow( 'rin' );
64	 
-	});
65	 
-
66	 
-	function chooseProductsToShow( productTypeToShow ) {
67	 
-		$scope.productsLoaded = true;
68	 
-		switch ( productTypeToShow ) {
69	 
-			case 'rin':
70	 
-				$scope.rinProductsSelected = true;
71	 
-				$scope.seatProductsSelected = false;
72	 
-				$scope.tireProductsSelected = false;
73	 
-				$scope.lightProductsSelected = false;
74	 
-				$scope.tankProductsSelected = false;
75	 
-				break;
76	 
-			case 'tire':
77	 
-				$scope.tireProductsSelected = true;
78	 
-				$scope.seatProductsSelected = false;
79	 
-				$scope.rinProductsSelected = false;
80	 
-				$scope.lightProductsSelected = false;
81	 
-				$scope.tankProductsSelected = false;
82	 
-				break;
83	 
-			case 'seat':
84	 
-				$scope.seatProductsSelected = true;
85	 
-				$scope.tireProductsSelected = false;
86	 
-				$scope.rinProductsSelected = false;
87	 
-				$scope.lightProductsSelected = false;
88	 
-				$scope.tankProductsSelected = false;
89	 
-				break;
90	 
-			case 'light_hid':
91	 
-				$scope.lightProductsSelected = true;
92	 
-				$scope.seatProductsSelected = false;
93	 
-				$scope.tireProductsSelected = false;
94	 
-				$scope.rinProductsSelected = false;
95	 
-				$scope.tankProductsSelected = false;
96	 
-				break;
97	 
-			case 'tank':
98	 
-				$scope.tankProductsSelected = true;
99	 
-				$scope.lightProductsSelected = false;
100	 
-				$scope.seatProductsSelected = false;
101	 
-				$scope.tireProductsSelected = false;
102	 
-				$scope.rinProductsSelected = false;
103	 
-				break;
104	 
-			default:
105	 
-				console.log('product type no programmed');
106	 
-				break;
107	 
-		}
108	 
-	}
109	 
-
110	 
-	function groupByRinType( data ) {
111	 
-
112	 
-		var na = [];
113	 
-			//na.rines = {};
114	 
-		angular.forEach(data, function (value, key) {
115	 
-
116	 
-       		na[value.diameter] = value;
117	 
-   		});
118	 
-
119	 
-		return na;
120	 
-	}
121	 
-
122	 
-	$scope.sendToProductDetail = function( product, productType ) {
123	 
-		var data = { info: product, type: productType };
124	 
-		$rootScope.$broadcast( ConstantsService.VIEW_DETAIL, data);
125	 
-	}
126	 
-
127	 
-}]);
128	 
-
129	 
-tymApp.filter('capitalize', function() {
130	 
-	return function(input, scope) {
131	 
-	if (input!=null)
132	 
-		input = input.toLowerCase();
133	 
-		return input.substring(0,1).toUpperCase()+input.substring(1);
134	 
-	}
135	 
-});