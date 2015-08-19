application.directive('corlyTestCaseList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/testCaseList/template.html',
        controller: function ($scope, $stateParams, SubmissionService) {
            $scope.ShowColumn = [];
            $scope.HideCategory = [];
            $scope.Page = 1;
            $scope.Pages = 0;
            $scope.PendingChanges = false;
            $scope.FilterField = {};
            $scope.FullData = {};
            $scope.FilterList = [];
            $scope.Filter = [];
            $scope.FilteredData = {};

            // Generate range
            $scope.Range = function(from, to)   {
                var range = [];
                // Generate range
                for (var i = from; i <=  to; i++) {
                    range.push(i);
                };

                // Return result
                return range;
            }

            $scope.$watch('ListData', function (value) {
                if (!value || !value.ViewTypes)
                    return;

                $scope.View = value.ViewTypes[0];
            }, false);

            // Change page and load data
            $scope.ChangePage = function(page)  {
                // Do not load the same page as actual
                if (page == $scope.Page)
                    return;

                // Change page and get data
                $scope.ListData = GetCategoriesByPage($scope.FilteredData, page);
                $scope.Page = page;
                // $scope.FetchData();
            }

            SubmissionService.get({
                    ItemId: $stateParams.submissionId,
                    Type: "STATUSES",
                    Meta: $scope.ListData ? $scope.ListData.Page : 1
                })
            .success(function (data, status, headers, config) {
                $scope.Statuses = data.Data;
                console.log($scope.Filter);
            });

            var GetFilteredList = function (data)
            {
                var ret_data = $.extend(true, {}, data);
                var category_shift = 0;
                var isFilterCategory = !($scope.Filter.every(function(value, key, element) { if (value[0] == this[0]) { return false; } return true; } , ["@"]));
                var isFilterTestCase = !($scope.Filter.every(function(value, key, element) { if (value[0] == this[0]) { return false; } return true; } , ["#"]));
                var isFilterResult = !($scope.Filter.every(function(value, key, element) { if (value[0] == this[0]) { return false; } return true; } , ["$"]));

                for (var i = 0; i < data["Categories"].length; i++) {
                    var d = data["Categories"][i];
                    var tc_shift = 0;
                    for (var j = 0; j < d["TestCases"].length; j++) {
                        var r = d["TestCases"][j];
                        var res_shift = 0;
                        for (var g = 0; g < r["Results"].length; g++) {
                            var result = r["Results"][g];
                            if (isFilterResult && $scope.Filter.indexOf(result["Value"]) == -1 
                                && $scope.Filter.indexOf("$"+result["Key"]) == -1)
                            {
                                ret_data["Categories"][i-category_shift]
                                ["TestCases"][j-tc_shift]["Results"].splice(g-res_shift,1);
                                res_shift++;
                            }
                        };
                        if (ret_data["Categories"][i-category_shift]
                                ["TestCases"][j-tc_shift]["Results"].length == 0
                                || (isFilterTestCase && $scope.Filter.indexOf("#"+r["Name"]) == -1))
                        {
                            ret_data["Categories"][i-category_shift]
                                ["TestCases"].splice(j-tc_shift,1);
                                tc_shift++;
                                continue;
                        }
                    };
                    if ((isFilterCategory && $scope.Filter.indexOf("@"+d["Name"]) == -1) ||
                        (ret_data["Categories"][i-category_shift]
                                ["TestCases"].length == 0)) {
                        ret_data["Categories"].splice(i-category_shift,1);
                        category_shift++;
                        continue;
                    }
                };
                ret_data.ItemsCount = ret_data["Categories"].length;
                return ret_data;
            }
            var GetFilters = function (data) {
                var result = [];
                for (var i = 0; i < $scope.Statuses.length; i++)
                {
                    result.push({"show_name": $scope.Statuses[i], "hide_name": $scope.Statuses[i]});
                }
                for (var i = 0; i < data["Categories"].length; i++) {
                    result.push({"show_name": "Category: "+data["Categories"][i]["Name"], "hide_name": "@"+data["Categories"][i]["Name"]});
                    var d = data["Categories"][i];
                    var tc_shift = 0;
                    for (var j = 0; j < d["TestCases"].length; j++) {
                        var r = d["TestCases"][j];
                        result.push({"show_name": "TestCase: "+r["Name"], "hide_name": "#"+r["Name"]});
                        var res_shift = 0;
                        for (var g = 0; g < r["Results"].length; g++) {
                            var res = r["Results"][g];
                            result.push({"show_name": "Result: "+res["Key"], "hide_name": "$"+res["Key"]});
                        };
                    };
                };
                return result;
            }
            var GetCategoriesByPage = function (data, page) {
                var result = {};
                result["Categories"] = [];
                result["ViewTypes"] = data["ViewTypes"];
                result["ItemsCount"] = data["ItemsCount"];
                result["PageSize"] = data["PageSize"];
                result["Page"] = page;
                pageNumber = page;
                pageSize = data.PageSize;
                for (var i = (pageNumber-1)*pageSize; i < (pageNumber*pageSize); i++) {
                    if (i < data["Categories"].length)
                    {
                        result["Categories"].push(data["Categories"][i]);
                    }
                }
                return result;
            }
            // Load data
            $scope.FetchData = function () {
                $scope.PendingChanges = true;
                SubmissionService.get({
                    ItemId: $stateParams.submissionId,
                    Type: "LIST",
                    Filters: $scope.Filter,
                    Meta: $scope.ListData ? $scope.ListData.Page : 1
                })
                .success(function (data, status, headers, config) {
                    $scope.FullData = data.Data;
                    $scope.ListData = GetCategoriesByPage(data.Data, data.Data.Page);
                    $scope.FilteredData = $scope.FullData;
                    $scope.PendingChanges = false;
                    $scope.Page = $scope.ListData.Page ? $scope.ListData.Page : 1;
                    $scope.Pages = Math.ceil($scope.ListData.ItemsCount / $scope.ListData.PageSize);
                    $scope.FilterList = GetFilters($scope.FullData);
                });

            }

            $scope.FetchData();
            $scope.AddFilter = function (filter_text) {
                console.log(filter_text);
                if ($scope.Filter.indexOf(filter_text) == -1)
                {
                    // console.log(filter_text);
                    $scope.Filter.push(filter_text);
                    $scope.FilterField.value = "";
                    $scope.FilteredData = GetFilteredList($scope.FullData);
                    $scope.ListData = GetCategoriesByPage($scope.FilteredData, 1);
                    $scope.Page = 1;
                    $scope.Pages = Math.ceil($scope.ListData.ItemsCount / $scope.ListData.PageSize);
                    console.log($scope.ListData);
                }
            }
            $scope.KeyAddFilter = function (event) {
                if (event.keyCode == 13)
                {
                    var val = $scope.FilterField.value;
                    $scope.AddFilter(val);
                }
            }
            $scope.DeleteFilter = function (Filter) {
                $scope.Filter.splice($scope.Filter.indexOf(Filter.Filter),1);

                console.log($scope.Filter);

                // When no filter is set, show all
                if ($scope.Filter.length == 0)  {
                    $scope.ListData = $scope.FullData;
                    return;
                }

                $scope.ListData = GetFilteredList($scope.FullData);
                console.log(GetFilteredList($scope.FullData));
            }
        }
    }
});