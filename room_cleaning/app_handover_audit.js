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

	$scope.feedback = {
		department: 'Designation'
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


	//calculate function for discharge

	$scope.calculateDoctorAdviceToBillPaid = function () {

		function convertToTotalSeconds(hours, minutes, seconds) {
			return (hours * 3600) + (minutes * 60) + seconds;
		}
		$scope.feedback.doctor_adviced_discharge =
			($scope.feedback.initial_assessment_hr3 || 0) + ":" +
			($scope.feedback.initial_assessment_min3 || 0) + ":" +
			($scope.feedback.initial_assessment_sec3 || 0);

		$scope.feedback.bill_paid_time =
			($scope.feedback.initial_assessment_hr4 || 0) + ":" +
			($scope.feedback.initial_assessment_min4 || 0) + ":" +
			($scope.feedback.initial_assessment_sec4 || 0);


		// Get the time when the doctor gave advice
		var doctorAdviceHours = parseInt(document.getElementById('formula_para3_hr').value || 0);
		var doctorAdviceMinutes = parseInt(document.getElementById('formula_para3_min').value || 0);
		var doctorAdviceSeconds = parseInt(document.getElementById('formula_para3_sec').value || 0);

		// Get the time when the bill was paid
		var billPaidHours = parseInt(document.getElementById('formula_para4_hr').value || 0);
		var billPaidMinutes = parseInt(document.getElementById('formula_para4_min').value || 0);
		var billPaidSeconds = parseInt(document.getElementById('formula_para4_sec').value || 0);

		// Convert times to total seconds for easier comparison
		var totalDoctorAdviceSeconds = convertToTotalSeconds(doctorAdviceHours, doctorAdviceMinutes, doctorAdviceSeconds);
		var totalBillPaidSeconds = convertToTotalSeconds(billPaidHours, billPaidMinutes, billPaidSeconds);

		// Adjust if the bill paid time is before the doctor advice time
		if (totalBillPaidSeconds < totalDoctorAdviceSeconds) {
			totalBillPaidSeconds += 86400; // 24 hours in seconds
		}

		// Calculate the difference in seconds
		var differenceInSeconds = totalBillPaidSeconds - totalDoctorAdviceSeconds;

		// Convert the difference back to hours, minutes, and seconds
		var diffHours = Math.floor(differenceInSeconds / 3600);
		var remainingSeconds = differenceInSeconds % 3600;

		var diffMinutes = Math.floor(remainingSeconds / 60);
		var diffSeconds = remainingSeconds % 60;

		// Format the result to "hr:min:sec"
		$scope.calculatedDoctorAdviceToBillPaid = `${diffHours}:${('0' + diffMinutes).slice(-2)}:${('0' + diffSeconds).slice(-2)}`;

		// Store the result in the feedback object for further use
		$scope.feedback.calculatedDoctorAdviceToBillPaid = $scope.calculatedDoctorAdviceToBillPaid;

		console.log("Calculated Doctor Advice to Bill Paid:", $scope.calculatedDoctorAdviceToBillPaid);
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
			if ($scope.feedback.area == '' || $scope.feedback.area == undefined) {
				alert('Please enter area');
				return false;
			}
			
			
			
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
		$http.post($rootScope.baseurl_main + '/savefeedback_room_cleaning.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
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

