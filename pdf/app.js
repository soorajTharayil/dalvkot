var app = angular.module('ehandorApp', []);
// adf 
app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.feedback = {};
	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step0 = false;
	$scope.step1 = true;
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
				$scope.feedback.section = 'PDF';
				$scope.backtonumber = false;
			} else {
				$scope.step0 = false;
				$scope.step2 = true;
				$scope.feedback.name = responsedata.data.pinfo.name;
				$scope.feedback.admissiondate = responsedata.data.pinfo.admited_date;
				$scope.feedback.email = responsedata.data.pinfo.email;
				$scope.feedback.contactnumber = responsedata.data.pinfo.mobile;
				$scope.feedback.bedno = responsedata.data.pinfo.bed_no;
				$scope.feedback.bednok = responsedata.data.pinfo.bed_nok;
				$scope.feedback.bednom = responsedata.data.pinfo.bed_nom;
				$scope.feedback.consultant = responsedata.data.pinfo.consultant;
				$scope.feedback.ward = responsedata.data.pinfo.ward;
				$scope.feedback.section = 'PDF';
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

	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/ward_pdf.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.wardlist = responsedata.data;
			$scope.questioset = responsedata.data.question_set;
			$scope.setting_data = responsedata.data.setting_data;
			// $scope.consultant = responsedata.data.consultant;
			console.log($scope.questioset);
			$scope.feedback.name = responsedata.data.pinfo.name;
			$scope.feedback.admissiondate = responsedata.data.pinfo.admited_date;
			$scope.feedback.email = responsedata.data.pinfo.email;
			$scope.feedback.contactnumber = responsedata.data.pinfo.mobile;
			$scope.feedback.bedno = responsedata.data.pinfo.bed_no;
			$scope.feedback.bednok = responsedata.data.pinfo.bed_nok;
			$scope.feedback.bednom = responsedata.data.pinfo.bed_nom;
			$scope.feedback.consultant = responsedata.data.pinfo.consultant;
			$scope.feedback.ward = responsedata.data.pinfo.ward;
			$scope.feedback.section = responsedata.data.pinfo.section;
			$scope.feedback.patientid = responsedata.data.pinfo.patient_id;
			$scope.feedback.feedbac_summited = responsedata.data.pinfo.feedbac_summited;

			$scope.bed_no = [];
			$scope.bed_nok = [];
			$scope.bed_nom = [];
			$scope.pconsultant = [];
			$scope.pinfo_online = false;
			//$scope.wardlist = question_set_PDF;
			//$rootScope.questioset = question_set_PDF.question_set;
			console.log($rootScope.questioset);
			if ($scope.feedback.ward != null) {
				$scope.feedback.section = 'PDF';
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

	// 	 $scope.bed_no = [];
	//     $scope.setupapplication = function () {
	//       var question_set_PDF = JSON.parse(localStorage.getItem("wardPDF"));

	//       $scope.wardlist = question_set_PDF;
	//       $rootScope.questioset = question_set_PDF.question_set;
	//       console.log($rootScope.questioset);
	//     };
	//     $scope.setupapplication();

	$scope.change_ward = function () {
		console.log($scope.feedback.ward);
		console.log($scope.wardlist);
		var foundWard = $scope.wardlist.ward.find(function (ward) {
			return ward.title === $scope.feedback.ward;
		});
		$scope.bed_no = foundWard.bedno;
		$scope.bed_nok = foundWard.bednok;
		$scope.bed_nom = foundWard.bednom;
		console.log($scope.bed_no);

	};
	$scope.change_wardk = function () {
		console.log($scope.feedback.ward);
		console.log($scope.wardlist);
		var foundWard = $scope.wardlist.ward.find(function (ward) {
			return ward.title === $scope.feedback.ward;
		});
		$scope.bed_no = foundWard.bedno;
		$scope.bed_nok = foundWard.bednok;
		$scope.bed_nom = foundWard.bednom;
		console.log($scope.bed_nok);

	};
	$scope.change_wardm = function () {
		console.log($scope.feedback.ward);
		console.log($scope.wardlist);
		var foundWard = $scope.wardlist.ward.find(function (ward) {
			return ward.title === $scope.feedback.ward;
		});
		$scope.bed_no = foundWard.bedno;
		$scope.bed_nok = foundWard.bednok;
		$scope.bed_nom = foundWard.bednom;
		console.log($scope.bed_nom);

	};

	$scope.change_ward2 = function () {
		console.log($scope.feedback.consultant_cat);
		console.log($scope.wardlist);
		var foundWard = $scope.wardlist.consultant.find(function (ward) {
			return ward.title === $scope.feedback.consultant_cat;
		});
		$scope.pconsultant = foundWard.bedno;
	};


	$scope.feedback.reasonSet = {};
	$scope.feedback.reason = {};

	$scope.feedback.commentSet = {};
	$scope.feedback.comment = {};


	$scope.questionvalueset = function (v, key, q) {
		$rootScope.positivefeedback = true;
		q.valuetext = v;
		//wrong
		if ($scope.feedback[key] != v) {
			if ($scope.feedback.reasonSet[q.type]) {
				$scope.feedback.reasonSet[q.type] = {};
				
			} else {
				$scope.feedback.reasonSet[q.type] = {};
				
			}
		}

		if ($scope.feedback[key] != v) {
			if ($scope.feedback.commentSet[q.type]) {
				$scope.feedback.commentSet[q.type] = {};
				
			} else {
				$scope.feedback.commentSet[q.type] = {};
				
			}
		}

		$scope.feedback[key] = v;
		console.log($scope.feedback);
		$rootScope.overallScore[key] = v;
		$scope.overallSum($rootScope.overallScore);
		$scope.showerrorbox = false;

		angular.forEach($scope.questioset, function (questioncat, kcat) {
			$scope.questioset[kcat].errortitle = false;
		});
		angular.forEach($scope.feedback, function (value, k) {
			angular.forEach($scope.questioset, function (questioncat, kcat) {

				angular.forEach(questioncat.question, function (questionset, kq) {
					console.log(questionset.shortkey);
					if (k == questionset.shortkey) {
						if (value == 1 || value == 2) {
							console.log(questioncat);
							$scope.questioset[kcat].errortitle = true;
							$scope.showerrorbox = true;
							$rootScope.positivefeedback = false
							//$scope.$apply();
						}
					}
				})
			})
		});

	}

	$scope.next1 = function () {
		console.log($scope.feedback.name);
		if ($scope.feedback.name == '' || $scope.feedback.name == undefined) {
			alert('Please Enter Patient Name');
			return false;
		}
		

		if ($scope.feedback.patientid == '' || $scope.feedback.patientid == undefined) {
			alert('Please enter your UHID');
			return false;
		}


		if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
			$scope.feedback.ward = 'Others';
		}
		if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
			$scope.feedback.bedno = 'Others';
		}

		$scope.step1 = false;
		$scope.step2 = true;
		

	}
	$scope.prev_before_zero = function () {
		$scope.step_before_zero = true;
		$scope.step1 = false;
		$(window).scrollTop(0);
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
		// $(window).scrollTop(0);
		// $scope.tab2 = false;
		// $scope.tab3 = true;
		//wrong
		var resonSet = [];
		if ($scope.feedback.reason) {
			console.log($scope.feedback.reason);
			angular.forEach($scope.feedback.reason, function (value, key) {
				if (value === true) {
					resonSet.push(key);
				}
			})

		}
		angular.forEach(
			$scope.feedback.reasonSet,
			function (reasonValue, reasonKey) {
				for (let key in reasonValue) {
					$scope.feedback.reason[key] = reasonValue[key];
				}
			}
		);

	

		var commentSet = [];
		if ($scope.feedback.comment) {
			console.log($scope.feedback.comment);
			angular.forEach($scope.feedback.comment, function (value, key) {
				if (value.length > 0) {
					commentSet.push(key);
				}
			})

		}

		angular.forEach(
			$scope.feedback.commentSet,
			function (reasonValue, reasonKey) {
				for (let key in reasonValue) {
					$scope.feedback.comment[key] = reasonValue[key];
				}
			}
		);
		// console.log(commentSet);


		// console.log(resonSet);
		// console.log($scope.feedback);
		// console.log($scope.question_set);
		// console.log($scope.questioset);
		var isValid = false;
		var isValid_form = true;

		angular.forEach($scope.questioset, function (value, key) {
			var question = value.question;
			angular.forEach(question, function (qvalue, qkey) {
				if (qvalue.valuetext > 0) {
					isValid = true;
				}
			})
		})
		//CHECK FOR ANY Question selected or not
		if (isValid == false) {
			alert('Please rate the questions to proceed.');
			isValid_form = false;
			return false;
		}
		//CHECK for Value where 1 / 2
		angular.forEach($scope.questioset, function (value, key) {
			var question = value.question;
			angular.forEach(question, function (qvalue, qkey) {
				if (qvalue.valuetext == 1 || qvalue.valuetext == 2) {

					var isvalid_negative = false;

					// angular.forEach($scope.feedback.comment, function (crow, cKey) {
					// 	if (cKey == qvalue.type && (crow != "" || crow != null)) {
					// 		isvalid_negative = true;
					// 	}
					// });

					angular.forEach(qvalue.negative, function (row, rowKey) {
						angular.forEach($scope.feedback.reason, function (r, rk) {
							if (row.shortkey === rk && r === true) {
								isvalid_negative = true;
							}
						});
					});

					// angular.forEach(qvalue.average, function (row, rowKey) {
					//   angular.forEach($scope.feedback.reason, function (r, rk) {
					// 	if (row.shortkey === rk && r === true) {
					// 	  isvalid_negative = true;
					// 	}
					//   });
					// });

					// angular.forEach(qvalue.poor, function (row, rowKey) {
					//   angular.forEach($scope.feedback.reason, function (r, rk) {
					// 	if (row.shortkey === rk && r === true) {
					// 	  isvalid_negative = true;
					// 	}
					//   });
					// });

					// angular.forEach(qvalue.good, function (row, rowKey) {
					//   angular.forEach($scope.feedback.reason, function (r, rk) {
					//     if (row.shortkey === rk && r === true) {
					//       isvalid_negative = true;
					//     }
					//   });
					// });

					// angular.forEach(qvalue.excellent, function (row, rowKey) {
					//   angular.forEach($scope.feedback.reason, function (r, rk) {
					//     if (row.shortkey === rk && r === true) {
					//       isvalid_negative = true;
					//     }
					//   });
					// });

					if (isvalid_negative == false) {
						alert(
							"Please select your reason for giving a negative rating in " +
							qvalue.question
						);
						isValid_form = false;
						return false;
					}
				}
			})
		})
		if (isValid_form == true) {
			$(window).scrollTop(0);
			$scope.step2 = false;
			$scope.step3 = true;
		}

	};

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

	// Function to hide all feedback input fields
	function hideAllFeedbackFields() {
		document.getElementById('npsdtractor').style.display = 'none';
		document.getElementById('npspassive').style.display = 'none';
		document.getElementById('npspromoter').style.display = 'none';
	}


	// Hide all feedback fields on page load
	window.addEventListener('load', function () {
		hideAllFeedbackFields();

	});

	$scope.$watch('recommend1_definite_grey', function (newVal) {
		hideAllFeedbackFields(); // Hide all fields initially

		if (newVal <= 6) {
			document.getElementById('npsdtractor').style.display = 'none';
		} else if (newVal == 7 || newVal == 8) {
			document.getElementById('npspassive').style.display = 'none';
		} else if (newVal == 9 || newVal == 10) {
			document.getElementById('npspromoter').style.display = 'none';
		}
	});


	var d = new Date();
	$scope.feedback.datetime = d.getTime();
	var params = new URLSearchParams(window.location.search);
	var srcValue = params.get('src');
	$scope.savefeedback = function () {

		if (srcValue == '' || srcValue == undefined) {
			$scope.feedback.source = 'WLink';
		}
		else {
			// alert(srcValue);
			$scope.feedback.source = srcValue;

		}
		$scope.feedback.recommend1Score = $scope.recommend1_definite_grey / 2;
		//alert($scope.recommend1_definite_grey);
		if ($scope.recommend1_definite_grey == 0 || $scope.recommend1_definite_grey > 0) {
			console.log('ok');
		} else {
			alert('Please select any value between 0 to 10 for how  likely you are to recommend this hospital to others');
			return false;
		}

		/*if (
			($scope.feedback.recommend1Score >= 0 && $scope.feedback.recommend1Score <= 3) &&
			($scope.feedback.detractorcomment === "" || $scope.feedback.detractorcomment === undefined)
		) {
			alert("Please describe reason for low rating");
			return false;
		}*/

		$rootScope.loader = true;
		// $scope.feedback.source = 1;
		$scope.feedback.patientType = "In-Patient";
		$scope.feedback.administratorId = $rootScope.adminId;
		$scope.feedback.wardid = $rootScope.wardid;
		// $scope.feedback.bedno = $scope.bed_no[$scope.feedback.bedno];


		// $scope.feedback.questioset = $scope.questioset;
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_pdf.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
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

