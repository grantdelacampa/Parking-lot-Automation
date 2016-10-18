(function () {
    'use strict';
    angular
        .module(
            'parkingLotAutomationApp' // Name of the app
        )
        .controller(
            'homeController',
            function ($scope) {

            }
        )
        .controller(
            'qrCodeController',
            function ($scope) {
                $scope.buildQRCode = function () {
                    var qrcode = new QRCode(document.getElementById('qr-code'), {
                        width : 100,
                        height : 100
                    });
                    qrcode.makeCode('2DE3FF482F');
                };

                $scope.buildQRCode();
            }
        );
})();
