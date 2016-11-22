(function () {
    'use strict';
    angular
        .module(
            'parkingLotAutomationApp' // Name of the app
        )
        .controller(
            'statusController',
            function ($scope, $http) {
                $scope.checkStatus = function () {
                    var request = {
                        method: 'POST',
                        url: 'http://api.localhost/json/response.php',
                        data: {
                            request: 'check_status'
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
})();
