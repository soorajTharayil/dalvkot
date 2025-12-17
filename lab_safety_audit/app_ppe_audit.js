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


	var selectedMonths = $window.localStorage.getItem('selectedMonth');
	console.log(selectedMonths); // This will log "June"
	var selectedYears = $window.localStorage.getItem('selectedYear');
	console.log(selectedYears); // This will log "2024"

	$scope.selectedMonths = $window.localStorage.getItem('selectedMonth');
	$scope.selectedYears = $window.localStorage.getItem('selectedYear');


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



	$scope.setupapplication = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/audit_load_safety_adherece_dept.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.safety_adherence = responsedata.data;
			console.log($scope.auditdept);
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.setupapplication();



	//Audit frequency
	$scope.setupapplication2 = function () {
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/audit_load_frequency.php?patientid=' + id, { timeout: 20000 }).then(function (responsedata) {
			$scope.auditfrequency = responsedata.data;
			console.log($scope.auditfrequency);
			$scope.loadAuditCounts();
		},
			function myError(response) {
				$rootScope.loader = false;

			}
		);

	}

	$scope.showAuditMsg = false;

	$scope.closeAuditMsg = function () { $scope.showAuditMsg = false; };

	$scope.loadAuditCounts = function () {

		var url = window.location.href;
		var id = url.substring(url.lastIndexOf('=') + 1);

		$http.get($rootScope.baseurl_main + '/audit_count.php?patientid=' + id + '&month=' + $scope.selectedMonths + '&year=' + $scope.selectedYears + '&table=' + 'bf_feedback_lab_safety_audit', { timeout: 20000 })
			.then(function (res) {

				var monthCount = parseInt(res.data.conducted_month, 10) || 0;
				var lastDate = res.data.previous_audit_date || 'N/A';
				var yearCount = parseInt(res.data.conducted_year, 10) || 0;
				var lastDateYear = res.data.last_audit_date_year || 'N/A';

				var recList = ($scope.auditfrequency && Array.isArray($scope.auditfrequency.auditfrequency))
					? $scope.auditfrequency.auditfrequency : [];
				var rec = recList[2] || {};

				var freqRaw = (rec.frequency || '').toString().trim();
				var freq = freqRaw.toLowerCase();
				var audit_type = rec.audit_type;
				var target = rec.target;
				var title = rec.title || 'This audit';

				var isRandom = (freq === 'random audit');


				var isMonthlyType =
					(freq === 'daily') ||
					(freq === 'weekly') ||
					(freq === 'monthly') ||
					(freq === 'twice a week') ||
					(freq.indexOf('fortnight') !== -1);

				var remaining = isMonthlyType ? Math.max(target - monthCount, 0) : '—';
				var extra = isMonthlyType ? Math.max(monthCount - target, 0) : '—';

				$scope.auditFreq = freqRaw;
				$scope.title = title;
				$scope.audit_type = audit_type;
				$scope.auditTargetPerMonth = (isMonthlyType || isRandom) ? target : '—';
				$scope.auditLastDate = lastDate;
				$scope.auditConductedMonth = monthCount;

				$scope.showRemaining = isMonthlyType;
				$scope.auditRemaining = isMonthlyType ? remaining : '—';

				if (isMonthlyType) {
					if (target > 0 && monthCount >= target) {
						$scope.auditStatusMessage = 'Minimum monthly target met. Completed ' + monthCount + (extra > 0 ? ' (+' + extra + ' above target)' : '') + '. Last audit on ' + lastDate + '.';
						$scope.auditSentence = 'The ' + title + ' is conducted ' + freqRaw + ' with a minimum target of ' + target + ' audits this month. The target has been achieved, with ' + monthCount + ' completed' + (extra > 0 ? ' (' + extra + ' above target)' : '') + '. The last audit was performed on ' + lastDate + '.';
					} else {
						$scope.auditStatusMessage = 'Minimum monthly target: ' + target + '. Completed ' + monthCount + '; ' + remaining + ' to target. Last audit on ' + lastDate + '.';
						$scope.auditSentence = 'The ' + title + ' is conducted ' + freqRaw + ' with a minimum target of ' + target + ' audits this month. So far, ' + monthCount + ' audits have been conducted, leaving ' + remaining + ' to reach the target. The last audit was performed on ' + lastDate + '.';
					}

				} else if (freq === 'random audit') {
					// Random: show target (sample size) and completed; do not mention "remaining"
					$scope.auditStatusMessage = 'Target sample size (minimum per month): ' + target + '. Completed this month: ' + monthCount + '. Last audit on ' + lastDate + '.';
					$scope.auditSentence = 'The ' + title + ' is conducted as a Random audit with a minimum monthly sample size of ' + target + '. So far, ' + monthCount + ' audits have been conducted this month. The last audit was performed on ' + lastDate + '.';

				} else if (freq === 'quarterly') {
					var yrTargetQ = 4, yrRemainQ = Math.max(yrTargetQ - yearCount, 0), yrExtraQ = Math.max(yearCount - yrTargetQ, 0);
					$scope.auditTargetPerYear = yrTargetQ;
					$scope.auditConductedYear = yearCount;
					$scope.auditRemainingYear = yrRemainQ;
					$scope.auditLastDateYear = lastDateYear;

					$scope.auditStatusMessage = 'Minimum yearly target (Quarterly): ' + yrTargetQ + '. Completed ' + yearCount + (yrExtraQ > 0 ? ' (+' + yrExtraQ + ' above target)' : '') + '. Last audit in ' + $scope.selectedYears + ' on ' + lastDateYear + '.';
					$scope.auditSentence = 'The ' + title + ' is conducted Quarterly with a minimum target of ' + yrTargetQ + ' audits in ' + $scope.selectedYears + '. ' + (yrRemainQ > 0 ? ('So far, ' + yearCount + ' have been conducted, leaving ' + yrRemainQ + ' to reach the target. ') : ('Completed ' + yearCount + (yrExtraQ > 0 ? ' (' + yrExtraQ + ' above target). ' : '. '))) + 'The last audit in ' + $scope.selectedYears + ' was performed on ' + lastDateYear + '.';

				} else if (freq === 'half-yearly' || freq === 'half yearly') {
					var yrTargetH = 2, yrRemainH = Math.max(yrTargetH - yearCount, 0), yrExtraH = Math.max(yearCount - yrTargetH, 0);
					$scope.auditTargetPerYear = yrTargetH;
					$scope.auditConductedYear = yearCount;
					$scope.auditRemainingYear = yrRemainH;
					$scope.auditLastDateYear = lastDateYear;

					$scope.auditStatusMessage = 'Minimum yearly target (Half-Yearly): ' + yrTargetH + '. Completed ' + yearCount + (yrExtraH > 0 ? ' (+' + yrExtraH + ' above target)' : '') + '. Last audit in ' + $scope.selectedYears + ' on ' + lastDateYear + '.';
					$scope.auditSentence = 'The ' + title + ' is conducted Half-Yearly with a minimum target of ' + yrTargetH + ' audits in ' + $scope.selectedYears + '. ' + (yrRemainH > 0 ? ('So far, ' + yearCount + ' have been conducted, leaving ' + yrRemainH + ' to reach the target. ') : ('Completed ' + yearCount + (yrExtraH > 0 ? ' (' + yrExtraH + ' above target). ' : '. '))) + 'The last audit in ' + $scope.selectedYears + ' was performed on ' + lastDateYear + '.';

				} else if (freq === 'annual') {
					var yrTargetA = 1, yrRemainA = Math.max(yrTargetA - yearCount, 0), yrExtraA = Math.max(yearCount - yrTargetA, 0);
					$scope.auditTargetPerYear = yrTargetA;
					$scope.auditConductedYear = yearCount;
					$scope.auditRemainingYear = yrRemainA;
					$scope.auditLastDateYear = lastDateYear;

					$scope.auditStatusMessage = 'Minimum yearly target (Annual): ' + yrTargetA + '. Completed ' + yearCount + (yrExtraA > 0 ? ' (+' + yrExtraA + ' above target)' : '') + '. Last audit in ' + $scope.selectedYears + ' on ' + lastDateYear + '.';
					$scope.auditSentence = 'The ' + title + ' is conducted Annually with a minimum target of ' + yrTargetA + ' audit in ' + $scope.selectedYears + '. ' + (yrRemainA > 0 ? ('So far, ' + yearCount + ' have been conducted, leaving ' + yrRemainA + ' to reach the target. ') : ('Completed ' + yearCount + (yrExtraA > 0 ? ' (' + yrExtraA + ' above target). ' : '. '))) + 'The last audit in ' + $scope.selectedYears + ' was performed on ' + lastDateYear + '.';

				} else {
					$scope.auditStatusMessage = '';
					$scope.auditSentence = '';
				}


				console.log($scope.auditSentence);
				$scope.showAuditMsg = true;
			});
	};

	$scope.setupapplication2();

	//aduit frequency end



	$scope.currentMonthYear = getCurrentMonthYear();



	// Navigate to a specific page
	$scope.prev = function () {

		window.location.href = '/audit_forms';
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
			if (!$scope.feedback.staffname) {
				alert("Please enter staff name");
				return false;
			}
			if (!$scope.feedback.idno) {
				alert("Please enter ID No");
				return false;
			}
			if (!$scope.feedback.department) {
				alert("Please select department");
				return false;
			}
			if ($scope.feedback.department === 'Lab' && !$scope.feedback.comment_l) {
				alert("Please enter staff activity");
				return false;
			}
			
			

			if (($scope.feedback.department === 'Lab') &&
				(!$scope.feedback.gloves || !$scope.feedback.mask || !$scope.feedback.cap || !$scope.feedback.apron)) {
				alert("Please select all options");
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
		$http.post($rootScope.baseurl_main + '/savepatientfeedback_lab_safety_audit.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function (responsedata) {
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

