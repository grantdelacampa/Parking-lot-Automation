(function () {
    'use strict';
    angular
        .module(
            'parkingLotAutomationApp' // Name of the app
        )
        .config(
            function ($stateProvider, $urlRouterProvider, $locationProvider) {
                $locationProvider.html5Mode(true).hashPrefix('!');
                $stateProvider
                    .state(
                        'home',
                        {
                            url: '/',
                            views: {
                                'main': {
                                    templateUrl: 'pages/sign-up.html',
                                    controller: 'homeController'
                                }
                            }
                        }
                    )
                    .state(
                        'sign-up',
                        {
                            url: '/sign-up',
                            views: {
                                'main': {
                                    templateUrl: 'pages/sign-up.html',
                                    controller: 'homeController'
                                }
                            }
                        }
                    );
                $urlRouterProvider.otherwise('/');
            }
        );
})();
