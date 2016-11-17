'use strict';
var config = {
    api: 'http://csc131.slavikf.com/api/json/response.php'
};
angular
    .module(
        'parkingLotAutomationApp', // Name of the app
        [ // Dependencies
            'ui.router'
        ]
    )
    .config(function ($httpProvider) {
        //Reset headers to avoid OPTIONS request (aka preflight)
        $httpProvider.defaults.headers.common = {};
        $httpProvider.defaults.headers.post = {};
        $httpProvider.defaults.headers.put = {};
        $httpProvider.defaults.headers.patch = {};
    })
    .run(function ($rootScope, $state, $http) {
        $rootScope.session = null;
        /*$rootScope.$on('$stateChangeStart',
         function(event, toState, toParams, fromState, fromParams, options){
         console.log($rootScope.session);
         //console.log(fromState);
         console.log(toState);
         //console.log(event);
         if(!$rootScope.session && (toState.name != 'log-in' /!*|| toState.name != 'sign-up'*!/)){
         event.preventDefault();
         console.log('asdf');
         $state.go('log-in');
         //$rootScope.checkSession(fromState, toState);
         // transitionTo() promise will be rejected with
         // a 'transition prevented' error
         }
         });*/
        //$rootScope.checkSession = function (fromState, toState) {
        var request = {
            method: 'POST',
            url: config.api,
            data: {
                request: 'check_session'
            }
        };
        $http(request).then(
            function (response) {
                //if(response.data.type == 'error' && fromState.name != 'log-in')
                //$state.go('log-in');
                console.log(response.data);
                // console.log(fromState);
                // console.log(toState);
                //$state.go('log-in');
            }, function (error) {
                console.log(error);
            }
        );
        //};
    });
