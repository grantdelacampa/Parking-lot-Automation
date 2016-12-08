'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'statusController',
        function ($rootScope, $scope, $http, $interval) {

            var timeStamp = '',
                JSTimeStamp = [],
                timer = undefined;

            $scope.clock = '';

            $scope.checkParkingStatus = function () {
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

                            timeStamp = $rootScope.user.parkingInfo.date.split(/[- :]/);
                            JSTimeStamp = new Date(timeStamp[0], timeStamp[1] - 1, timeStamp[2], timeStamp[3], timeStamp[4], timeStamp[5]);
                            $scope.clock = Date.now() - JSTimeStamp.getTime();
                            $scope.tick();
                            $interval($scope.tick, 1000);
                        }
                        else {
                            $rootScope.user.parkingInfo = null;
                        }
                    }, function (error) {
                        console.log(error);
                    }
                )
            };

            $scope.tick = function () {
                $scope.clock += 1000;
            };

            $scope.startTimer = function () {
                if (!angular.isDefined(timer))
                    timer = $interval(function () {
                        $rootScope.checkParkingStatus();
                    }, 5000);
            };

            $scope.$on('$destroy', function(){
                $interval.cancel(timer);
                timer = undefined;
            });

            $scope.checkParkingStatus();
            $scope.startTimer();
        }
    );
