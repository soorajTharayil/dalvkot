var app = angular.module('ehandorApp', []);
// adf 
app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location, $window) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.toplogo = false;
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

	$scope.feedback = {};



	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step0 = true;
	$scope.step1 = false;
	$scope.step4 = false;

	$scope.activeStep = function (step) {
		$scope.step0 = false;
		$scope.step1 = false;
		$scope.step2 = false;
		$scope.step3 = false;
		$scope.step4 = false;
		$scope.step5 = false;

		// Set the appropriate step to true based on the argument
		if (step === "step0") $scope.step0 = true;
		if (step === "step1") $scope.step1 = true;
		if (step === "step2") $scope.step2 = true;
		if (step === "step3") $scope.step3 = true;
		if (step === "step4") $scope.step4 = true;
		if (step === "step5") $scope.step5 = true;

		// Scroll to top of the window
		$(window).scrollTop(0);
	};


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




	$scope.bed_no = [];

	$scope.change_ward = function () {
		var foundWard = $scope.locationlist.ward.find(function (ward) {
			return ward.title === $scope.feedback.locationsite;  // Match the floor title with locationsite
		});

		if (foundWard) {
			$scope.bed_no = foundWard.bedno;  // Set bed_no based on the found floor's bed numbers
		} else {
			$scope.bed_no = [];  // Clear the list if no match is found
		}

		console.log($scope.bed_no);  // For debugging purposes
	};


	// Function to format date to dd-MM-yyyy hh:mm
	function formatDate(date) {
		const day = String(date.getDate()).padStart(2, '0');
		const month = String(date.getMonth() + 1).padStart(2, '0');
		const year = date.getFullYear();
		const hours = String(date.getHours()).padStart(2, '0');
		const minutes = String(date.getMinutes()).padStart(2, '0');
		return `${day}-${month}-${year} ${hours}:${minutes}`;
	}


	$scope.login = function () {
		/*var intstatus = $rootScope.internetcheck();
		if (intstatus == false) {
		  return false;
		}*/
		$rootScope.loader = true;
		$scope.toplogo = true;

		$http.post($rootScope.baseurl_main + '/login.php', $scope.loginvar, { timeout: 20000 }).then(function (responsedata) {
			console.log(responsedata);
			if (responsedata.status == 200) {
				var response = responsedata.data;
				$rootScope.loader = false;
				$rootScope.profilen = response;
				console.log(responsedata.data.email);

				$scope.loginemail = responsedata.data.email;
				$scope.loginid = responsedata.data.empid;
				$scope.loginname = responsedata.data.name;
				$scope.loginnumber = responsedata.data.mobile;

				$rootScope.adminId = $rootScope.profilen.userid;
				$scope.profiled = $rootScope.profilen;
				localStorage.setItem("ehandor", JSON.stringify(response));
				if (response.status === 'fail') {
					$scope.loginerror = response.message;
				} else if (response.status === 'success') {
					$rootScope.loginactive = true;
					$scope.activeStep("step2");
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
									$scope.loginemail = responsedata.data.email;
									$scope.loginid = responsedata.data.empid;
									$scope.loginname = responsedata.data.name;
									$scope.loginnumber = responsedata.data.mobile;

									$scope.profiled = $rootScope.profilen;
									localStorage.setItem("ehandor", JSON.stringify(value));
									$rootScope.loginactive = true;
									$scope.activeStep("step2");
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



	$scope.encodeImage = function (input) {
		var file = input.files[0];

		if (file) {
			var reader = new FileReader();

			reader.onload = function (e) {
				loadImage(
					e.target.result,
					function (img) {
						var compressedImageData = img.toDataURL('image/jpeg', 0.7);

						$scope.$apply(function () {
							$scope.feedback.image = compressedImageData;
						});
					},
					{ orientation: true, maxWidth: 200 }
				);
			};

			reader.readAsDataURL(file);
		} else {
			$scope.$apply(function () {
				$scope.feedback.image = null;
			});
		}
	};

	$scope.fetchAssetDetails = function () {
		if ($scope.feedback.patientid) {
			// Fetch the asset details from your API
			$http.get($rootScope.baseurl_main + '/asset_isr.php?patientid=' + $scope.feedback.patientid, { timeout: 20000 })
				.then(function (response) {
					if (response.data && response.data.length > 0) {
						$scope.assetDetails = response.data;  // Store fetched asset details in scope
					} else {
						$scope.assetDetails = [];  // Empty array if no asset details found
						console.warn('No assets found for the provided patient ID.');
					}
				}, function (error) {
					console.error('Error fetching asset details:', error);
					$scope.assetDetails = [];  // Clear the asset details on error
				});
		}
	};



	$scope.next1 = function () {

		$scope.step0 = false;
		$scope.step1 = true;
		$(window).scrollTop(0);

	}



	var urlParams = new URLSearchParams(window.location.search);
	var userId = urlParams.get('user_id'); // Extract user_id from URL
	$scope.userId = userId;



	$scope.setupapplication1 = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);

		const urlParams = new URLSearchParams(window.location.search);
		const userId = urlParams.get('userid');
		const assetCode = urlParams.get('assetcode');


		$http.get($rootScope.baseurl_main + '/esr_wards.php?patientid=' + userId + '&assetcode=' + encodeURIComponent(assetCode), { timeout: 20000 }).then(function (responsedata) {
			$scope.locationlist = responsedata.data;
			$scope.setting_data = responsedata.data.setting_data;
			$scope.user = responsedata.data.user;
			$scope.userId = userId;
			// Find the user whose user_id matches $scope.userId
			var matchedUser = $scope.user.find(u => u.user_id === $scope.userId);


			if (matchedUser) {
				$scope.matchedUserDetails = matchedUser; // Store matched user details
				console.log("Matched User:", $scope.matchedUserDetails);
				$scope.activeStep('step2');
			} else {
				console.log("No matching user found for user_id:", $scope.userId);
			}

			if (assetCode) {
				console.log("AssetCode for future use:", assetCode);
				$scope.feedback.patientid = assetCode;
				$scope.fetchAssetDetails();
			}

			if (matchedUser) {
				$scope.matchedUserDetails = matchedUser; // Store matched user details

				// Save first name and email in variables
				$scope.userFirstName = matchedUser.firstname;
				$scope.userEmail = matchedUser.email;
				$scope.userNumber = matchedUser.mobile;


				$scope.feedback.name = $scope.userFirstName;
				$scope.feedback.email = $scope.userEmail;
				$scope.feedback.contactnumber = $scope.userNumber;


				$scope.loginemail = $scope.userEmail;
				$scope.loginid = $scope.userId;
				$scope.loginname = $scope.userFirstName;
				$scope.loginnumber = $scope.userNumber;


				console.log("User First Name:", $scope.userFirstName);
				console.log("User Email:", $scope.userEmail);
			} else {
				console.log("No matching user found for user_id:", $scope.userId);
			}

			$scope.asset_details = responsedata.data.asset_details;

			// Set asset details if found
			if ($scope.asset_details) {
				console.log($scope.asset_details);
				$scope.feedback.patientid = generatePatientID(assetCode, $scope.all_assets);

				$scope.feedback.assetname = $scope.asset_details.assetname;

				$scope.feedback.ward = $scope.asset_details.ward;

				$scope.feedback.component = $scope.asset_details.component;


				$scope.feedback.depart = $scope.asset_details.depart;



				$scope.feedback.assigned = $scope.asset_details.assignee;


				$scope.feedback.locationsite = $scope.asset_details.locationsite;
				$scope.feedback.bedno = $scope.asset_details.bedno;
				$scope.feedback.purchaseDate = formatDate($scope.asset_details.purchaseDate);
				$scope.feedback.installDate = formatDate($scope.asset_details.installDate);
				$scope.feedback.invoice = $scope.asset_details.invoice;
				$scope.feedback.grn_no = $scope.asset_details.grn_no;
				$scope.feedback.warrenty = formatDate($scope.asset_details.warrenty);
				$scope.feedback.warrenty_end = formatDate($scope.asset_details.warrenty_end);
				$scope.feedback.contract = $scope.asset_details.contract;
				$scope.feedback.amcStartDate = formatDate($scope.asset_details.contract_start_date);
				$scope.feedback.amcEndDate = formatDate($scope.asset_details.contract_end_date);
				$scope.feedback.amcServiceCharges = Number($scope.asset_details.contract_service_charges) || 0;
				$scope.feedback.cmcStartDate = formatDate($scope.asset_details.contract_start_date);
				$scope.feedback.cmcEndDate = formatDate($scope.asset_details.contract_end_date);
				$scope.feedback.cmcServiceCharges = Number($scope.asset_details.contract_service_charges) || 0;
				$scope.feedback.supplierinfo = $scope.asset_details.supplierinfo;
				$scope.feedback.servicename = $scope.asset_details.servicename;
				$scope.feedback.servicecon = $scope.asset_details.servicecon;
				$scope.feedback.servicemail = $scope.asset_details.servicemail;

			}



			$scope.bed_no = [];

		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}
	$scope.setupapplication1();



	// Extract assetname and assetcode from URL
	var urlParams = new URLSearchParams(window.location.search);
	var userid = urlParams.get('userid');
	var assetCode = urlParams.get('assetcode');


	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/assetdepartmentlist.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.wardlist = responsedata.data;
			$scope.userlist = responsedata.data;
			$scope.deptlist = responsedata.data;

			// Extract user_id from URL and find matching user
			var userId = id;
			if ($scope.userlist.user) {
				var matchedUser = $scope.userlist.user.find(user => user.user_id == userId);
				if (matchedUser) {
					// $scope.feedback.assigned = matchedUser.firstname;
					// $scope.feedback.assigned_user_id = matchedUser.user_id;
					$scope.activeStep('step2');

				}
			}

		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.setupapplication();

	$scope.feedback = {
		ward: 'Select Asset Group/ Category',
		assigned: 'Select Asset User',
		depart: 'Select Asset Department',
		bedno: 'Select Site',
		locationsite: 'Select Floor/ Area',
		contract: 'Select AMC/ CMC'

	};





	// Function to calculate total price
	$scope.calculateTotalPrice = function () {
		var quantity = parseFloat($scope.feedback.assetquantity) || 0;
		var unitPrice = parseFloat($scope.feedback.unitprice) || 0;
		$scope.feedback.totalprice = quantity * unitPrice;
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
			alert("Please select a valid time.");
			return;
		}

		if (!assessmentDate || isNaN(assessmentDate.getTime())) {
			alert("Please select a valid time.");
			return;
		}

		if (assessmentDate <= admissionDate) {
			alert("Patient entry into the consultation room time must be greater than registration time.");
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

		window.location.href = '/asset_forms';
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


	$scope.$watch('feedback.purchaseDate', function (newValue, oldValue) {
		if (newValue) {
			// Automatically set the warrenty date to match the purchase date
			$scope.feedback.warrenty = newValue;
		}
	});



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
				alert('Please enter asset code');
				return false;
			}

			return true;
		}

		// Check if required fields are filled
		if (!isFeedbackValid()) {
			return;
		}

		var formatDateToLocalString = function (date) {
			var d = new Date(date + 'Z');

			// Extract year, month, day, hours, minutes, and seconds
			var year = d.getFullYear();
			var month = ('0' + (d.getMonth() + 1)).slice(-2);
			var day = ('0' + d.getDate()).slice(-2);
			var hours = ('0' + d.getHours()).slice(-2);
			var minutes = ('0' + d.getMinutes()).slice(-2);
			var seconds = ('0' + d.getSeconds()).slice(-2);

			// Return formatted date string in yyyy-mm-dd hh:mm:ss format
			return `${year}-${month}-${day}`;
		};

		// Convert the purchaseDate before saving
		$scope.feedback.lastCalibrationDate = formatDateToLocalString($scope.feedback.lastCalibrationDate);
		$scope.feedback.upcomingCalibrationDate = formatDateToLocalString($scope.feedback.upcomingCalibrationDate);




		$rootScope.loader = true;

		$scope.feedback.name = $scope.loginname;

		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savefeedback_calibration.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
			$rootScope.loader = false;
			if (responsedata.status = "success") {

				// navigator.showToast('Patient Feedback Submitted Successfully');
				//$location.path('/thankyou');
				$scope.step2 = false;
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

