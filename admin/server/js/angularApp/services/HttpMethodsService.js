
adminTymApp.factory( 'HttpMethodsService', function(){ // no inject $scope dependency,


	var post = function( httpDependencie, postData ) {

		var result = undefined;

		httpDependencie.post( "server/api/Ajax.php", postData )
            .success(function (data, status, headers, config) {                
                return httpDependencie;                

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            	return data;
            });

	}

    var httpMethods = {
    	doPost : post
    };

    return httpMethods;

});




