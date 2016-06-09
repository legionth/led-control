angular.module('start', []).controller('startController', function($scope, $http) {
    
    $scope.load = function () {
    
    };
    $scope.load();

    $scope.save = function () {};
    
    $scope.activate = function () {
        $http.post('/api/led/activate/' + $scope.ledActivate).then(
            function successCallback(response) {
                $scope.$pending = false;
            }, function(e) {
                $scope.$pending = false;
                return $e.reject(e.data.message);
            });
    };
    
    $scope.deactivate = function () {
        $http.post('/api/led/deactivate/' + $scope.ledDeactivate).then(
            function successCallback(response) {
                $scope.$pending = false;
            }, function(e) {
                $scope.$pending = false;
                return $e.reject(e.data.message);
        });
    };
});
