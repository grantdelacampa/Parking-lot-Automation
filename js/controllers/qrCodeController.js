'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'qrCodeController',
        function ($rootScope, $scope, $http, $state) {
            $scope.buildQRCode = function () {
                var qrcode = new QRCode(document.getElementById('qr-code'), {
                    width: 250,
                    height: 250
                });
                qrcode.makeCode('http://csc131.slavikf.com/api/json/qr-hit.php?qr_code=' + $rootScope.user.qr_code);
            };
            $scope.clickQRCode = function () {
                var request = {
                    method: 'POST',
                    url: config.api,
                    data: {
                        request: 'click_qr_code',
                        data: {
                            'session': $rootScope.session,
                            'qr_code': $rootScope.user.qr_code
                        }
                    }
                };
                $http(request).then(
                    function (response) {
                        console.log(response);
                        if (response.data.do == 'opt-in') {
                            $rootScope.user.parkingInfo = response.data.parking_info;
                            $rootScope.user.parkingInfo.date = response.data.ts;
                            $state.go('status');
                        }
                        if (response.data.do == 'opt-out') {
                            $rootScope.user.parkingInfo = null;
                            $state.go('records');
                        }
                    }, function (error) {
                        console.log(error);
                    }
                )
            };

            $scope.buildQRCode();
        }
    );
