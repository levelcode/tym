
adminTymApp.factory( 'HttpMethodsService', function(){ // no inject $scope dependency,


	var post = function( httpDependencie ) {
		console.info(httpDependencie);
	}

    var httpMethods = {
    	doPost : post
    };

    return httpMethods;

});




