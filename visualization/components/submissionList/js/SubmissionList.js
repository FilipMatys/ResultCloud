application.directive('corlySubmissionList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/submissionList/list.html',
        scope:  {
            Data: '=data'
        },
        controller: function ($scope) {

        }
    }
});