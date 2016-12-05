var app = angular.module('plunker', ['nvd3', "firebase"]);

app.controller('MainCtrl', function($scope, $firebaseArray, $http) {
    $scope.options = {
        chart: {
            type: 'pieChart',
            height: 500,
            x: function(d){return d.company;},
            y: function(d){return d.share;},
            showLabels: true,
            duration: 500,
            labelThreshold: 0.01,
            labelSunbeamLayout: true,
            legend: {
                margin: {
                    top: 5,
                    right: 35,
                    bottom: 5,
                    left: 0
                }
            }
        }
    };
    //    $scope.ref = new Firebase("https://dazzling-heat-1553.firebaseio.com/market-share");
    //    $scope.data = $firebaseArray($scope.ref);
    $http.get("/slim/api/market_share")
        .then(function(response) {
        $scope.data = response.data;
    });

});