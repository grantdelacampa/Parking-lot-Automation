'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'recordsController',
        function ($rootScope, $scope, $http) {
            $scope.getRecords = function () {
                var request = {
                    method: 'POST',
                    url: config.api,
                    data: {
                        request: 'get_records',
                        data: {
                            'qr_code': $rootScope.user.qr_code
                        }
                    }
                };
                $http(request).then(
                    function (response) {
                        console.log(response);
                        if (response.data.type == 'success') {
                            $scope.records = response.data.journal;
                        }
                    }, function (error) {
                        console.log(error);
                    }
                )
            };

            $scope.getRecords();
            $rootScope.checkParkingStatus();
        }
    );
