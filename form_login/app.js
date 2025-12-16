var app = angular.module('ehandorApp', []);

app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $window, $timeout) {
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
	if (localStorage.getItem("ehandor")) {
		$rootScope.profilen = JSON.parse(localStorage.getItem('ehandor'));
		// console.log($rootScope.profilen);

	}

	$rootScope.baseurl_main = window.location.origin + '/api';




	$scope.login = function () {
	$rootScope.loader = true;

	$http.post($rootScope.baseurl_main + '/login.php', $scope.loginvar, { timeout: 20000 }).then(function (responsedata) {
		console.log(responsedata);
		if (responsedata.status == 200) {
			var response = responsedata.data;
			$rootScope.loader = false;
			$rootScope.profilen = response;

			$rootScope.adminId = $rootScope.profilen.userid;

			if (!$rootScope.$$phase) {
				$rootScope.$apply();
			}

			$scope.profiled = $rootScope.profilen;
			localStorage.setItem("ehandor", JSON.stringify(response));
			if (response.status === 'fail') {
				$scope.loginerror = response.message;
			} else if (response.status === 'success') {
				$rootScope.loginactive = true;
				$scope.step0 = false;
				$scope.step1 = true;
			}
		} else {
			$scope.loginerror = 'Some error happened';
			$rootScope.loader = false;
		}
	}, function errorCallback(responsedata) {
		if (localStorage.getItem('cordinator')) {
			$scope.cordinatorlist = JSON.parse(localStorage.getItem('cordinator'));
			if ($scope.cordinatorlist) {
				if ($scope.cordinatorlist.cordinators) {
					if ($scope.cordinatorlist.cordinators.length > 0) {
						angular.forEach($scope.cordinatorlist.cordinators, function (value, key) {
							if ((value.guid.toLowerCase() == $scope.loginvar.userid.toLowerCase() && value.password == $scope.loginvar.password)) {
								value.userid = $scope.loginvar.userid;
								$rootScope.profilen = value;
								$rootScope.adminId = $rootScope.profilen.userid;
								$scope.profiled = $rootScope.profilen;
								localStorage.setItem("ehandor", JSON.stringify(value));
								$rootScope.loginactive = true;
								$scope.step0 = false;
								$scope.step1 = true;
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
};
	$scope.menuVisible = false;
	$scope.aboutVisible = false;

	// Function to hide menu only when clicking "Home"
	$scope.hideMenu = function () {
		$scope.menuVisible = false;
	};

	// Function to show all content
	$scope.showAllContent = function () {
		$scope.aboutVisible = false;
		$scope.supportVisible = false;
		$scope.appDownloadVisible = false;
		$scope.dashboardVisible = false;
		$scope.menuVisible = true;
		$scope.hideMenu();
	};


	// Function to show the 'About' content
	$scope.showAbout = function () {
		$scope.menuVisible = false;
		$scope.supportVisible = false;
		$scope.appDownloadVisible = false;
		$scope.dashboardVisible = false;
		$scope.aboutVisible = true;
	};

	// Function to show the 'Support' content
	$scope.showSupport = function () {
		$scope.menuVisible = false;
		$scope.aboutVisible = false;
		$scope.appDownloadVisible = false;
		$scope.dashboardVisible = false;
		$scope.supportVisible = true;
	};

	// Function to show the 'Web dashboard' content
	$scope.showDashboard = function () {
		$scope.menuVisible = false;
		$scope.aboutVisible = false;
		$scope.appDownloadVisible = false;
		$scope.supportVisible = false;
		$scope.dashboardVisible = true;

	};

	// Function to show the 'App download' content
	$scope.showAppDown = function () {
		$scope.menuVisible = false;
		$scope.aboutVisible = false;
		$scope.supportVisible = false;
		$scope.dashboardVisible = false;
		$scope.appDownloadVisible = true;
	};


	// To downlaod the apk
	$scope.downloadApk = function () {
		if ($scope.setting_data && $scope.setting_data.android_apk) {
			window.location.href = $scope.setting_data.android_apk;
		} else {
			alert("APK download link is not available.");
		}
	};

	// $scope.redirectToUserActivity = function (event) {
	// 	event.preventDefault();
	// 	window.location.href = "/login/?userid=" + $scope.adminId + "&redirectType=userActivity";
	// };
	

	$scope.closeMenuOnClickOutside = function (event) {
		if ($scope.menuVisible && !event.target.closest('.menu-dropdown') && !event.target.closest('.menu-toggle')) {
			$scope.menuVisible = false;
			$scope.$apply(); // Ensure Angular updates the UI
		}
	};

	// Attach event listener when step1 is active
	$scope.$watch('step1', function (newVal) {
		if (newVal) {
			document.addEventListener('click', $scope.closeMenuOnClickOutside);
		} else {
			document.removeEventListener('click', $scope.closeMenuOnClickOutside);
		}
	});






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
			//$scope.user = responsedata.data.user;
			console.log($scope.feedback);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}
	$scope.setupapplication();
});
