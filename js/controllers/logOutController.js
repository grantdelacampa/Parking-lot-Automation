'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'logOutController',
        function ($rootScope, $scope, $http, $state) {
            $scope.logOut = function () {
                var request = {
                    method: 'POST',
                    url: config.api,
                    data: {
                        request: 'log_out',
                        data: {
                            session_id: $rootScope.session
                        }
                    }
                };
                $http(request).then(
                    function (response) {
                        console.log(response);
                        if (response.data.type == 'success') {
                            $rootScope.session = null;
                            $state.go('log-in');
                        }
                    }, function (error) {
                        console.log(error);
                    }
                )
            };
        }
    );
