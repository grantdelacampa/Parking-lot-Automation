(function () {
    'use strict';
    angular
        .module(
            'parkingLotAutomationApp' // Name of the app
        )
        .directive(
            'plaNav',
            function () {
                return {
                    restrict: 'E', // Look for element
                    templateUrl: '../templates/pla-nav.html'
                }
            }
        );
})();
