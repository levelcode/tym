/**
 * Created by Adrian on 13/01/2015.
 */

adminTymApp.factory( 'ConstantsService', function(){ // no inject $scope dependency,

    var responseStatusGettingData = {
        LOADED: 'LOADED'
    }

    var constantService = {
        responseStatus : responseStatusGettingData
    };

    return constantService;

});




