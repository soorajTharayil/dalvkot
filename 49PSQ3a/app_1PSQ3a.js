var app = angular.module('ehandorApp', []);
// adf 
app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location, $window) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.feedback = {};



	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step0 = false;
	$scope.step1 = true;
	$scope.step4 = false;

	var selectedMonths = $window.localStorage.getItem('selectedMonth');
	console.log(selectedMonths); // This will log "June"
	var selectedYears = $window.localStorage.getItem('selectedYear');
	console.log(selectedYears); // This will log "2024"

	$scope.selectedMonths = $window.localStorage.getItem('selectedMonth');
	$scope.selectedYears = $window.localStorage.getItem('selectedYear');


	$rootScope.language = function (type) {
		$scope.typel = type;
		if (type == 'english') {
			$http.get('language/english.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;
				$scope.type2 = 'English'
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
		$scope.feedback.langsub = type;


	}
	$scope.language('english');
	window.setTimeout(function () {
		$(window).scrollTop(0);
	}, 0);

	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/api_50PSQ3a.php?patientid=' + id + '&month=' + selectedMonths + '&year=' + selectedYears, { timeout: 20000 }).then(function (responsedata) {
			$scope.feedback.initial_assessment_hr = responsedata.data.totalHours;
			$scope.feedback.initial_assessment_min = responsedata.data.totalMinutes;
			$scope.feedback.initial_assessment_sec = responsedata.data.totalSeconds;
			$scope.feedback.total_admission = responsedata.data.totalAdmission;
			console.log($scope.feedback.initial_assessment_hr);

		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}
	$scope.setupapplication();

	var ehandor = JSON.parse($window.localStorage.getItem('ehandor'));
	if (ehandor) {
		// Assign the data to scope variables
		$scope.loginemail = ehandor.email;
		$scope.loginid = ehandor.empid;
		$scope.loginname = ehandor.name;
		$scope.loginnumber = ehandor.mobile;



		console.log($scope.loginemail);
		console.log($scope.loginid);
		console.log($scope.loginname);
		console.log($scope.loginnumber);
		// Similarly, assign other properties as needed
	} else {
		// Handle if data doesn't exist
		console.log('Data not found in local storage');
	}

	//Calculate function for initail assessment

	$scope.calculateTimeFormat = function () {
		// console.log($scope.feedback.initial_assessment_hr)
		// console.log($scope.feedback.initial_assessment_min)
		// console.log($scope.feedback.initial_assessment_sec)
		// Concatenate the values with colons to form the desired format

		$scope.feedback.initial_assessment_total =
			($scope.feedback.initial_assessment_hr || 0) + ":" +
			($scope.feedback.initial_assessment_min || 0) + ":" +
			($scope.feedback.initial_assessment_sec || 0);


		console.log($scope.feedback.initial_assessment_total);		// Get values for hours, minutes, and seconds from user input
		console.log($scope.feedback.total_admission);

		var hoursInput = parseInt(document.getElementById('formula_para1_hr').value || 0);
		var minutesInput = parseInt(document.getElementById('formula_para1_min').value || 0);
		var secondsInput = parseInt(document.getElementById('formula_para1_sec').value || 0);

		// Convert into total seconds
		var assessmentSeconds = (hoursInput * 3600) + (minutesInput * 60) + secondsInput;

		// Get total admission
		var totalAdmissions = parseInt(document.getElementById('formula_para2').value);

		// Validate the total admissions value
		if (isNaN(totalAdmissions) || totalAdmissions <= 0) {
			alert("Please enter the above value to calculate");
			return;
		}

		var averageSeconds = Math.floor(assessmentSeconds / totalAdmissions);

		// Convert the average back to hours, minutes, and seconds
		var avgHours = Math.floor(averageSeconds / 3600);
		var remainingSeconds = averageSeconds % 3600;

		var avgMinutes = Math.floor(remainingSeconds / 60);
		var avgSeconds = Math.floor(remainingSeconds % 60);

		// Format the result to "hr:min:sec"
		$scope.calculatedResult = `${avgHours}:${('0' + avgMinutes).slice(-2)}:${('0' + avgSeconds).slice(-2)}`;

		$scope.feedback.calculatedResult = $scope.calculatedResult
		console.log($scope.feedback.calculatedResult)

	};


	$scope.currentMonthYear = getCurrentMonthYear();

	$scope.months = [
		"January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"
	];

	$scope.years = [
		new Date().getFullYear() - 1,
		new Date().getFullYear(),
		new Date().getFullYear() + 1
	];

	$scope.selectedMonth = $scope.months[new Date().getMonth()];
	$scope.selectedYear = $scope.years[1];

	$scope.fetchData = function () {
		var month = $scope.months.indexOf($scope.selectedMonth) + 1;
		var year = $scope.selectedYear;

		$http({
			method: 'POST',
			url: 'api_1PSQ3a.php',
			data: {
				month: month,
				year: year
			}
		}).then(function (response) {
			$scope.data = response.data;
		}, function (error) {
			console.error('Error fetching data:', error);
		});
	};




	// Navigate to a specific page
	$scope.prev = function () {

		window.location.href = '/qim_forms/?src=Link';
	};


	//color for time based on comparision
	const benchmark = (4 * 3600);
	function convertToSeconds(timeStr) {
		const [hours, minutes, seconds] = timeStr.split(':').map(Number);
		return (hours * 3600) + (minutes * 60) + seconds;
	}

	$scope.getTextColor = function () {
		const calculatedSeconds = convertToSeconds($scope.calculatedResult);
		return calculatedSeconds <= benchmark ? 'green' : 'red';
	};




	// re-size of textarea based on long text
	function autoResizeTextArea(textarea) {
		// Reset height to auto to allow expansion
		textarea.style.height = 'auto';

		// Set the height to the scrollHeight to auto-resize
		textarea.style.height = textarea.scrollHeight + 'px';
	}





	var d = new Date();
	$scope.feedback.datetime = d.getTime();
	var params = new URLSearchParams(window.location.search);
	var srcValue = params.get('src');
	$scope.savefeedback = function () {

		if (!$scope.selectedMonths || !$scope.selectedYears) {
			alert("Please choose the month and year before submitting.");
			return;
		}



		if ($scope.feedback.dataAnalysis == '' || $scope.feedback.dataAnalysis == undefined) {
			alert('Please enter data analysis');
			return false;
		}

		if ($scope.feedback.correctiveAction == '' || $scope.feedback.correctiveAction == undefined) {
			alert('Please enter corrective action');
			return false;
		}

		if ($scope.feedback.preventiveAction == '' || $scope.feedback.preventiveAction == undefined) {
			alert('Please enter preventive action');
			return false;
		}

		$rootScope.loader = true;
		$scope.feedback.benchmark = '04:00:00';
		$scope.feedback.name = $scope.loginname;
		$scope.feedback.patientid = $scope.loginid;
		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_kpi50.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId + '&month=' + selectedMonths + '&year=' + selectedYears, $scope.feedback)
			.then(function (responsedata) {

				if (responsedata.status = "success") {
					$rootScope.loader = false;
					// navigator.showToast('Patient Feedback Submitted Successfully');
					//$location.path('/thankyou');
					$scope.step1 = false;
					$scope.step4 = true;
					$(window).scrollTop(0);
				}
				else {
					alert("Feeback already submitted for this patient!!")
				}


			}, function myError(response) {
				$rootScope.loader = false;

				alert("Please check your internet and try again!!")
			});


	}


})

