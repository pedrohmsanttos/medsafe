'use strict';

var appM = angular.module('MedSafer', [
    'ngCart'
])

appM.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('%%');
  $interpolateProvider.endSymbol('%%');
})
