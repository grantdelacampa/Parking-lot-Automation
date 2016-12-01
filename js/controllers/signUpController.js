'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'signUpController',
        function ($scope, $http, $state, $rootScope) {
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
                //if the login is successful then being the login
                $http(request).then(
                    function (response) {
                        console.log(response);
                        //create the login request
                        var request ={
                            method: 'POST',
                            url: config.api,
                            data: {
                                request: 'log_in',
                                //data from the signUp form used to login
                                data: {
                                    'telephone': $scope.newUser.telephone,
                                    'password': $scope.newUser.password
                                }
                            }
                        };
                        //nested $http(request) to check for login success
                        $http(request).then(
                            function (response){
                                console.log(response);
                                if (response.data.type == 'success') {
                                    $rootScope.session = response.data.session_id;
                                    $rootScope.user = response.data.user;
                                    $state.go('qr-code');
                                }
                            },
                            function (error){
                                console.log(error);
                            }

                        );

                        //$state.go('log-in');
                    }, function (error) {
                        console.log(error);
                    }
                )
            };
        }
    );
