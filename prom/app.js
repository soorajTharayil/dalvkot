var app = angular.module('ehandorApp', []);

app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location) {
	$scope.typel = 'english';
	$scope.feedback = {};
	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step0 = true;
	$scope.step1 = false;
	$scope.next0 = function () {
		if ($scope.feedback.contactnumber == undefined) {
			alert('Please Enter Valid Mobile Number');
			return false;
		}
		if ($scope.feedback.contactnumber < 1111111111 || $scope.feedback.contactnumber > 9999999999) {
			alert('Please Enter Valid Mobile Number');
			return false;
		}
		$http.get($rootScope.baseurl_main + '/mobile_inpatient.php?mobile=' + $scope.feedback.contactnumber, { timeout: 20000 }).then(function (responsedata) {
			if (responsedata.data.pinfo == 'NO') {
				$scope.step0 = false;
				$scope.step1 = true;
				$scope.feedback.name = '';
				$scope.feedback.section = 'IP';
				$scope.backtonumber = false;
			} else {
				$scope.step0 = false;
				$scope.step2 = true;
				$scope.feedback.name = responsedata.data.pinfo.name;
				$scope.feedback.admissiondate = responsedata.data.pinfo.admited_date;
				$scope.feedback.email = responsedata.data.pinfo.email;
				$scope.feedback.contactnumber = responsedata.data.pinfo.mobile;
				$scope.feedback.bedno = responsedata.data.pinfo.bed_no;
				$scope.feedback.ward = responsedata.data.pinfo.ward;
				$scope.feedback.section = 'IP';
				$scope.feedback.patientid = responsedata.data.pinfo.patient_id;
				$scope.backtonumber = true;
				console.log($scope.feedback);
			}
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$rootScope.language = function (type) {
		$scope.typel = type;
		if (type == 'english') {
			$http.get('language/english.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;

			});
		}
		if (type == 'lang2') {
			$http.get('language/lang2.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;

			});
		}
		if (type == 'lang3') {
			$http.get('language/lang3.json').then(function (responsedata) {

				$rootScope.lang = responsedata.data;

			});
		}
		$scope.feedback.langsub = type;
	}
	$rootScope.language('english');
	window.setTimeout(function () {
		$(window).scrollTop(0);
	}, 0);

	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/prom.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.wardlist = responsedata.data;
			$scope.questioset = responsedata.data.question_set;
			$scope.setting_data = responsedata.data.setting_data;
			console.log($scope.questioset);
			$scope.feedback.name = responsedata.data.pinfo.name;
			$scope.feedback.admissiondate = responsedata.data.pinfo.admited_date;
			$scope.feedback.email = responsedata.data.pinfo.email;
			$scope.feedback.contactnumber = responsedata.data.pinfo.mobile;
			$scope.feedback.bedno = responsedata.data.pinfo.bed_no;
			$scope.feedback.ward = responsedata.data.pinfo.ward;
			$scope.feedback.section = responsedata.data.pinfo.section;
			$scope.feedback.patientid = responsedata.data.pinfo.patient_id;
			$scope.feedback.feedbac_summited = responsedata.data.pinfo.feedbac_summited;

			$scope.bed_no = [];
			$scope.pinfo_online = false;
			//$scope.wardlist = question_set_IP;
			//$rootScope.questioset = question_set_IP.question_set;
			console.log($rootScope.questioset);
			if ($scope.feedback.ward != null) {
				$scope.feedback.section = 'IP';
				$scope.pinfo_online = true;
				$scope.step2 = true;
				$scope.step1 = false;
				$scope.step0 = false;
			}
			console.log($scope.feedback);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}
	$scope.setupapplication();






	// $scope.questionvalueset = function (v, key, q) {
	// 	$rootScope.positivefeedback = true;
	// 	q.valuetext = v;
	// 	$scope.feedback[key] = v;
	// 	console.log($scope.feedback);
	// 	$rootScope.overallScore[key] = v;
	// 	$scope.overallSum($rootScope.overallScore);
	// 	$scope.showerrorbox = false;
	// 	angular.forEach($scope.questioset, function (questioncat, kcat) {
	// 		$scope.questioset[kcat].errortitle = false;
	// 	});
	// 	angular.forEach($scope.feedback, function (value, k) {
	// 		angular.forEach($scope.questioset, function (questioncat, kcat) {

	// 			angular.forEach(questioncat.question, function (questionset, kq) {
	// 				console.log(questionset.shortkey);
	// 				if (k == questionset.shortkey) {
	// 					if (value == 1 || value == 2) {
	// 						console.log(questioncat);
	// 						$scope.questioset[kcat].errortitle = true;
	// 						$scope.showerrorbox = true;
	// 						$rootScope.positivefeedback = false
	// 						//$scope.$apply();
	// 					}
	// 				}
	// 			})
	// 		})
	// 	});

	// }

	$scope.next1 = function () {
		console.log($scope.feedback.name);
		// if ($scope.feedback.name == '' || $scope.feedback.name == undefined) {
		// 	alert('Please Enter Patient Name');
		// 	return false;
		// }
		// if ($scope.feedback.patientid == '' || $scope.feedback.patientid == undefined) {
		// 	alert('Please enter the last 6 digit of your UHID');
		// 	return false;
		// }


		// if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
		// 	alert("Please Select Ward");
		// 	return false;
		// }
		// if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
		// 	alert("Please Select Bed Number");
		// 	return false;
		// }


		if (isNaN($scope.feedback.contactnumber) || $scope.feedback.contactnumber == null) {
			$scope.step1 = false;
			$scope.step2 = true;
			$(window).scrollTop(0);
		} else {
			if ($scope.feedback.contactnumber < 1111111111 || $scope.feedback.contactnumber > 9999999999) {
				alert('Please Enter Valid Mobile Number');
				return false;
			} else {
				$scope.step1 = false;
				$scope.step2 = true;
				$(window).scrollTop(0);

			}
		}

	}
	$scope.prev0 = function () {
		$scope.step0 = true;
		$scope.step1 = false;
		$(window).scrollTop(0);
	}

	$scope.prev1 = function () {
		$scope.step1 = true;
		$scope.step2 = false;
		$(window).scrollTop(0);
	}

	$scope.prev2 = function () {
		$scope.step2 = true;
		$scope.step3 = false;
		$(window).scrollTop(0);
	}
	$scope.next2 = function () {


		$(window).scrollTop(0);
		$scope.step2 = false
		$scope.step3 = true;

	}

	$scope.next3 = function () {
		$scope.step3 = false;
		$scope.step4 = true;
		$(window).scrollTop(0);
	}

	$scope.overallSum = function (obj) {

		var sum = 0,
			length = 0;
		for (var el in obj) {
			if (obj.hasOwnProperty(el)) {
				sum += parseFloat(obj[el]);
				length++;
			}
		}



		window.overallSumScore = sum / (length);
		window.overallSumScore = Math.round(window.overallSumScore);
		$scope.feedback.overallScore = window.overallSumScore;



	}

	$scope.recommend1_definite_grey = -1;


	$scope.selectedNegativeOption = [];

	$scope.totalSelectedMarks = 0; // To store the total sum of selected marks
	$scope.reson_set = [];
	$scope.feedback.reason = {};
	$scope.handleRadioSelection = function (settitle,shortkey, marks) {
		$scope.selectedNegativeOption[settitle] = parseInt(marks); // Store the marks for the selected option
		$scope.reson_set[settitle] = {marks:marks,shortkey:shortkey}
		$scope.totalSelectedMarks = Object.values($scope.selectedNegativeOption).reduce(function (total, mark) {
			return total + (mark || 0); // Add up the marks (default to 0 if mark is undefined)
		}, 0);
            //console.log($scope.totalSelectedMarks);
	};



	var d = new Date();
	$scope.feedback.datetime = d.getTime();
	$scope.savefeedback = function () {
		$scope.feedback.recommend1Score = $scope.recommend1_definite_grey / 2;
		//alert($scope.recommend1_definite_grey);
		if ($scope.recommend1_definite_grey == 0 || $scope.recommend1_definite_grey > 0) {
			console.log('ok');
		} else {
			alert('Please select any value between 0 to 10 for how  likely you are to recommend this hospital to others');
			return false;
		}
		$rootScope.loader = true;
		$scope.feedback.source = 1;
		$scope.feedback.patientType = "Porm";
		$scope.feedback.administratorId = $rootScope.adminId;
		$scope.feedback.wardid = $rootScope.wardid;
		for (var key in $scope.reson_set) {
			if ($scope.reson_set.hasOwnProperty(key)) {
				$scope.setValue = $scope.reson_set[key];
				console.log($scope.setValue);
				console.log($scope.setValue.shortkey);
				$scope.feedback[$scope.setValue.shortkey] = $scope.setValue.marks;
				$scope.feedback.reason[$scope.setValue.shortkey] = true;
			}
		}
	
		$http.post($rootScope.baseurl_main + '/savepatientprom.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
			if (responsedata.status = "success") {
				$rootScope.loader = false;
				// navigator.showToast('Patient Feedback Submitted Successfully');
				//$location.path('/thankyou');
				$scope.step3 = false;
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

