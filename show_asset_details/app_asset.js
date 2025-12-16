var app = angular.module('ehandorApp', []);
// adf 
app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location, $window) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.feedback = {};

	$scope.loginvar = {
		userid: '',
		password: ''
	};


	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step0 = true;
	$scope.step1 = false;
	$scope.step2 = false;

	$scope.activeStep = function (step) {
		$scope.step0 = false;
		$scope.step1 = false;
		$scope.step2 = false;

		// Set the appropriate step to true based on the argument
		if (step === "step0") $scope.step0 = true;
		if (step === "step1") $scope.step1 = true;
		if (step === "step2") $scope.step2 = true;

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



	$scope.assetDetails = {};



	$scope.setupapplication = function () {

		var url = window.location.href;
		var patientid = url.substring(url.lastIndexOf('=') + 1); // Extract patientid from URL

		if (patientid) {

			// Make the API call to get asset details using the patientid
			$http.get($rootScope.baseurl_main + '/show_asset_details.php?patientid=' + patientid)
				.then(function (response) {
					// Check if the API response contains asset details
					if (response.data.status === 'success') {
						$scope.assetDetails = response.data.assetDetails;
						console.log("4");
					} else {
						$scope.error = response.data.message;
						console.error("Error: ", response.data.message);
					}
				})
				.catch(function (error) {
					console.error("Error fetching asset details: ", error);
				});
		} else {
			console.error("Patient ID is missing in the URL.");
		}
	};


	// Call the function to load asset details
	$scope.setupapplication();


	$scope.setupapplication1 = function () {
		var url = window.location.href;
		var id = url.substring(url.lastIndexOf('=') + 1);

		$http.get($rootScope.baseurl_main + '/esr_wards.php?patientid=' + id, { timeout: 20000 })
			.then(function (responsedata) {
				$scope.locationlist = responsedata.data;
				$scope.setting_data = responsedata.data.setting_data;
				$scope.user = responsedata.data.user;

				// Remove this line to prevent auto-navigation
				// $scope.activeStep('step2');

				if ($scope.user) {
					var matchedUser = $scope.user.find(u => u.user_id === $scope.userId);

					if (matchedUser) {
						$scope.matchedUserDetails = matchedUser;
						$scope.userFirstName = matchedUser.firstname;
						$scope.userEmail = matchedUser.email;
						$scope.userNumber = matchedUser.mobile;
						$scope.userId = matchedUser.emp_id;

						// Pre-fill but don't auto-login
						$scope.feedback.name = $scope.userFirstName;
						$scope.feedback.email = $scope.userEmail;
						$scope.feedback.contactnumber = $scope.userNumber;

						console.log("User data loaded:", $scope.userFirstName);
					}
				}
				$scope.bed_no = [];
			}, function myError(response) {
				$rootScope.loader = false;
			});
	};
	$scope.setupapplication1();


	

	$scope.login = function () {
		$rootScope.loader = true;

		$http.post($rootScope.baseurl_main + '/login.php', $scope.loginvar, { timeout: 20000 })
			.then(function (responsedata) {
				if (responsedata.status == 200) {
					var response = responsedata.data;
					$rootScope.loader = false;

					if (response.status === 'success') {
						// Store user data
						localStorage.setItem("ehandor", JSON.stringify(response));
						$rootScope.profilen = response;
						$rootScope.adminId = response.userid;
						console.log($rootScope.adminId);
						$rootScope.loginactive = true;

						// Set user details
						$scope.loginemail = response.email;
						$scope.loginid = response.empid;
						$scope.loginname = response.name;
						$scope.loginnumber = response.mobile;

						// Move to step2 - THIS IS THE CRITICAL LINE
						$scope.step1 = false;
						$scope.step2 = true;

					} else {
						$scope.loginerror = response.message;
					}
				}
			}, function (error) {
				$rootScope.loader = false;
				$scope.loginerror = 'Internet Connection error';
			});
	};


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





	$scope.goToLogin = function () {

		$scope.step0 = false;
		$scope.step1 = true;
		$(window).scrollTop(0);

	}







	// Function to calculate total price
	$scope.calculateTotalPrice = function () {
		var quantity = parseFloat($scope.feedback.assetquantity) || 0;
		var unitPrice = parseFloat($scope.feedback.unitprice) || 0;
		$scope.feedback.totalprice = quantity * unitPrice;
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

	// $scope.updateAssetStatus = function () {
	// 	if ($scope.feedback.assigned && $scope.feedback.assigned !== "Assign to User/Department") {
	// 		$scope.feedback.assetStatus = "Asset in Use";
	// 	} else {
	// 		$scope.feedback.assetStatus = "Not yet Allocated";
	// 	}
	// };

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
		$scope.feedback.purchaseDate = formatDateToLocalString($scope.feedback.purchaseDate);
		$scope.feedback.warrenty = formatDateToLocalString($scope.feedback.warrenty);
		$scope.feedback.warrenty_end = formatDateToLocalString($scope.feedback.warrenty_end);
		$scope.feedback.amcStartDate = formatDateToLocalString($scope.feedback.amcStartDate);
		$scope.feedback.amcEndDate = formatDateToLocalString($scope.feedback.amcEndDate);
		$scope.feedback.cmcStartDate = formatDateToLocalString($scope.feedback.cmcStartDate);
		$scope.feedback.cmcEndDate = formatDateToLocalString($scope.feedback.cmcEndDate);


		$rootScope.loader = true;

		$scope.feedback.name = $scope.loginname;

		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_asset_create.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
			if (responsedata.status = "success") {
				$rootScope.loader = false;

				$scope.step0 = false;
				$scope.step4 = true;
				$(window).scrollTop(0);

				//qr code
				alert(responsedata.data.message);
				$scope.qrCodeUrl = responsedata.data.qr_code;


				$scope.assetUrl = "https://demo.efeedor.com'/show_asset_details.php?patientid=" + $rootScope.patientid;



				QRCode.toDataURL($scope.assetUrl, function (err, url) {
					if (err) {
						console.error('Error generating QR code:', err);
					} else {
						$scope.qrCodeUrl = url;  // Update QR code URL with the generated image URL
					}
				});

				$scope.showUrlAfterScan = false;
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

