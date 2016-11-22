'use strict';
angular
    .module(
        'parkingLotAutomationApp' // Name of the app
    )
    .controller(
        'qrCodeController',
        function ($rootScope, $scope) {
            $scope.buildQRCode = function () {
                var qrcode = new QRCode(document.getElementById('qr-code'), {
                    width: 100,
                    height: 100
                });
                qrcode.makeCode($rootScope.qrCode);
            };

            $scope.buildQRCode();
        }
    );
