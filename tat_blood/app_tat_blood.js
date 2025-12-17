var app = angular.module('ehandorApp', []);

app.directive('clickOutside', function ($document) {
	return {
		restrict: 'A',
		link: function (scope, element, attrs) {
			function handleClick(event) {
				// If click is outside this element
				if (!element[0].contains(event.target)) {
					scope.$apply(function () {
						scope.$eval(attrs.clickOutside);
					});
				}
			}

			// Listen for clicks on the whole page
			$document.on('click', handleClick);

			// Remove listener when scope destroyed
			scope.$on('$destroy', function () {
				$document.off('click', handleClick);
			});
		}
	};
});
// adf 
app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location, $window, $timeout) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.feedback = {};



	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step0 = true;
	$scope.step1 = false;
	$scope.step4 = false;


	//show date and time in input field
	let now = new Date();
	now.setSeconds(0, 0);

	$timeout(function () {
		$scope.feedback.audit_date = now;
	}, 0);


	// max (current date/time)
	let maxDate = new Date();
	maxDate.setSeconds(59, 999);

	let year = maxDate.getFullYear();
	let month = ('0' + (maxDate.getMonth() + 1)).slice(-2);
	let day = ('0' + maxDate.getDate()).slice(-2);
	let hours = ('0' + maxDate.getHours()).slice(-2);
	let minutes = ('0' + maxDate.getMinutes()).slice(-2);
	$scope.todayDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

	// min (7 days back)
	let minDate = new Date();
	minDate.setDate(minDate.getDate() - 7);

	let minYear = minDate.getFullYear();
	let minMonth = ('0' + (minDate.getMonth() + 1)).slice(-2);
	let minDay = ('0' + minDate.getDate()).slice(-2);
	let minHours = ('0' + minDate.getHours()).slice(-2);
	let minMinutes = ('0' + minDate.getMinutes()).slice(-2);
	$scope.minDateTime = `${minYear}-${minMonth}-${minDay}T${minHours}:${minMinutes}`;

	$scope.encodeFiles = function (element) {
		var files_name = Array.from(element.files);

		files_name.forEach(function (file) {
			var formData = new FormData();
			formData.append('file', file);

			$http.post($rootScope.baseurl_main + '/upload_file.php', formData, {
				transformRequest: angular.identity,
				headers: { 'Content-Type': undefined }
			}).then(function (response) {
				if (response.data.file_url) {
					var fileUrl = response.data.file_url;
					if (!fileUrl.startsWith('http')) {
						fileUrl = $rootScope.baseurl_main + '/' + fileUrl;
					}

					// Ensure files_name is an array before pushing
					if (!$scope.feedback.files_name) {
						$scope.feedback.files_name = []; // Initialize if undefined
					}

					// Push file info to the array
					$scope.feedback.files_name.push({
						url: fileUrl,
						name: file.name
					});
				}
			}).catch(function (error) {
				console.error('Error uploading file:', error);
			});
		});
	};


	$scope.removeFile = function (index) {
		$scope.feedback.files_name.splice(index, 1);
	};

	$scope.repeatAudit = function () {
		// keep the values you don’t want to reset
		var keep = {
			audit_by: $scope.feedback.audit_by,
			audit_date: $scope.feedback.audit_date,
			audit_type: $scope.feedback.audit_type
		};

		// reset everything else
		$scope.feedback = {};

		// restore the kept values
		$scope.feedback.audit_by = keep.audit_by;
		$scope.feedback.audit_date = keep.audit_date;
		$scope.feedback.audit_type = keep.audit_type;

		// reset steps
		$scope.step0 = true;
		$scope.step1 = $scope.step2 = $scope.step3 = $scope.step4 = false;
		$scope.step = 0;
	};


	$rootScope.language = function (type) {
		$scope.typel = type;
		if (type == 'english') {
			$http.get('language/english.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;
				$scope.type2 = 'English';
				//load main heading
				$scope.feedback.audit_type = $rootScope.lang.patient_info;
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


		//load audit name
		$timeout(function () {
			$scope.feedback.audit_by = $scope.loginname;
			console.log('Audit by:', $scope.feedback.audit_by);
		}, 0);

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

		if (!$scope.feedback.audit_by || ($scope.feedback.audit_by + '').trim() === '') {
			alert('Please enter audit by');
			return;
		}

		

		if (!$scope.feedback.mid_no || ($scope.feedback.mid_no + '').trim() === '') {
			alert('Please enter Patient UHID');
			return;
		}

		if (!$scope.feedback.patient_name || ($scope.feedback.patient_name + '').trim() === '') {
			alert('Please enter Patient Name');
			return;
		}

		// if (!$scope.feedback.patient_age) {
		// 	alert("Please enter Patient Age");
		// 	return;
		// }

		// if (!$scope.feedback.patient_gender) {
		// 	alert("Please select Patient Gender");
		// 	return;
		// }

		if (!$scope.feedback.location || ($scope.feedback.location + '').trim() === '') {
			alert("Please select Area");
			return;
		}

		if (!$scope.feedback.dep || ($scope.feedback.dep + '').trim() === '') {
			alert("Please select Department");
			return;
		}

		if (!$scope.feedback.attended_doctor || ($scope.feedback.attended_doctor + '').trim() === '') {
			alert("Please select Attended Doctor");
			return;
		}

		if (!$scope.feedback.initial_assessment_hr6) {
			alert("Please enter admission date.");
			return; // stop submission
		}

		// ✅ If all passed → go next
		$scope.step0 = false;
		$scope.step1 = true;
		$(window).scrollTop(0);
	}

	$scope.locations = [
		"1ST FLOOR",
		"2ND FLOOR",
		"3RD FLOOR",
		"4TH FLOOR",
		"5TH FLOOR",
		"6TH FLOOR"
	];

	$scope.selectLocation = function (loc) {
		$scope.feedback.location = loc;
		$scope.locationOpen = false; // close dropdown after selection
	};

	// Select Department
	$scope.selectDepartment = function (dep) {
		$scope.feedback.dep = dep;
		$scope.depOpen = false;   // close dropdown
		$scope.depSearch = "";    // clear search
	};

	// Close dropdown on outside click
	$scope.closeDepartment = function () {
		$scope.depOpen = false;
	};

	// Select Doctor
	$scope.selectDoctor = function (doc) {
		$scope.feedback.attended_doctor = doc;
		$scope.docOpen = false;   // close dropdown
		$scope.docSearch = "";    // clear search
	};

	// Close on outside click
	$scope.closeDoctor = function () {
		$scope.docOpen = false;
	};


	//load doctor list
	$scope.setupapplication3 = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/audit_load_doctor.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.doctor = responsedata.data;
			console.log($scope.doctor);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.setupapplication3();


	$scope.setupapplication1 = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/audit_load_department.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.auditdept = responsedata.data;
			console.log($scope.auditdept);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.setupapplication1();

	$scope.feedback = {
		department: 'Transfusion Type'
	};


	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/audit_load_transfusion_type.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.transfusion = responsedata.data;
			console.log($scope.auditdept);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.setupapplication();



	//Calculate function for initail assessment

	$scope.assessmentCalculated = false;


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
			alert("Please select time.");
			return;
		}

		if (!assessmentDate || isNaN(assessmentDate.getTime())) {
			alert("Please select time.");
			return;
		}

		if (assessmentDate <= admissionDate) {
			alert("Blood/blood product received time must be greater than transfusion request time.");
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
		$scope.assessmentCalculated = true;

	};




	$scope.currentMonthYear = getCurrentMonthYear();



	// Navigate to a specific page
	$scope.prev = function () {

		window.location.href = '/audit_forms';
	};

	$scope.prev1 = function () {

		$scope.step1 = false;
		$scope.step0 = true;
		$(window).scrollTop(0);

	}


	const benchmarkRoutine = (4 * 3600); // 4 hours in seconds
	const benchmarkEmergency = (2 * 3600); // 2 hours in seconds

	function convertToSeconds(timeStr) {
		const [hours, minutes, seconds] = timeStr.split(':').map(Number);
		return (hours * 3600) + (minutes * 60) + seconds;
	}

	$scope.getTextColor = function () {
		const calculatedSeconds = convertToSeconds($scope.calculatedResultTime);
		const benchmark = $scope.feedback.department === 'Routine' ? benchmarkRoutine : benchmarkEmergency;
		return calculatedSeconds <= benchmark ? 'green' : 'red';
	};

	$scope.updateBenchmarkTime = function () {
		if ($scope.feedback.department === 'Routine') {
			$scope.benchmark = '04:00:00';
			$scope.feedback.benchmark = $scope.benchmark;
		} else if ($scope.feedback.department === 'Emergency') {
			$scope.benchmark = '02:00:00';
			$scope.feedback.benchmark = $scope.benchmark;
		}
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
		if (!$scope.assessmentCalculated) {
			alert("Please calculate before saving.");
			return;
		}

		function isFeedbackValid() {
			if (!$scope.feedback.audit_by || ($scope.feedback.audit_by + '').trim() === '') {
			alert('Please enter audit by');
			return;
		}
			if ($scope.feedback.mid_no == '' || $scope.feedback.mid_no == undefined) {
				alert('Please enter UHID');
				return false;
			}
			if ($scope.feedback.department == '' || $scope.feedback.department == undefined) {
				alert('Please select transfusion type');
				return false;
			}
			if ($scope.feedback.initial_assessment_hr3 == '' || $scope.feedback.initial_assessment_hr3 == undefined) {
				alert('Please select date');
				return false;
			}

			return true;
		}

		// Check if required fields are filled
		if (!isFeedbackValid()) {
			return;
		}

		var formatDateToLocalString = function (date) {
			if (!date) return "";
			var d = new Date(date);

			if (isNaN(d.getTime())) return "";

			var year = d.getFullYear();
			var month = ('0' + (d.getMonth() + 1)).slice(-2);
			var day = ('0' + d.getDate()).slice(-2);
			var hours = ('0' + d.getHours()).slice(-2);
			var minutes = ('0' + d.getMinutes()).slice(-2);

			return `${year}-${month}-${day} ${hours}:${minutes}`;
		};

		$scope.feedback.audit_date = formatDateToLocalString($scope.feedback.audit_date);
		$scope.feedback.initial_assessment_hr1 = formatDateToLocalString($scope.feedback.initial_assessment_hr1);
		$scope.feedback.initial_assessment_hr2 = formatDateToLocalString($scope.feedback.initial_assessment_hr2);
		$scope.feedback.initial_assessment_hr3 = formatDateToLocalString($scope.feedback.initial_assessment_hr3);

		if (!$scope.feedback.initial_assessment_hr1) {
			alert("Please enter time.");
			return;
		}

		if (!$scope.feedback.initial_assessment_hr2) {
			alert("Please enter time.");
			return;
		}

		if (new Date($scope.feedback.initial_assessment_hr2) <= new Date($scope.feedback.initial_assessment_hr1)) {
			alert("Blood/blood product received time must be greater than transfusion request time.");
			return;
		}


		$rootScope.loader = true;

		$scope.feedback.name = $scope.loginname;

		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_tat_blood.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
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

