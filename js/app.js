'use strict';
var config = {
    api: 'http://csc131.slavikf.com/api/json/response.php'
};
angular
    .module(
        'parkingLotAutomationApp', // Name of the app
        [ // Dependencies
            'ui.router',
            'ngCookies'
        ]
    )
    .config(function ($httpProvider) {
        //Reset headers to avoid OPTIONS request (aka preflight)
        $httpProvider.defaults.headers.common = {};
        $httpProvider.defaults.headers.post = {};
        $httpProvider.defaults.headers.put = {};
        $httpProvider.defaults.headers.patch = {};
    })
    .run(function ($rootScope, $state, $http, $cookies) {
        $rootScope.session = null; // On load init this to null
        $rootScope.user = null;
        if($cookies.get('sessionID')){
            $rootScope.session = $cookies.get('sessionID');
            $rootScope.user = $cookies.getObject('user');
        }
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
                    console.log(response.data);
                }, function (error) {
                    console.log(error);
                }
            );
        };

        $rootScope.checkParkingStatus = function (isRedirectNeeded) {
            var request = {
                method: 'POST',
                url: config.api,
                data: {
                    request: 'check_parking_status',
                    data: {
                        'qr_code': $rootScope.user.qr_code
                    }
                }
            };
            $http(request).then(
                function (response) {
                    console.log(response);
                    if (response.data.parking_info) {
                        $rootScope.user.parkingInfo = response.data.parking_info;
                        $rootScope.user.parkingInfo.date = response.data.parking_info.ts_start;
                        $state.go('status');
                    }
                    else {
                        $rootScope.user.parkingInfo = null;
                    }
                }, function (error) {
                    console.log(error);
                }
            )
        };

    })
    .filter('millisecondsToTime', function () {
        return function (milliseconds) {
            var time = milliseconds / 1000,
                sec_num = parseInt(time, 10),
                hours = Math.floor(sec_num / 3600),
                minutes = Math.floor((sec_num - (hours * 3600)) / 60),
                seconds = sec_num - (hours * 3600) - (minutes * 60);

            if (hours < 10)
                hours = '0' + hours;
            if (minutes < 10)
                minutes = '0' + minutes;
            if (seconds < 10)
                seconds = '0' + seconds;

            return hours + ':' + minutes + ':' + seconds;
        }
    });

