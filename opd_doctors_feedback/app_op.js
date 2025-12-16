var app = angular.module('ehandorApp', []);

app.controller('PatientFeedbackCtrl', function ($rootScope, $scope, $http, $location, $timeout) {
	$scope.typel = 'english';
	$scope.type2 = 'English';
	$scope.feedback = {};
	$scope.feedback.section = 'OP';
	$rootScope.loader = false;
	$rootScope.overallScore = [];
	$rootScope.baseurl_main = window.location.origin + '/api';
	$scope.step1 = true;
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
	var d = new Date();
	$scope.feedback.datetime = d.getTime();

	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/ward_doctors_opd_feedback.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.wardlist = responsedata.data;
			$scope.questioset = responsedata.data.question_set;
			$scope.setting_data = responsedata.data.setting_data;
			//$scope.allQuestions = responsedata.data.question_set || []; // Ensure questions are loaded first for mapping

			$scope.pconsultant = [];
			if (responsedata.data.pinfo && responsedata.data.pinfo != null) {
				var pinfo = responsedata.data.pinfo;
				$scope.feedback.name = pinfo.name;
				$scope.feedback.admissiondate = pinfo.admited_date;
				$scope.feedback.email = pinfo.email;
				$scope.feedback.contactnumber = pinfo.mobile;
				$scope.feedback.bedno = pinfo.bed_no;
				$scope.feedback.bednok = pinfo.bed_nok;
				$scope.feedback.bednom = pinfo.bed_nom;
				$scope.feedback.ward = pinfo.ward;
				$scope.feedback.section = "OP";
				$scope.feedback.patientid = pinfo.patient_id;
				$scope.step2 = true;
				$scope.step1 = false;
			  }
			  if ($scope.feedback.name != "") {
				$scope.activeStep("step2");
			  }
			//console.log($scope.questioset);
			//$scope.feedback.name = responsedata.data.pinfo.name;
			//$scope.feedback.admissiondate = responsedata.data.pinfo.admited_date;
			//$scope.feedback.email = responsedata.data.pinfo.email;
			//$scope.feedback.contactnumber = responsedata.data.pinfo.mobile;
			//$scope.feedback.bedno = responsedata.data.pinfo.bed_no;
			//$scope.feedback.ward = responsedata.data.pinfo.ward;
			//$scope.feedback.section = responsedata.data.pinfo.section;
			//$scope.feedback.patientid = responsedata.data.pinfo.patient_id;
			//$scope.feedback.feedbac_summited = responsedata.data.pinfo.feedbac_summited;
			console.log($scope.feedback);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	// Function to reload questions based on selected department
	// $scope.reloadQuestionsForDepartment = function (selectedDepartment) {
	// 	$rootScope.loader = true;

	// 	// Define department to question mapping, adding the actual department categories

	// 	var departmentQuestionMapping = {
	// 		"OT": ["General Facility & Environment OT", "Medical Equipment & Technology OT", "Staff Support (Nurses, Technicians, Administrative)", "Patient Care & Safety", "Communication with Other Doctors & Specialists", "Hospital Administrative & Support Services", "Patient Flow & Coordination", "Leadership & Management", "Quality of Care", "Patient Satisfaction & Experience"],
	// 		"OPD": ["General Facility & Environment OT", "Medical Equipment & Technology OT", "Staff Support (Nurses, Technicians, Administrative)", "Patient Care & Safety", "Communication with Other Doctors & Specialists", "Hospital Administrative & Support Services", "Patient Flow & Coordination", "Leadership & Management", "Quality of Care", "Patient Satisfaction & Experience"]
	// 	};
		


	// 	// Get the relevant question categories for the selected department
	// 	var relevantCategories = departmentQuestionMapping[selectedDepartment] || [];

	// 	// Filter the questions based on the selected department's categories
	// 	$scope.questioset = $scope.allQuestions.filter(function (question) {
	// 		return relevantCategories.includes(question.category); // Assuming each question has a 'category' property
	// 	});

	// 	$rootScope.loader = false;
	// };

	$scope.setupapplication();






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
	$scope.change_ward2 = function () {
		console.log($scope.feedback.ward);
		console.log($scope.wardlist);
		var foundWard = $scope.wardlist.ward.find(function (ward) {
			return ward.title === $scope.feedback.ward;
		});
		$scope.pconsultant = foundWard.bedno;
	};

	// $scope.next0 = function () {
	// 	if ($scope.feedback.opd === '' || $scope.feedback.opd === undefined) {
	// 		alert("Select OT/ OPD ");
	// 		return false;
	// 	} else {
	// 		$scope.step0 = false;
	// 		$scope.step1 = true;
	// 		$(window).scrollTop(0);
	// 	}
	// };

	$scope.prev0 = function () {
		$scope.step0 = true;
		$scope.step1 = false;
		$(window).scrollTop(0);
	}
	

	
	$scope.next1 = function (event) {

		if (event) {
			event.preventDefault();
		}
		// Perform validations first
		if ($scope.feedback.name === '' || $scope.feedback.name === undefined) {
			alert('Please enter Doctors name');
			return false;
		}
		
		if ($scope.feedback.ward === '' || $scope.feedback.ward === undefined) {
			alert('Please Select Department');
			return false;
		}

		// if ($scope.feedback.contactnumber === undefined || $scope.feedback.contactnumber === null || $scope.feedback.contactnumber === '') {
		// 	alert('Please Enter Valid Mobile Number');
		// 	return false;
		// } else if (isNaN($scope.feedback.contactnumber) || $scope.feedback.contactnumber < 1111111111 || $scope.feedback.contactnumber > 9999999999) {
		// 	alert('Please Enter Valid Mobile Number');
		// 	return false;
		// }

		// All validations passed, now execute reCAPTCHA
		grecaptcha.ready(function () {
			grecaptcha.execute('6Lc8CkcqAAAAACv2WebgYioIVJhljcDhqJk5AbAz', { action: 'submit_patient_info' }).then(function (token) {

				// If you just want to proceed after getting the token without server verification:
				$scope.step1 = false;
				$scope.step2 = true;
				// Apply scope changes and scroll to top
			    $scope.$apply(function() {
				$(window).scrollTop(0);
			});
			});
		});
	};


	$scope.prev_before_zero = function () {
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
			document.getElementById('npsdtractor').style.display = 'block';
		} else if (newVal == 7 || newVal == 8) {
			document.getElementById('npspassive').style.display = 'none';
		} else if (newVal == 9 || newVal == 10) {
			document.getElementById('npspromoter').style.display = 'none';
		}
	});

	var d = new Date();
	// var srcValue = $location.search().src;
	// 	alert(srcValue);
	var params = new URLSearchParams(window.location.search);
	var srcValue = params.get('src');

	$scope.feedback.datetime = d.getTime();
	$scope.savefeedback = function () {
		$scope.feedback.recommend1Score = $scope.recommend1_definite_grey / 2;
		/*if (
			($scope.feedback.recommend1Score >= 0 && $scope.feedback.recommend1Score <= 3) &&
			($scope.feedback.detractorcomment === "" || $scope.feedback.detractorcomment === undefined)
		) {
			alert("Please describe reason for low rating");
			return false;
		}*/

		//alert($scope.recommend1_definite_grey);
		if ($scope.recommend1_definite_grey == 0 || $scope.recommend1_definite_grey > 0) {
			console.log('ok');
		} else {
			alert('Please select any value between 0 to 10 for how  likely you are to recommend this hospital to others');
			return false;
		}
		$rootScope.loader = true;
		var formatDateToLocalString = function (date) {
			if (!date) return null;
		
			var d = new Date(date);
			if (isNaN(d.getTime())) return null; 
		
			var year = d.getFullYear();
			var month = ('0' + (d.getMonth() + 1)).slice(-2);
			var day = ('0' + d.getDate()).slice(-2);
			var hours = ('0' + d.getHours()).slice(-2);
			var minutes = ('0' + d.getMinutes()).slice(-2);
			var seconds = ('0' + d.getSeconds()).slice(-2);
			
			return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
		};
		
		// Format dates
		$scope.feedback.surgeryStartDate = formatDateToLocalString($scope.feedback.surgeryStartDate);
		$scope.feedback.surgeryEndDate = formatDateToLocalString($scope.feedback.surgeryEndDate);
		
		



		$scope.feedback.source = 'WLink';
		// function performFunction() {


		// }



		$scope.feedback.patientType = "Out-Patient";
		$scope.feedback.consultant_cat = $scope.feedback.ward;
		$scope.feedback.administratorId = $rootScope.adminId;
		$scope.feedback.wardid = $rootScope.wardid;

		$http.post($rootScope.baseurl_main + '/savedoctorfeedback_opd.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
			if (responsedata.status = "success") {
				$rootScope.loader = false;
				// navigator.showToast('Patient Feedback Submitted Successfully');
				//$location.path('/thankyou');
				$scope.step3 = false;
				$scope.step4 = true;
				$(window).scrollTop(0);

				// Trigger redirection based on conditions
				if ($scope.positivefeedback === true ||
					$scope.feedback.overallScore > $scope.psat_score ||
					$scope.feedback.recommend1Score >= $scope.nps_score) {
					$scope.redirectToReview();
				} else {
					console.log("Conditions for redirection not met.");
				}
			}
			else {
				alert("Feeback already submitted for this patient!!")
			}


		}, function myError(response) {
			$rootScope.loader = false;

			alert("Please check your internet and try again!!")
		});


	}

	// $scope.getReviewLink = function() {
	// 	const fullLink = $scope.setting_data.google_review_link;  // full link from setting_data
	// 	// const parts = fullLink.split('/');  // split by '/'
	// 	// const reviewLink = parts.slice(-2).join('/');  // get the last two parts
	// 	return fullLink;
	// };


	// Function to handle redirection
	// $scope.redirectToReview = function () {
	// 	$timeout(function () {
	// 		const reviewLink = $scope.getReviewLink();
	// 		if (reviewLink) {
	// 			console.log("Redirecting to:", `https://${reviewLink}`);
	// 			window.location.href = `https://${reviewLink}`;
	// 		} else {
	// 			console.error("Review link is not available!");
	// 		}
	// 	}, 1000); // Delay of 1 second
	// };

});

