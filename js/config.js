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
                                    controller: 'signUpController'
                                }
                            }
                        }
                    )
                    .state(
                        'log-in',
                        {
                            url: '/log-in',
                            views: {
                                'main': {
                                    templateUrl: 'pages/log-in.html',
                                    controller: 'logInController'
                                }
                            }
                        }
                    )
                    .state(
                        'log-out',
                        {
                            url: '/log-out',
                            views: {
                                'main': {
                                    templateUrl: 'pages/log-out.html',
                                    controller: 'logOutController'
                                }
                            }
                        }
                    )
                    .state(
                        'connected-card',
                        {
                            url: '/connected-card',
                            views: {
                                'main': {
                                    templateUrl: 'pages/connected-card.html',
                                    controller: 'homeController'
                                }
                            }
                        }
                    )
                    .state(
                        'qr-code',
                        {
                            url: '/qr-code',
                            views: {
                                'main': {
                                    templateUrl: 'pages/qr-code.html',
                                    controller: 'qrCodeController'
                                }
                            }
                        }
                    )
                    .state(
                        'records',
                        {
                            url: '/records',
                            views: {
                                'main': {
                                    templateUrl: 'pages/records.html',
                                    controller: 'homeController'
                                }
                            }
                        }
                    )
                    .state(
                        'status',
                        {
                            url: '/status',
                            views: {
                                'main': {
                                    templateUrl: 'pages/status.html',
                                    controller: 'homeController'
                                }
                            }
                        }
                    );
                $urlRouterProvider.otherwise('/');
            }
        );
})();
