tymApp.controller( 'shoppingCartCtrl', ['$scope', '$cookies', '$rootScope', 'ConstantsService', '$http', function( $scope, $cookies, $rootScope, ConstantsService, $http ){

    'use strict';
    var dropdownMaxValue = 12;

    angular.element(document).ready(function(){
        $scope.quantityDropdownItems = createRange(dropdownMaxValue);

        var itemsSignature = $scope.apiKey + '~' + $scope.merchantId + '~' + $scope.referenceCode + '~' + $scope.shoppingcart.total + '~' + 'COP';
        createSignature(itemsSignature);
	});

    $scope.merchantId = "566006";
    $scope.accountId = "568589";
    $scope.apiKey = "KcpKUJXxW46g7K9qrIum5vBNTf";
    $scope.referenceCode = Math.floor((Math.random() * 10000) + 1);
    // $scope.devPayURLProduction = 'https://gateway.payulatam.com/ppp-web-gateway/';
    // $scope.devPayURL = 'https://sandbox.gateway.payulatam.com/ppp-web-gateway/';

    $scope.tableData =
    [
        {city:"ARMENIA", priceWeigth : 13000, priceSecure : 5000 , time : "24 horas"},
        {city:"BARRANQUILLA", priceWeigth : 18000 , priceSecure : 5000 , time : "48 horas"},
        {city:"BUCARAMANGA", priceWeigth : 13000, priceSecure : 5000 , time : "24 horas"},
        {city:"CALI", priceWeigth : 13000, priceSecure : 5000 , time : "36 horas"},
        {city:"CHIA", priceWeigth : 9000, priceSecure : 5000 , time : "24 horas"},
        {city:"CUCUTA", priceWeigth : 20500, priceSecure : 5000 , time : "48 horas"},
        {city:"FACATATIVA", priceWeigth : 10500, priceSecure : 5000 , time : "24 horas"},
        {city:"FUNZA", priceWeigth : 9000, priceSecure : 5000 , time : "24 horas"},
        {city:"FUSAGASUGA", priceWeigth : 11500, priceSecure : 5000 , time : "24 horas"},
        {city:"LA MESA", priceWeigth : 17000, priceSecure : 5000 , time : "24 horas"},
        {city:"MADRID", priceWeigth : 10500, priceSecure : 5000 , time : "24 horas"},
        {city:"MEDELLIN", priceWeigth : 13000, priceSecure : 5000 , time : ""},
        {city:"PASTO", priceWeigth : 25000, priceSecure : 5000 , time : "48 horas"},
        {city:"ZIPAQUIRA", priceWeigth : 12000, priceSecure : 5000 , time : "24 horas"}
    ];


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

            var shippingCharge = getShippingCharge(auxSubtotal, $scope.shoppingcart.instalationUsed, $scope.shoppingcart.deliveryUsed, $scope.shoppingcart.addDeliveryAndinstalation, $scope.shoppingcart.products );

            if( shippingCharge > 80000 ){
                shippingCharge = 80000;
            }

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

            var itemsSignature = $scope.apiKey + '~' + $scope.merchantId + '~' + $scope.referenceCode + '~' + $scope.shoppingcart.total + '~' + 'COP';
            createSignature(itemsSignature);

            $cookies.putObject('shoppingcart', $scope.shoppingcart, cookiesOptions);
        }


    });

    function createSignature(string){
        $scope.signature = MD5(string);
        console.log($scope.signature);
    }

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

    function createRange( maxValue ) {
        var items = [];
        for( var i = 0; i < maxValue ; i++ ){
            items[i] = i+1;
        }
        return items;
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

    function getShippingCharge ( subtotal, instalationUsed, deliveryUsed, useInstalation, products ) {

        var shippingCharge = 0;

        angular.forEach(products, function(item, key){
            switch (item.size) {
                case 'p':
                    shippingCharge += 15000;
                break;
                case 'm':
                    shippingCharge += 20000;
                break;
                case 'g':
                    shippingCharge += 40000;
                break;

            }
        });

        // if ( useInstalation || instalationUsed ) {
        //     shippingCharge = subtotal * ConstantsService.DELIVERY_INSTALATION_PERCENT;
        //     if ( instalationUsed ) {
        //         $scope.shoppingcart.instalationUsed = false;
        //     }else {
        //         $scope.shoppingcart.instalationUsed = true;
        //     }
        // }else {
        //     shippingCharge = subtotal * ConstantsService.DELIVERY_PERCENT;
        //
        //     if ( deliveryUsed ) {
        //         $scope.shoppingcart.deliveryUsed = false;
        //     }else {
        //         $scope.shoppingcart.deliveryUsed = true;
        //     }
        // }

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
                    if(arguments[2] == "BOGOTA" || $scope.shoppingcart.addDelivery){
                        if(arguments[2] == "BOGOTA")
                            $scope.localDelivery = true;
                        else {
                            $scope.localDelivery = false;
                        }

                        addDelivery();
                    }else{
                        $scope.localDelivery = false;
                    }
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

    var MD5 = function (string) {

        function RotateLeft(lValue, iShiftBits) {
            return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
        }

        function AddUnsigned(lX,lY) {
            var lX4,lY4,lX8,lY8,lResult;
            lX8 = (lX & 0x80000000);
            lY8 = (lY & 0x80000000);
            lX4 = (lX & 0x40000000);
            lY4 = (lY & 0x40000000);
            lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
            if (lX4 & lY4) {
                return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
            }
            if (lX4 | lY4) {
                if (lResult & 0x40000000) {
                    return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
                } else {
                    return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
                }
            } else {
                return (lResult ^ lX8 ^ lY8);
            }
        }

        function F(x,y,z) { return (x & y) | ((~x) & z); }
        function G(x,y,z) { return (x & z) | (y & (~z)); }
        function H(x,y,z) { return (x ^ y ^ z); }
        function I(x,y,z) { return (y ^ (x | (~z))); }

        function FF(a,b,c,d,x,s,ac) {
            a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
            return AddUnsigned(RotateLeft(a, s), b);
        };

        function GG(a,b,c,d,x,s,ac) {
            a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
            return AddUnsigned(RotateLeft(a, s), b);
        };

        function HH(a,b,c,d,x,s,ac) {
            a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
            return AddUnsigned(RotateLeft(a, s), b);
        };

        function II(a,b,c,d,x,s,ac) {
            a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
            return AddUnsigned(RotateLeft(a, s), b);
        };

        function ConvertToWordArray(string) {
            var lWordCount;
            var lMessageLength = string.length;
            var lNumberOfWords_temp1=lMessageLength + 8;
            var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
            var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
            var lWordArray=Array(lNumberOfWords-1);
            var lBytePosition = 0;
            var lByteCount = 0;
            while ( lByteCount < lMessageLength ) {
                lWordCount = (lByteCount-(lByteCount % 4))/4;
                lBytePosition = (lByteCount % 4)*8;
                lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
                lByteCount++;
            }
            lWordCount = (lByteCount-(lByteCount % 4))/4;
            lBytePosition = (lByteCount % 4)*8;
            lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
            lWordArray[lNumberOfWords-2] = lMessageLength<<3;
            lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
            return lWordArray;
        };

        function WordToHex(lValue) {
            var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
            for (lCount = 0;lCount<=3;lCount++) {
                lByte = (lValue>>>(lCount*8)) & 255;
                WordToHexValue_temp = "0" + lByte.toString(16);
                WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
            }
            return WordToHexValue;
        };

        function Utf8Encode(string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";

            for (var n = 0; n < string.length; n++) {

                var c = string.charCodeAt(n);

                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }

            }

            return utftext;
        };

        var x=Array();
        var k,AA,BB,CC,DD,a,b,c,d;
        var S11=7, S12=12, S13=17, S14=22;
        var S21=5, S22=9 , S23=14, S24=20;
        var S31=4, S32=11, S33=16, S34=23;
        var S41=6, S42=10, S43=15, S44=21;

        string = Utf8Encode(string);

        x = ConvertToWordArray(string);

        a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

        for (k=0;k<x.length;k+=16) {
            AA=a; BB=b; CC=c; DD=d;
            a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
            d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
            c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
            b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
            a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
            d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
            c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
            b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
            a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
            d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
            c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
            b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
            a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
            d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
            c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
            b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
            a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
            d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
            c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
            b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
            a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
            d=GG(d,a,b,c,x[k+10],S22,0x2441453);
            c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
            b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
            a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
            d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
            c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
            b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
            a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
            d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
            c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
            b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
            a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
            d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
            c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
            b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
            a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
            d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
            c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
            b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
            a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
            d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
            c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
            b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
            a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
            d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
            c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
            b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
            a=II(a,b,c,d,x[k+0], S41,0xF4292244);
            d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
            c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
            b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
            a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
            d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
            c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
            b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
            a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
            d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
            c=II(c,d,a,b,x[k+6], S43,0xA3014314);
            b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
            a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
            d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
            c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
            b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
            a=AddUnsigned(a,AA);
            b=AddUnsigned(b,BB);
            c=AddUnsigned(c,CC);
            d=AddUnsigned(d,DD);
        }

        var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

        return temp.toLowerCase();
    }

}]);
