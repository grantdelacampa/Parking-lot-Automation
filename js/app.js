(function () {
    'use strict';
    angular
        .module(
            'parkingLotAutomationApp', // Name of the app
            [ // Dependencies
                'ui.router'
            ]
        )
        .config(function ($httpProvider) {
            //Reset headers to avoid OPTIONS request (aka preflight)
            $httpProvider.defaults.headers.common = {};
            $httpProvider.defaults.headers.post = {};
            $httpProvider.defaults.headers.put = {};
            $httpProvider.defaults.headers.patch = {};
        });
})();
