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
        $rootScope.session = null; // On load init this to null
        $rootScope.$on('$stateChangeStart',
            function (event, toState, toParams, fromState, fromParams, options) {
                if (!$rootScope.session && !(toState.name == 'log-in' || toState.name == 'sign-up')) {
                    event.preventDefault();
                    $state.go('log-in');
                    //$rootScope.checkSession(fromState, toState);
                }
            });
        $rootScope.checkSession = function (fromState, toState) {
            var request = {
                method: 'POST',
                url: config.api,
                data: {
                    request: 'check_session',
                    data: {
                        session_id: $rootScope.session
                    }
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
        };
    });
