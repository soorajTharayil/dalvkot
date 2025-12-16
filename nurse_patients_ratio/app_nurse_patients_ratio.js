var app = angular.module('ehandorApp', []);
// adf 
app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location, $window) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.feedback = {};



	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step0 = true;
	$scope.step1 = false;
	$scope.step4 = false;


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
	$scope.next1 = function () {

		$scope.step0 = false;
		$scope.step1 = true;
		$(window).scrollTop(0);

	}

	$scope.$watch('feedback.site', function(newVal, oldVal) {
		if (newVal !== oldVal) {
			if (newVal === 'ICU') {
				$scope.feedback.ward = ''; 
			} else if (newVal === 'Ward') {
				$scope.feedback.icu = ''; 
				$scope.feedback.department = ''; 
			}
		}
	});
	

	$scope.feedback = {
        site: 'ICU',
        ward: 'Select Ward',
        icu: 'Select ICU',
        department: 'Select Patient Status'
    };


	$scope.resetSelection = function() {
		// Reset ward, ICU, and department selections when site changes
		$scope.feedback.ward = 'Select Ward';
		$scope.feedback.icu = 'Select ICU';
		$scope.feedback.department = 'Select Patient Status';
	  };
	  




	//Calculate function for initail assessment

	$scope.calculateTimeFormat = function () {

		function convertToTotalSeconds(hours, minutes, seconds, isPm) {
			if (isPm && hours < 12) {
				hours += 12; // Convert PM to 24-hour format
			}
			return (hours * 3600) + (minutes * 60) + seconds;
		}
		$scope.feedback.patient_got_admitted =
			($scope.feedback.initial_assessment_hr1 || 0) + ":" +
			($scope.feedback.initial_assessment_min1 || 0) + ":" +
			($scope.feedback.initial_assessment_sec1 || 0);

		$scope.feedback.doctor_completed_assessment =
			($scope.feedback.initial_assessment_hr2 || 0) + ":" +
			($scope.feedback.initial_assessment_min2 || 0) + ":" +
			($scope.feedback.initial_assessment_sec2 || 0);

		// Get admission time
		var admissionHours = parseInt(document.getElementById('formula_para1_hr').value || 0);
		var admissionMinutes = parseInt(document.getElementById('formula_para1_min').value || 0);
		var admissionSeconds = parseInt(document.getElementById('formula_para1_sec').value || 0);

		// Get assessment completion time
		var assessmentHours = parseInt(document.getElementById('formula_para2_hr').value || 0);
		var assessmentMinutes = parseInt(document.getElementById('formula_para2_min').value || 0);
		var assessmentSeconds = parseInt(document.getElementById('formula_para2_sec').value || 0);

		// Convert times to total seconds for easier comparison
		var totalAdmissionSeconds = convertToTotalSeconds(admissionHours, admissionMinutes, admissionSeconds);
		var totalAssessmentSeconds = convertToTotalSeconds(assessmentHours, assessmentMinutes, assessmentSeconds);

		console.log(totalAdmissionSeconds);
		console.log(totalAssessmentSeconds);

		if (totalAssessmentSeconds < totalAdmissionSeconds) {
			totalAssessmentSeconds += 86400; // 24 hours in seconds
		}

		// Calculate the difference in seconds
		var differenceInSeconds = totalAssessmentSeconds - totalAdmissionSeconds;


		// Convert the difference back to hours, minutes, and seconds
		var diffHours = Math.floor(differenceInSeconds / 3600);
		var remainingSeconds = differenceInSeconds % 3600;

		var diffMinutes = Math.floor(remainingSeconds / 60);
		var diffSeconds = remainingSeconds % 60;

		// Format the result to "hr:min:sec"
		$scope.calculatedResult = `${diffHours}:${('0' + diffMinutes).slice(-2)}:${('0' + diffSeconds).slice(-2)}`;

		// Store the result in the feedback object for further use
		$scope.feedback.calculatedResult = $scope.calculatedResult;

		console.log("Calculated Result:", $scope.feedback.calculatedResult);
	};


	


	$scope.currentMonthYear = getCurrentMonthYear();



	// Navigate to a specific page
	$scope.prev = function () {

		window.location.href = '/audit_forms';
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

		function isFeedbackValid() {
			if ($scope.feedback.site == '' || $scope.feedback.site == undefined) {
				alert('Please select site');
				return false;
			}
			// if ($scope.feedback.ward == '' || $scope.feedback.ward == undefined) {
			// 	alert("Please select ward");
			// 	return false;
			// }
			// if ($scope.feedback.icu == '' || $scope.feedback.icu == undefined) {
			// 	alert("Please select ICU");
			// 	return false;
			// }
			// if ($scope.feedback.department == '' || $scope.feedback.department == undefined) {
			// 	alert("Please select patient status");
			// 	return false;
			// }
			// if ($scope.feedback.beds == '' || $scope.feedback.beds == undefined) {
			// 	alert("Please enter no. of occupied beds");
			// 	return false;
			// }
			// if ($scope.feedback.nurses == '' || $scope.feedback.nurses == undefined) {
			// 	alert("Please enter no. of nurses");
			// 	return false;
			// }
			return true;
		}

		// Check if required fields are filled
		if (!isFeedbackValid()) {
			return;
		}



		$rootScope.loader = true;

		$scope.feedback.name = $scope.loginname;

		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_nurse_patients_ratio.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
			if (responsedata.status = "success") {
				$rootScope.loader = false;
				// navigator.showToast('Patient Feedback Submitted Successfully');
				//$location.path('/thankyou');
				$scope.step0 = false;
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

