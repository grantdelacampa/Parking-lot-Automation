'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'qrCodeController',
        function ($rootScope, $scope, $http) {
            $scope.buildQRCode = function () {
                var qrcode = new QRCode(document.getElementById('qr-code'), {
                    width: 100,
                    height: 100
                });
                qrcode.makeCode($rootScope.user.qr_code);
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
                    }, function (error) {
                        console.log(error);
                    }
                )
            };

            $scope.buildQRCode();
        }
    );
