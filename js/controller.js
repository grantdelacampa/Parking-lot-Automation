(function () {
    'use strict';
    angular
        .module(
            'parkingLotAutomationApp' // Name of the app
        )
        .controller(
            'homeController',
            function ($scope, $http) {
                $scope.addUser = function () {
                    var request = {
                        method: 'POST',
                        url: 'http://api.localhost/json/response.php',
                        data: {
                            request: 'add_user',
                            data: {
                                'name': 'testName',
                                'tel': '123123123'
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
                $scope.addUser();
            }
        )
        .controller(
            'qrCodeController',
            function ($scope) {
                $scope.buildQRCode = function () {
                    var qrcode = new QRCode(document.getElementById('qr-code'), {
                        width: 100,
                        height: 100
                    });
                    qrcode.makeCode('2DE3FF482F');
                };

                $scope.buildQRCode();
            }
        );
})();
