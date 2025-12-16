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
	$rootScope.baseurl = window.location.origin;
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


	$scope.change_asset = function () {
		var foundWard = $scope.wardlist.ward.find(function (ward) {
			return ward.title === $scope.feedback.ward;
		});

		if (foundWard) {
			var value = Array.isArray(foundWard.bedno) ? foundWard.bedno[0] : foundWard.bedno;
			$scope.feedback.depreciation = Number(value);
		} else {
			$scope.feedback.depreciation = null;
		}

		console.log("Depreciation value:", $scope.feedback.depreciation);
	};


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

	// Extract assetname and assetcode from URL
	var urlParams = new URLSearchParams(window.location.search);
	var user_id = urlParams.get('user_id');
	var assetName = urlParams.get('assetname');
	var assetCode = urlParams.get('assetcode');

	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);

		$http.get($rootScope.baseurl_main + '/assetdepartmentlist.php?patientid=' + user_id + '&assetname=' + encodeURIComponent(assetName) + '&assetcode=' + encodeURIComponent(assetCode), { timeout: 20000 }).then(function (responsedata) {
			$scope.wardlist = responsedata.data;
			$scope.userlist = responsedata.data;
			$scope.deptlist = responsedata.data;
			$scope.asset_details = responsedata.data.asset_details;
			$scope.all_assets = responsedata.data.all_assets || [];

			$scope.user_id = user_id;
			// Find the user whose user_id matches $scope.userId
			var matchedUser = $scope.user.find(u => u.user_id === $scope.user_id);


			if (matchedUser) {
				$scope.matchedUserDetails = matchedUser; // Store matched user details
				console.log("Matched User:", $scope.matchedUserDetails);
				$scope.activeStep('step2');
			} else {
				console.log("No matching user found for user_id:", $scope.userId);
			}


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
				$scope.feedback.warrenty_end = formatDate($scope.asset_details.contract_end_date);
				$scope.feedback.cmcServiceCharges = Number($scope.asset_details.contract_service_charges) || 0;
				$scope.feedback.depreciation = Number($scope.asset_details.depreciation) || 0;

				$scope.feedback.supplierinfo = $scope.asset_details.supplierinfo;
				$scope.feedback.servicename = $scope.asset_details.servicename;
				$scope.feedback.servicecon = $scope.asset_details.servicecon;
				$scope.feedback.servicemail = $scope.asset_details.servicemail;

			}

		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.setupapplication();

	$scope.bed_no = [];



	var urlParams = new URLSearchParams(window.location.search);
	var userId = urlParams.get('userid'); // Extract user_id from URL
	$scope.userId = userId;


	$scope.setupapplication1 = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/esr_wards.php?patientid=' + $scope.userId + '&assetname=' + encodeURIComponent(assetName) + '&assetcode=' + encodeURIComponent(assetCode), { timeout: 20000 }).then(function (responsedata) {
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


    $scope.feedback.images = $scope.feedback.images || [];


	// Trigger file input click
    $scope.triggerFileInput = function () {
        document.getElementById('imageInput').click();
    };

    // Remove image by index
    $scope.removeImage = function (index) {
        $scope.feedback.images.splice(index, 1);
    };


    // Handle multiple image uploads
    $scope.encodeImages = function (input) {
        var files = input.files;

        if (files && files.length > 0) {
            $scope.image = true;

            for (var i = 0; i < files.length; i++) {
                (function (file) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var img = new Image();
                        img.src = e.target.result;

                        img.onload = function () {
                            var canvas = document.createElement('canvas');
                            var ctx = canvas.getContext('2d');

                            canvas.width = img.width;
                            canvas.height = img.height;

                            ctx.drawImage(img, 0, 0, img.width, img.height);

                            var compressedImageData = canvas.toDataURL('image/jpeg', 0.1);

                            $scope.$apply(function () {
                                $scope.feedback.images.push(compressedImageData);
                            });
                        };
                    };

                    reader.readAsDataURL(file);
                })(files[i]);
            }
        }
    };

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


	//generate patientid for sub asset
	function generatePatientID(assetCode, allAssets) {
		if (!assetCode) return '';

		// Extract existing patient IDs that match the assetCode pattern
		let existingIDs = allAssets
			.map(asset => asset.patientid)
			.filter(id => id.startsWith(assetCode))
			.map(id => id.replace(assetCode, '').replace('-', '')) // Extract suffix
			.filter(suffix => suffix)
			.sort();

		// Determine the next suffix
		let nextSuffix = 'A';
		if (existingIDs.length > 0) {
			let lastSuffix = existingIDs[existingIDs.length - 1];
			let lastCharCode = lastSuffix.charCodeAt(0);
			nextSuffix = String.fromCharCode(lastCharCode + 1); // Get the next letter
		}

		return `${assetCode}-${nextSuffix}`;
	}




	// To display date in datetime-local ISO format
	function formatDate(dateString) {
		if (!dateString) return null;

		// Split the date string
		let dateParts = dateString.split("-");
		let year = dateParts[0];
		let month = dateParts[1] - 1;
		let day = dateParts[2];

		// Get current time for HH:mm part
		let now = new Date();
		let date = new Date(year, month, day, now.getHours(), now.getMinutes());

		return date;
	}


	


	$scope.removeFile = function (index) {
		$scope.feedback.files_name.splice(index, 1);
	};




	$scope.next1 = function () {

		$scope.step0 = false;
		$scope.step1 = true;
		$(window).scrollTop(0);

	}

	$scope.feedback = {
		ward: 'Select Asset Group/ Category',
		component: 'Select Asset Component',
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


	$scope.isDepreciationCalculated = false;

	// Calculate the depreciation to know current asset value

	$scope.calculateDepreciation = function () {
		const installDate = new Date($scope.feedback.installDate);
		const unitPrice = parseFloat($scope.feedback.unitprice);
		const depreciationRate = parseFloat($scope.feedback.depreciation);
		const assetGroup = $scope.feedback.ward;
		const currentDate = new Date();

		// Validation
		if (!installDate || isNaN(unitPrice) || isNaN(depreciationRate) || !assetGroup) {
			$scope.calculatedDepreciation = 0;
			$scope.assetCurrentValue = 0;
			$scope.feedback.calculatedDepreciation = 0;
			$scope.feedback.assetCurrentValue = 0;
			$scope.fyAssetValues = {};
			return;
		}

		// Calculate exact duration in fractional years based on days
		const msPerDay = 1000 * 60 * 60 * 24;
		const durationDays = (currentDate - installDate) / msPerDay;
		const durationYears = Math.max(0, durationDays / 365);


		// Access method from wardlist.ward array
		let method = null;
		if ($scope.wardlist && Array.isArray($scope.wardlist.ward)) {
			const matchedWard = $scope.wardlist.ward.find(w => w.title === assetGroup);
			if (matchedWard && matchedWard.method) {
				const methodString = matchedWard.method.toUpperCase();
				if (methodString.includes('WDV')) {
					method = 'WDV';
				} else if (methodString.includes('SLM')) {
					method = 'SLM';
				}
			}
		}

		if (!method) {
			$scope.calculatedDepreciation = 0;
			$scope.assetCurrentValue = unitPrice.toFixed(2);
			$scope.feedback.calculatedDepreciation = 0;
			$scope.feedback.assetCurrentValue = $scope.assetCurrentValue;
			$scope.fyAssetValues = {};
			return;
		}

		// Standard calculation (unchanged)
		let depreciationValue = 0;
		let assetCurrentValue = unitPrice;

		if (method === "SLM") {
			depreciationValue = unitPrice * (depreciationRate / 100) * durationYears;
			assetCurrentValue = unitPrice - depreciationValue;
		} else if (method === "WDV") {
			const monthlyRate = Math.pow(1 - depreciationRate / 100, 1 / 12);
			const effectiveMonths = Math.floor(durationYears * 12);
			for (let i = 0; i < effectiveMonths; i++) {
				assetCurrentValue *= monthlyRate;
			}
			depreciationValue = unitPrice - assetCurrentValue;
		}

		$scope.calculatedDepreciation = depreciationValue.toFixed(2);
		$scope.assetCurrentValue = assetCurrentValue.toFixed(2);
		$scope.feedback.calculatedDepreciation = $scope.calculatedDepreciation;
		$scope.feedback.assetCurrentValue = $scope.assetCurrentValue;
		$scope.isDepreciationCalculated = true;


		// -----------------------------
		let fyAssetValues = {};
		let baseValue = unitPrice;
		let fyStart = new Date(installDate);
		if (fyStart.getMonth() <= 2) {
			fyStart = new Date(fyStart.getFullYear() - 1, 3, 1); // April 1 of previous year
		} else {
			fyStart = new Date(fyStart.getFullYear(), 3, 1); // April 1 of current year
		}

		while (fyStart <= currentDate) {
			let fyEnd = new Date(fyStart.getFullYear() + 1, 2, 31); // March 31 of next year
			if (fyEnd > currentDate) fyEnd = new Date(currentDate);

			let overlapStart = installDate > fyStart ? new Date(installDate) : new Date(fyStart);
			let overlapEnd = fyEnd;

			if (overlapStart > overlapEnd) {
				fyStart.setFullYear(fyStart.getFullYear() + 1);
				continue;
			}

			const msPerDay = 1000 * 60 * 60 * 24;
			const daySpan = Math.ceil((overlapEnd - overlapStart) / msPerDay) + 1;
			const yearFraction = daySpan / 365;

			if (method === 'SLM') {
				const dep = baseValue * (depreciationRate / 100) * yearFraction;
				baseValue -= dep;
			} else if (method === 'WDV') {
				const effectiveRate = Math.pow(1 - depreciationRate / 100, yearFraction);
				baseValue *= effectiveRate;
			}

			const fyLabel = 'FY ' + fyStart.getFullYear() + '-' + String(fyStart.getFullYear() + 1).slice(-2);
			const fyYear = fyStart.getFullYear();
			const currentFYStart = (currentDate.getMonth() <= 2) ? currentDate.getFullYear() - 1 : currentDate.getFullYear();

			// Save only current + previous 2 FYs
			if (fyYear >= currentFYStart - 2) {
				fyAssetValues[fyLabel] = baseValue.toFixed(2);
			}

			fyStart.setFullYear(fyStart.getFullYear() + 1);
		}

		$scope.fyAssetValues = fyAssetValues;

		console.log($scope.fyAssetValues);
		$scope.feedback.fyAssetValues = fyAssetValues; // optional for saving
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


	//calculate function for discharge

	// $scope.calculateDoctorAdviceToBillPaid = function () {

	// 	function convertToTotalSeconds(hours, minutes, seconds) {
	// 		return (hours * 3600) + (minutes * 60) + seconds;
	// 	}
	// 	$scope.feedback.doctor_adviced_discharge =
	// 		($scope.feedback.initial_assessment_hr3 || 0) + ":" +
	// 		($scope.feedback.initial_assessment_min3 || 0) + ":" +
	// 		($scope.feedback.initial_assessment_sec3 || 0);

	// 	$scope.feedback.bill_paid_time =
	// 		($scope.feedback.initial_assessment_hr4 || 0) + ":" +
	// 		($scope.feedback.initial_assessment_min4 || 0) + ":" +
	// 		($scope.feedback.initial_assessment_sec4 || 0);


	// 	// Get the time when the doctor gave advice
	// 	var doctorAdviceHours = parseInt(document.getElementById('formula_para3_hr').value || 0);
	// 	var doctorAdviceMinutes = parseInt(document.getElementById('formula_para3_min').value || 0);
	// 	var doctorAdviceSeconds = parseInt(document.getElementById('formula_para3_sec').value || 0);

	// 	// Get the time when the bill was paid
	// 	var billPaidHours = parseInt(document.getElementById('formula_para4_hr').value || 0);
	// 	var billPaidMinutes = parseInt(document.getElementById('formula_para4_min').value || 0);
	// 	var billPaidSeconds = parseInt(document.getElementById('formula_para4_sec').value || 0);

	// 	// Convert times to total seconds for easier comparison
	// 	var totalDoctorAdviceSeconds = convertToTotalSeconds(doctorAdviceHours, doctorAdviceMinutes, doctorAdviceSeconds);
	// 	var totalBillPaidSeconds = convertToTotalSeconds(billPaidHours, billPaidMinutes, billPaidSeconds);

	// 	// Adjust if the bill paid time is before the doctor advice time
	// 	if (totalBillPaidSeconds < totalDoctorAdviceSeconds) {
	// 		totalBillPaidSeconds += 86400; // 24 hours in seconds
	// 	}

	// 	// Calculate the difference in seconds
	// 	var differenceInSeconds = totalBillPaidSeconds - totalDoctorAdviceSeconds;

	// 	// Convert the difference back to hours, minutes, and seconds
	// 	var diffHours = Math.floor(differenceInSeconds / 3600);
	// 	var remainingSeconds = differenceInSeconds % 3600;

	// 	var diffMinutes = Math.floor(remainingSeconds / 60);
	// 	var diffSeconds = remainingSeconds % 60;

	// 	// Format the result to "hr:min:sec"
	// 	$scope.calculatedDoctorAdviceToBillPaid = `${diffHours}:${('0' + diffMinutes).slice(-2)}:${('0' + diffSeconds).slice(-2)}`;

	// 	// Store the result in the feedback object for further use
	// 	$scope.feedback.calculatedDoctorAdviceToBillPaid = $scope.calculatedDoctorAdviceToBillPaid;

	// 	console.log("Calculated Doctor Advice to Bill Paid:", $scope.calculatedDoctorAdviceToBillPaid);
	// };







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



	$scope.$watch('feedback.installDate', function (newValue, oldValue) {
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
			var year = d.getFullYear();
			var month = ('0' + (d.getMonth() + 1)).slice(-2);
			var day = ('0' + d.getDate()).slice(-2);
			return `${year}-${month}-${day}`;
		};

		// Format dates
		$scope.feedback.purchaseDate = formatDateToLocalString($scope.feedback.purchaseDate);
		$scope.feedback.installDate = formatDateToLocalString($scope.feedback.installDate);
		$scope.feedback.warrenty = formatDateToLocalString($scope.feedback.warrenty);
		$scope.feedback.warrenty_end = formatDateToLocalString($scope.feedback.warrenty_end);
		$scope.feedback.amcStartDate = formatDateToLocalString($scope.feedback.amcStartDate);
		$scope.feedback.amcEndDate = formatDateToLocalString($scope.feedback.amcEndDate);
		$scope.feedback.cmcStartDate = formatDateToLocalString($scope.feedback.cmcStartDate);
		$scope.feedback.cmcEndDate = formatDateToLocalString($scope.feedback.cmcEndDate);

		$rootScope.loader = true;

		// Additional details
		$scope.feedback.name = $scope.loginname;
		$scope.feedback.contactnumber = $scope.loginnumber;
		$scope.feedback.email = $scope.loginemail;

		// Generate the QR code
		$scope.assetUrl = $rootScope.baseurl + "/show_asset_details/?assetcode=" + $scope.feedback.patientid;

		QRCode.toDataURL($scope.assetUrl, function (err, url) {
			if (err) {
				console.error('Error generating QR code:', err);
				alert("Failed to generate QR code.");
				$rootScope.loader = false;
				return;
			}

			// Add the QR code URL (Base64) to feedback
			$scope.feedback.qrCodeUrl = url;

			// Save feedback with QR code
			$http.post($rootScope.baseurl_main + '/savepatientfeedback_asset_create.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback)
				.then(function (responsedata) {
					$rootScope.loader = false;

					if (responsedata.status = "success") {
						$scope.step2 = false;
						$scope.step4 = true;
						$(window).scrollTop(0);

					} else {
						alert("Feedback already submitted for this patient!");
					}
				}, function (error) {
					$rootScope.loader = false;
					alert("Please check your internet and try again!");
				});
		});
	};



})

