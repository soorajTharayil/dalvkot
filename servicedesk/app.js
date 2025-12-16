var app = angular.module('ehandorApp', []);

app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $window) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.loginvar = {};
	$scope.loginvar.userid = '';
	$scope.loginvar.password = '';
	$scope.feedback = {};
	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$scope.step0 = true;
	$scope.step1 = false;
	if(localStorage.getItem("ehandor")){
        $rootScope.profilen = JSON.parse(localStorage.getItem('ehandor'));
        // console.log($rootScope.profilen);
    }
	$rootScope.baseurl_main = window.location.origin + '/api';
	


	$scope.login = function () {
		/*var intstatus = $rootScope.internetcheck();
		if (intstatus == false) {
			return false;
		}*/
		$rootScope.loader = true;

		$http.post($rootScope.baseurl_main + '/login.php', $scope.loginvar, { timeout: 20000 }).then(function (responsedata) {
		console.log(responsedata);
			if (responsedata.status == 200) {
				var response = responsedata.data;
				$rootScope.loader = false;
				$rootScope.profilen = response;
				$rootScope.adminId = $rootScope.profilen.userid;
				$scope.profiled = $rootScope.profilen;
				localStorage.setItem("ehandor", JSON.stringify(response));
				if (response.status === 'fail') {
					$scope.loginerror = response.message;
				} else if (response.status === 'success') {
					$rootScope.loginactive = true;
					$scope.step0 = false;
					$scope.step1 = true;
					// $window.location.href = 'http://demo30.efeedor.com/all_button';


				}
			} else {
				$scope.loginerror = 'Some error happend';
				$rootScope.loader = false;
			}
		}, function errorCallback(responsedata) {
			if (localStorage.getItem('cordinator')) {
				$scope.cordinatorlist = JSON.parse(localStorage.getItem('cordinator'));
				if ($scope.cordinatorlist) {
					if ($scope.cordinatorlist.cordinators) {
						if ($scope.cordinatorlist.cordinators.length > 0) {

							angular.forEach($scope.cordinatorlist.cordinators, function (value, key) {
								console.log(value);
								//alert(value.guid);
								if ((value.guid.toLowerCase() == $scope.loginvar.userid.toLowerCase() && value.password == $scope.loginvar.password)) {
									//	alert(2);
									value.userid = $scope.loginvar.userid;
									$rootScope.profilen = value;
									$rootScope.adminId = $rootScope.profilen.userid;
									$scope.profiled = $rootScope.profilen;
									localStorage.setItem("ehandor", JSON.stringify(value));
									$rootScope.loginactive = true;
									$scope.step0 = false;
									$scope.step1 = true;
									// $window.location.href = 'http://demo30.efeedor.com/all_button';

								}
							});
						}
					}
				}
			} else {
				$scope.loginerror = 'Internet Connection error';
			}
			$rootScope.loader = false;
		});
	}

	$rootScope.language = function (type) {
		$scope.typel = type;
		if (type == 'english') {
			$http.get('language/english.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;
				$scope.type2 = 'English';

			});
		}
		if (type == 'lang2') {
			$http.get('language/lang2.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;
				$scope.type2 = 'ಕನ್ನಡ';


			});
		}
		if (type == 'lang3') {
			$http.get('language/lang3.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;
				$scope.type2 = 'മലയാളം';
				//	$scope.type2 = 'தமிழ்';



			});
		}
	}
	$scope.language('english');

	$scope.setupapplication = function () {

		var url = window.location.href;

		var id = url.substring(url.lastIndexOf('=') + 1);

		$http.get($rootScope.baseurl_main + '/ward.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.wardlist = responsedata.data;
			$scope.questioset = responsedata.data.question_set;
			$scope.setting_data = responsedata.data.setting_data;
			console.log($scope.feedback);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}
	$scope.setupapplication();
});