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

	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/api_30PSQ3d.php?patientid=' + id + '&month=' + selectedMonths + '&year=' + selectedYears, { timeout: 20000 }).then(function (responsedata) {
			$scope.feedback.initial_assessment_hr = responsedata.data.errors_count;
			//$scope.feedback.total_admission = responsedata.data.incident_count;

			// Logging one of the variables to console for verification
			console.log($scope.feedback.staff_audited_count);

		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}
	$scope.setupapplication();


	$scope.valuesEdited = false;  // Flag to track if values have been edited

	// Function to call when values are edited
	$scope.onValuesEdited = function () {
		$scope.valuesEdited = true;
	};

	document.getElementById('formula_para1').addEventListener('input', $scope.onValuesEdited);
	document.getElementById('formula_para2').addEventListener('input', $scope.onValuesEdited);



	//Calculate  function
	$scope.calculateNeedleStickInjuryRate = function () {
		// Get the number of parenteral exposures
		var parenteralExposures = parseInt(document.getElementById('formula_para1').value);

		// Get the number of in-patient days
		var inpatientDays = parseInt(document.getElementById('formula_para2').value);

		// Validate inputs for parenteralExposures and inpatientDays
		if (isNaN(parenteralExposures) || parenteralExposures < 0) {
			alert("Enter the number of parenteral exposures.");
			return;
		}

		if (isNaN(inpatientDays) || inpatientDays < 0) {
			alert("Enter the number of in-patient days.");
			return;
		}

		if (parenteralExposures > inpatientDays) {
			alert("The no. of parenteral exposures must be less than the number of in-patient days.");
			return;
		}

		if (parenteralExposures === 0 && inpatientDays === 0) {
			$scope.calculatedResult = 0;
		} else {
			// Calculate the incidence of needle stick injuries per 1000 in-patient days
			$scope.calculatedResult = ((parenteralExposures / inpatientDays) * 1000).toFixed(2);
		}

		// Store the result in the feedback object for further use
		$scope.feedback.calculatedResult = $scope.calculatedResult;

		console.log("Calculated Needle Stick Injury Rate", $scope.calculatedResult);
		$scope.valuesEdited = false;
	};






	$scope.currentMonthYear = getCurrentMonthYear();


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

		if ($scope.valuesEdited) {
			alert('Please calculate before submitting the form.');
			return false;
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

		// First check for duplicates
		$http.get($rootScope.baseurl_main + '/quality_duplication_submission.php?patient_id=' + $rootScope.patientid + '&month=' + $scope.selectedMonths + '&year=' + $scope.selectedYears + '&table=' + 'bf_feedback_30PSQ3d')
			.then(function (response) {
				if (response.data.status === "exists") {
					alert("The KPI is already recorded for this month");
					return;
				} else {

					$rootScope.loader = true;
					$scope.feedback.benchmark = '04:00:00';
					$scope.feedback.name = $scope.loginname;
					$scope.feedback.patientid = $scope.loginid;
					$scope.feedback.contactnumber = $scope.loginnumber;
					$scope.feedback.email = $scope.loginemail;


					// $scope.feedback.questioset = $scope.questioset;
					$http.post($rootScope.baseurl_main + '/savepatientfeedback_kpi30.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId + '&month=' + selectedMonths + '&year=' + selectedYears, $scope.feedback).then(function (responsedata) {
						if (responsedata.status = "success") {
							$rootScope.loader = false;
							// navigator.showToast('Patient Feedback Submitted Successfully');
							//$location.path('/thankyou');
							$scope.step1 = false;
							$scope.step4 = true;
							$(window).scrollTop(0);
						} else {
							alert("Feeback already submitted for this patient!!")
						}
					}, function myError(response) {
						$rootScope.loader = false;
						alert("Please check your internet and try again!!")
					});
				}
			}, function (error) {
				alert("Error while checking existing KPI");
			});
	}



})

