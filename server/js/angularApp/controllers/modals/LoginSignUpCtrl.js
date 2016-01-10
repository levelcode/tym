tymApp.controller( 'LoginSignUpCtrl', ['$scope', '$http' , function( $scope, $http ){

    $scope.sendingData = false;
    $scope.loadingData = false;

    angular.element(document).ready(function(){
		createYears();
		createDays();
	});

    /*
    *base data
    */
	$scope.months = [{label:'Enero', id:'01'},
		{label:'Febrero', id:'02'},
		{label:'Marzo', id:'03'},
		{label:'Abril', id:'04'},
		{label:'Mayo', id:'05'},
		{label:'Junio', id:'06'},
		{label:'Julio', id:'07'},
		{label:'Agosto', id:'08'},
		{label:'Septiembre', id:'09'},
		{label:'Octubre', id:'10'},
		{label:'Noviembre', id:'11'},
		{label:'Diciembre', id:'12'}];

    function createDays() {
		var dayInit = 1;
		var dayEnd = 31;
		var days = [];
		var index = 0;
		for( var i = dayInit ; i <= dayEnd ; i++ ){
			var currentDay = {};
				currentDay.value = i;

			days[index] = currentDay;
			index++;
		}

		$scope.days = days;
	}

    function createYears() {
		var yearInit = 1900;
		var yearEnd = Number(new Date().getFullYear());
		var years = [];
		var index = 0;
		for( var i = yearInit ; i <= yearEnd ; i++ ){
			var currentYear = {};
				currentYear.value = i;

			years[index] = currentYear;
			index++;
		}

		$scope.years = years;
	}

    /*
    * Buttons binding
    */
    $scope.buttonLoginText = "Iniciar sesión";
    $scope.buttonSignupText ="Regístrarte";

    $scope.passwordMinLengthData = 6;


    $scope.doLogin = function( loginData ) {

        $scope.sendingData = true;
        $scope.buttonLoginText = "Iniciando sesión";

        var post = 	{};
            post.a = 'create_item';
            post.from = 'home';
            post.action = "create_user";
            post.data = loginData;

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

                $scope.sendingData = false;
                console.log(data);

                /*
                switch( data['status'] ) {
                    case 'VEHICLE_MODELS_LOADED':
                        var jsonObject = angular.fromJson(data);
                        updatetDataToShow( jsonObject['models'], "models" );
                        break;
                }*/

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
    }

    $scope.doSignup = function( signUpData ) {

        $scope.sendingData = true;
        $scope.buttonSignupText = "Enviando";

        var post = 	{};
            post.a = 'create_item';
            post.from = 'home';
            post.action = "create_user";
            post.data = signUpData;

        console.log(signUpData);

        $http.post("admin/server/api/Ajax.php", post)
            .success(function (data, status, headers, config) {

                $scope.sendingData = false;
                console.log(data);

            }).
            error(function (data, status, headers, config) {
                console.info(data + ":(");
            });
    }


    // Validations
    $scope.isEqual = function ( secondInput, typeInputToCompare ) {

        switch ( typeInputToCompare ) {
            case 'e':
                compareEmails( secondInput );
                break;
            case 'p':
                comparePasswords( secondInput );
                break;
        }
    };

    function compareEmails( emailInputConfirmation ) {

        if ( $scope.signUp.email != emailInputConfirmation ) {
            $scope.emailComparation = false;
        }else {
            $scope.emailComparation = true;
        }

    }

    function comparePasswords( passwordInputConfirmation ) {

        if ( $scope.signUp.password != passwordInputConfirmation ) {
            $scope.passwordComparation = false;
        }else {
            $scope.passwordComparation = true;
        }

    }


    document.onkeydown = function (e) {
        e = e || window.event;//Get event
        if (e.ctrlKey) {
            var c = e.which || e.keyCode;//Get key code

            console.info(e.keyCode);
            switch (c) {
                case 67://Block Ctrl+S
                    e.preventDefault();
                    e.stopPropagation();
                    break;
                case 86://Block Ctrl+W --Not work in Chrome
                    e.preventDefault();
                    e.stopPropagation();
                    break;
            }
        }
    };

}]);
