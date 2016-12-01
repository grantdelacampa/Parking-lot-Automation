(function () {
    'use strict';
    angular
        .module(
            'parkingLotAutomationApp' // Name of the app
        )
        .controller(
            'statusController',
            function ($rootScope, $scope, $http, $interval) {
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
                var timeStamp = $rootScope.user.parkingInfo.date.split(/[- :]/),
                    JSTimeStamp = new Date(timeStamp[0], timeStamp[1]-1, timeStamp[2], timeStamp[3], timeStamp[4], timeStamp[5]);

                $scope.clock = Date.now() - JSTimeStamp.getTime();
                $scope.tick = function() {
                    $scope.clock += 1000;
                };
                $scope.tick();
                $interval($scope.tick, 1000);
            }
        );
})();
