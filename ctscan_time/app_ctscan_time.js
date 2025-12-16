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
		department: 'Department'
	};






	//Calculate function for initail assessment

	$scope.calculateTimeFormat = function () {

		function convertMillisecondsToTime(ms) {
			var totalSeconds = Math.floor(ms / 1000);
			var hours = Math.floor(totalSeconds / 3600);
			var minutes = Math.floor((totalSeconds % 3600) / 60);
			var seconds = totalSeconds % 60;

			return {
				hours: hours,
				minutes: minutes,
				seconds: seconds
			};
		}

		// Get admission and assessment times
		var admissionDate = new Date($scope.feedback.initial_assessment_hr1);
		var assessmentDate = new Date($scope.feedback.initial_assessment_hr2);

		// Validation checks
		if (!admissionDate || isNaN(admissionDate.getTime())) {
			alert("Please select bill prepared time.");
			return;
		}

		if (!assessmentDate || isNaN(assessmentDate.getTime())) {
			alert("Please select patient entry time.");
			return;
		}

		if (assessmentDate <= admissionDate) {
			alert("Patient entry time must be greater than bill prepared time.");
			return;
		}

		// Extract date and time components for admission time
		var admissionYear = admissionDate.getFullYear();
		var admissionMonth = String(admissionDate.getMonth() + 1).padStart(2, '0'); // Months are zero-based
		var admissionDay = String(admissionDate.getDate()).padStart(2, '0');
		var admissionHours = String(admissionDate.getHours()).padStart(2, '0');
		var admissionMinutes = String(admissionDate.getMinutes()).padStart(2, '0');
		var admissionSeconds = String(admissionDate.getSeconds()).padStart(2, '0');

		// Format the admission time to include date and time
		var formattedAdmissionDateTime = `${admissionYear}-${admissionMonth}-${admissionDay} ${admissionHours}:${admissionMinutes}:${admissionSeconds}`;
		console.log("Admission DateTime:", formattedAdmissionDateTime);

		// Extract date and time components for assessment time
		var assessmentYear = assessmentDate.getFullYear();
		var assessmentMonth = String(assessmentDate.getMonth() + 1).padStart(2, '0'); // Months are zero-based
		var assessmentDay = String(assessmentDate.getDate()).padStart(2, '0');
		var assessmentHours = String(assessmentDate.getHours()).padStart(2, '0');
		var assessmentMinutes = String(assessmentDate.getMinutes()).padStart(2, '0');
		var assessmentSeconds = String(assessmentDate.getSeconds()).padStart(2, '0');

		// Format the assessment time to include date and time
		var formattedAssessmentDateTime = `${assessmentYear}-${assessmentMonth}-${assessmentDay} ${assessmentHours}:${assessmentMinutes}:${assessmentSeconds}`;
		console.log("Assessment DateTime:", formattedAssessmentDateTime);

		// Calculate the difference in milliseconds
		var differenceInMs = assessmentDate - admissionDate;

		// Convert the difference to hours, minutes, and seconds
		var timeDifference = convertMillisecondsToTime(differenceInMs);

		// Format the result to include date and time
		var currentDate = new Date();
		var formattedDate = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + ('0' + currentDate.getDate()).slice(-2);
		var formattedTime = ('0' + timeDifference.hours).slice(-2) + ':' + ('0' + timeDifference.minutes).slice(-2) + ':' + ('0' + timeDifference.seconds).slice(-2);

		$scope.calculatedResult = formattedDate + ' ' + formattedTime;
		$scope.calculatedResultTime = formattedTime;
		$scope.formattedAdmissionDateTime = formattedAdmissionDateTime;
		$scope.formattedAssessmentDateTime = formattedAssessmentDateTime;

		// Store the result in the feedback object for further use
		$scope.feedback.calculatedResult = $scope.calculatedResult;
		$scope.feedback.calculatedResultTime = $scope.calculatedResultTime;
		$scope.feedback.initial_assessment_hr1 = $scope.formattedAdmissionDateTime;
		$scope.feedback.initial_assessment_hr2 = $scope.formattedAssessmentDateTime;

		console.log("Calculated Result Time:", $scope.feedback.calculatedResultTime);
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
			if ($scope.feedback.patientid == '' || $scope.feedback.patientid == undefined) {
				alert('Please enter UHID');
				return false;
			}
			return true;
		}

		// Check if required fields are filled
		if (!isFeedbackValid()) {
			return;
		}

		var formatDateToLocalString = function (date) {
			var d = new Date(date);
			var year = d.getFullYear();
			var month = ('0' + (d.getMonth() + 1)).slice(-2);
			var day = ('0' + d.getDate()).slice(-2);
			var hours = ('0' + d.getHours()).slice(-2);
			var minutes = ('0' + d.getMinutes()).slice(-2);
			var seconds = ('0' + d.getSeconds()).slice(-2);
			return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
		};

		// Convert all dates to local datetime strings
		$scope.feedback.initial_assessment_hr1 = formatDateToLocalString($scope.feedback.initial_assessment_hr1);
		$scope.feedback.initial_assessment_hr2 = formatDateToLocalString($scope.feedback.initial_assessment_hr2);
		$scope.feedback.initial_assessment_hr3 = formatDateToLocalString($scope.feedback.initial_assessment_hr3);




		$rootScope.loader = true;

		$scope.feedback.name = $scope.loginname;

		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_ctscan_time.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
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

