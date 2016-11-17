'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'signUpController',
        function ($scope, $http) {
            $scope.signUp = function () {
                var request = {
                    method: 'POST',
                    url: config.api,
                    data: {
                        request: 'add_user',
                        data: {
                            'email': $scope.newUser.email,
                            'fullName': $scope.newUser.fullName,
                            'telephone': $scope.newUser.telephone,
                            'password': $scope.newUser.password
                        }
                    }
                };
                $http(request).then(
                    function (response) {
                        console.log(response);
                    }, function (error) {
                        console.log(error);
                    }
                )
            };
        }
    );
