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

	//show date and time in input field
	let now = new Date();
	now.setSeconds(0, 0);

	$scope.feedback.audit_date = now;

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
		$scope.feedback.audit_by = $scope.loginname;
		console.log($scope.feedback.audit_by);


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

		$scope.step0 = false;
		$scope.step1 = true;
		$(window).scrollTop(0);

	}

	// $scope.feedback = {
	// 	designation: 'Designation',
	// 	department: 'Department',
	// 	indication: 'Indication',
	// 	action: 'HH Action',
	// 	compliance: 'Compliance'
	// };
	

	$scope.setupapplication = function () {
		var url = window.location.href;
		var id = url.substring(url.lastIndexOf('=') + 1);

		$http.get($rootScope.baseurl_main + '/audit_load_hand_designation.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.designation = responsedata.data;
			$scope.action = responsedata.data;
			$scope.compliance = responsedata.data;
			$scope.indication = responsedata.data;

			// Custom order for indication titles
			const customOrder = [
				"Before procedure",
				"Before touching patient",
				"After procedure/body fluid exposure",
				"After touching a patient",
				"After touching patients surroundings"
			];

			if ($scope.indication && $scope.indication.indication) {
				$scope.indication.indication.sort(function (a, b) {
					const indexA = customOrder.indexOf(a.title);
					const indexB = customOrder.indexOf(b.title);
					return (indexA === -1 ? 999 : indexA) - (indexB === -1 ? 999 : indexB);
				});
			}

			console.log($scope.indication);
		},
			function myError(response) {
				$rootScope.loader = false;
			});
	};

	$scope.setupapplication();


	$scope.setupapplication1 = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/audit_load_safety_department.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.safety_inseption = responsedata.data;


			console.log($scope.auditdept);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.setupapplication1();



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
			if (!$scope.feedback.audit_by || ($scope.feedback.audit_by + '').trim() === '') {
			alert('Please enter audit by');
			return;
		}
			if ($scope.feedback.testname == '' || $scope.feedback.testname == undefined) {
				alert("Please enter name");
				return false;
			}
			if ($scope.feedback.designation == '' || $scope.feedback.designation == undefined) {
				alert("Please select designation");
				return false;
			}
			if ($scope.feedback.department == '' || $scope.feedback.department == undefined) {
				alert("Please select department");
				return false;
			}
			if ($scope.feedback.indication == '' || $scope.feedback.indication == undefined) {
				alert("Please select indication");
				return false;
			}
			if ($scope.feedback.action == '' || $scope.feedback.action == undefined) {
				alert("Please select hand hygiene action");
				return false;
			}
			if ($scope.feedback.compliance == '' || $scope.feedback.compliance == undefined) {
				alert("Please select compliance");
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
		

		$rootScope.loader = true;

		$scope.feedback.name = $scope.loginname;

		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_hand_hygiene.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
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

