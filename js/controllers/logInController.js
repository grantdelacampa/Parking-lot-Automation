'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'logInController',
        function ($rootScope, $scope, $http) {
            $scope.logIn = function () {
                var request = {
                    method: 'POST',
                    url: config.api,
                    data: {
                        request: 'log_in',
                        data: {
                            'telephone': $scope.logIn.telephone,
                            'password': $scope.logIn.password
                        }
                    }
                };
                $http(request).then(
                    function (response) {
                        console.log(response);
                        if (response.data.type == 'success') {
                            $rootScope.session = response.data.session_id;
                        }
                    }, function (error) {
                        console.log(error);
                    }
                )
            };
        }
    );
