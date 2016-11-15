(function () {
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
                        url: 'http://api.localhost/json/response.php',
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
                                $rootScope.session = response.data.session;
                            }
                        }, function (error) {
                            console.log(error);
                        }
                    )
                };
            }
        );
})();
