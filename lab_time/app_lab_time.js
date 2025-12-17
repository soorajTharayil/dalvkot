var app = angular.module("ehandorApp", []);

app.directive("clickOutside", function ($document) {
  return {
    restrict: "A",
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
      $document.on("click", handleClick);

      // Remove listener when scope destroyed
      scope.$on("$destroy", function () {
        $document.off("click", handleClick);
      });
    },
  };
});
// adf
app.controller(
  "PatientFeedbackCtrl",
  function ($rootScope, $scope, $http, $location, $window) {
    $scope.typel = "english";
    $scope.type2 = "English";
    $scope.feedback = {};

    $rootScope.loader = false;
    $rootScope.overallScore = [];
    $rootScope.baseurl_main = window.location.origin + "/api";
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
        audit_type: $scope.feedback.audit_type,
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
    $scope.encodeFiles = function (element) {
      var files_name = Array.from(element.files);

      files_name.forEach(function (file) {
        var formData = new FormData();
        formData.append("file", file);

        $http
          .post($rootScope.baseurl_main + "/upload_file.php", formData, {
            transformRequest: angular.identity,
            headers: { "Content-Type": undefined },
          })
          .then(function (response) {
            if (response.data.file_url) {
              var fileUrl = response.data.file_url;
              if (!fileUrl.startsWith("http")) {
                fileUrl = $rootScope.baseurl_main + "/" + fileUrl;
              }

              // Ensure files_name is an array before pushing
              if (!$scope.feedback.files_name) {
                $scope.feedback.files_name = []; // Initialize if undefined
              }

              // Push file info to the array
              $scope.feedback.files_name.push({
                url: fileUrl,
                name: file.name,
              });
            }
          })
          .catch(function (error) {
            console.error("Error uploading file:", error);
          });
      });
    };

    $scope.removeFile = function (index) {
      $scope.feedback.files_name.splice(index, 1);
    };

    // max (current date/time)
    let maxDate = new Date();
    maxDate.setSeconds(59, 999);

    let year = maxDate.getFullYear();
    let month = ("0" + (maxDate.getMonth() + 1)).slice(-2);
    let day = ("0" + maxDate.getDate()).slice(-2);
    let hours = ("0" + maxDate.getHours()).slice(-2);
    let minutes = ("0" + maxDate.getMinutes()).slice(-2);
    $scope.todayDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

    // min (7 days back)
    let minDate = new Date();
    minDate.setDate(minDate.getDate() - 7);

    let minYear = minDate.getFullYear();
    let minMonth = ("0" + (minDate.getMonth() + 1)).slice(-2);
    let minDay = ("0" + minDate.getDate()).slice(-2);
    let minHours = ("0" + minDate.getHours()).slice(-2);
    let minMinutes = ("0" + minDate.getMinutes()).slice(-2);
    $scope.minDateTime = `${minYear}-${minMonth}-${minDay}T${minHours}:${minMinutes}`;

    $scope.locations = [
      "1ST FLOOR",
      "2ND FLOOR",
      "3RD FLOOR",
      "4TH FLOOR",
      "5TH FLOOR",
      "6TH FLOOR",
    ];

    $scope.selectLocation = function (loc) {
      $scope.feedback.location = loc;
      $scope.locationOpen = false; // close dropdown after selection
    };

    // Select Department
	$scope.selectDepartment = function (dep) {
		$scope.feedback.department = dep;
		$scope.depOpen = false;   // close dropdown
		$scope.depSearch = "";    // clear search
	};

	// Close dropdown on outside click
	$scope.closeDepartment = function () {
		$scope.depOpen = false;
	};

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

    // Select Doctor
    $scope.selectDoctor = function (doc) {
      $scope.feedback.attended_doctor = doc;
      $scope.docOpen = false; // close dropdown
      $scope.docSearch = ""; // clear search
    };

    // Close on outside click
    $scope.closeDoctor = function () {
      $scope.docOpen = false;
    };

    //load doctor list
    $scope.setupapplication = function () {
      //$rootScope.loader = true;
      var url = window.location.href;
      //console.log(url);
      var id = url.substring(url.lastIndexOf("=") + 1);
      //alert(id);
      $http
        .get(
          $rootScope.baseurl_main + "/audit_load_doctor.php?patientid=" + id,
          { timeout: 20000 }
        )
        .then(
          function (responsedata) {
            $scope.doctor = responsedata.data;
            console.log($scope.doctor);
          },
          function myError(response) {
            $rootScope.loader = false;
          }
        );
    };

    $scope.setupapplication();

    var selectedMonths = $window.localStorage.getItem("selectedMonth");
    console.log(selectedMonths); // This will log "June"
    var selectedYears = $window.localStorage.getItem("selectedYear");
    console.log(selectedYears); // This will log "2024"

    $scope.selectedMonths = $window.localStorage.getItem("selectedMonth");
    $scope.selectedYears = $window.localStorage.getItem("selectedYear");

    $rootScope.language = function (type) {
      $scope.typel = type;
      if (type == "english") {
        $http.get("language/english.json").then(function (responsedata) {
          $rootScope.lang = responsedata.data;
          $scope.type2 = "English";
          //load main heading
          $scope.feedback.audit_type = $rootScope.lang.patient_info;
        });
      }
      if (type == "lang2") {
        $http.get("language/lang2.json").then(function (responsedata) {
          $rootScope.lang = responsedata.data;
          $scope.type2 = "ಕನ್ನಡ";
        });
      }
      if (type == "lang3") {
        $http.get("language/lang3.json").then(function (responsedata) {
          $rootScope.lang = responsedata.data;
          $scope.type2 = "മലയാളം";
          //	$scope.type2 = 'தமிழ்';
        });
      }
      $scope.feedback.langsub = type;
    };
    $scope.language("english");
    window.setTimeout(function () {
      $(window).scrollTop(0);
    }, 0);

    var ehandor = JSON.parse($window.localStorage.getItem("ehandor"));
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
      console.log("Data not found in local storage");
    }

    $scope.next1 = function () {
      if (
        !$scope.feedback.audit_by ||
        ($scope.feedback.audit_by + "").trim() === ""
      ) {
        alert("Please enter audit by");
        return;
      }

      $scope.step0 = false;
      $scope.step1 = true;
      $(window).scrollTop(0);
    };

    $scope.currentMonthYear = getCurrentMonthYear();

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
          seconds: seconds,
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
        alert("Please select sample received time.");
        return;
      }

      if (assessmentDate <= admissionDate) {
        alert("Sample received time must be greater than bill prepared time.");
        return;
      }

      // Extract date and time components for admission time
      var admissionYear = admissionDate.getFullYear();
      var admissionMonth = String(admissionDate.getMonth() + 1).padStart(
        2,
        "0"
      ); // Months are zero-based
      var admissionDay = String(admissionDate.getDate()).padStart(2, "0");
      var admissionHours = String(admissionDate.getHours()).padStart(2, "0");
      var admissionMinutes = String(admissionDate.getMinutes()).padStart(
        2,
        "0"
      );
      var admissionSeconds = String(admissionDate.getSeconds()).padStart(
        2,
        "0"
      );

      // Format the admission time to include date and time
      var formattedAdmissionDateTime = `${admissionYear}-${admissionMonth}-${admissionDay} ${admissionHours}:${admissionMinutes}:${admissionSeconds}`;
      console.log("Admission DateTime:", formattedAdmissionDateTime);

      // Extract date and time components for assessment time
      var assessmentYear = assessmentDate.getFullYear();
      var assessmentMonth = String(assessmentDate.getMonth() + 1).padStart(
        2,
        "0"
      ); // Months are zero-based
      var assessmentDay = String(assessmentDate.getDate()).padStart(2, "0");
      var assessmentHours = String(assessmentDate.getHours()).padStart(2, "0");
      var assessmentMinutes = String(assessmentDate.getMinutes()).padStart(
        2,
        "0"
      );
      var assessmentSeconds = String(assessmentDate.getSeconds()).padStart(
        2,
        "0"
      );

      // Format the assessment time to include date and time
      var formattedAssessmentDateTime = `${assessmentYear}-${assessmentMonth}-${assessmentDay} ${assessmentHours}:${assessmentMinutes}:${assessmentSeconds}`;
      console.log("Assessment DateTime:", formattedAssessmentDateTime);

      // Calculate the difference in milliseconds
      var differenceInMs = assessmentDate - admissionDate;

      // Convert the difference to hours, minutes, and seconds
      var timeDifference = convertMillisecondsToTime(differenceInMs);

      // Format the result to include date and time
      var currentDate = new Date();
      var formattedDate =
        currentDate.getFullYear() +
        "-" +
        ("0" + (currentDate.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + currentDate.getDate()).slice(-2);
      var formattedTime =
        ("0" + timeDifference.hours).slice(-2) +
        ":" +
        ("0" + timeDifference.minutes).slice(-2) +
        ":" +
        ("0" + timeDifference.seconds).slice(-2);

      $scope.calculatedResult = formattedDate + " " + formattedTime;
      $scope.calculatedResultTime = formattedTime;
      $scope.formattedAdmissionDateTime = formattedAdmissionDateTime;
      $scope.formattedAssessmentDateTime = formattedAssessmentDateTime;

      // Store the result in the feedback object for further use
      $scope.feedback.calculatedResult = $scope.calculatedResult;
      $scope.feedback.calculatedResultTime = $scope.calculatedResultTime;
      $scope.feedback.initial_assessment_hr1 =
        $scope.formattedAdmissionDateTime;
      $scope.feedback.initial_assessment_hr2 =
        $scope.formattedAssessmentDateTime;

      console.log(
        "Calculated Result Time:",
        $scope.feedback.calculatedResultTime
      );

      $scope.assessmentCalculated = true;
    };

    //Audit frequency
    $scope.setupapplication2 = function () {
      //$rootScope.loader = true;
      var url = window.location.href;
      //console.log(url);
      var id = url.substring(url.lastIndexOf("=") + 1);
      //alert(id);
      $http
        .get(
          $rootScope.baseurl_main + "/audit_load_frequency.php?patientid=" + id,
          { timeout: 20000 }
        )
        .then(
          function (responsedata) {
            $scope.auditfrequency = responsedata.data;
            console.log($scope.auditfrequency);
            $scope.loadAuditCounts();
          },
          function myError(response) {
            $rootScope.loader = false;
          }
        );
    };

    $scope.showAuditMsg = false;

    $scope.closeAuditMsg = function () {
      $scope.showAuditMsg = false;
    };

    $scope.loadAuditCounts = function () {
      var url = window.location.href;
      var id = url.substring(url.lastIndexOf("=") + 1);

      $http
        .get(
          $rootScope.baseurl_main +
            "/audit_count.php?patientid=" +
            id +
            "&month=" +
            $scope.selectedMonths +
            "&year=" +
            $scope.selectedYears +
            "&table=" +
            "bf_feedback_lab_wait_time",
          { timeout: 20000 }
        )
        .then(function (res) {
          var monthCount = parseInt(res.data.conducted_month, 10) || 0;
          var lastDate = res.data.previous_audit_date || "N/A";
          var yearCount = parseInt(res.data.conducted_year, 10) || 0;
          var lastDateYear = res.data.last_audit_date_year || "N/A";

          var recList =
            $scope.auditfrequency &&
            Array.isArray($scope.auditfrequency.auditfrequency)
              ? $scope.auditfrequency.auditfrequency
              : [];
          var rec = recList[4] || {};

          var freqRaw = (rec.frequency || "").toString().trim();
          var freq = freqRaw.toLowerCase();
          var audit_type = rec.audit_type;
          var target = rec.target;
          var title = rec.title || "This audit";

          var isRandom = freq === "random audit";

          var isMonthlyType =
            freq === "daily" ||
            freq === "weekly" ||
            freq === "monthly" ||
            freq === "twice a week" ||
            freq.indexOf("fortnight") !== -1;

          var remaining = isMonthlyType
            ? Math.max(target - monthCount, 0)
            : "—";
          var extra = isMonthlyType ? Math.max(monthCount - target, 0) : "—";

          $scope.auditFreq = freqRaw;
          $scope.title = title;
          $scope.audit_type = audit_type;
          $scope.auditTargetPerMonth = isMonthlyType || isRandom ? target : "—";
          $scope.auditLastDate = lastDate;
          $scope.auditConductedMonth = monthCount;

          $scope.showRemaining = isMonthlyType;
          $scope.auditRemaining = isMonthlyType ? remaining : "—";

          if (isMonthlyType) {
            if (target > 0 && monthCount >= target) {
              $scope.auditStatusMessage =
                "Minimum monthly target met. Completed " +
                monthCount +
                (extra > 0 ? " (+" + extra + " above target)" : "") +
                ". Last audit on " +
                lastDate +
                ".";
              $scope.auditSentence =
                "The " +
                title +
                " is conducted " +
                freqRaw +
                " with a minimum target of " +
                target +
                " audits this month. The target has been achieved, with " +
                monthCount +
                " completed" +
                (extra > 0 ? " (" + extra + " above target)" : "") +
                ". The last audit was performed on " +
                lastDate +
                ".";
            } else {
              $scope.auditStatusMessage =
                "Minimum monthly target: " +
                target +
                ". Completed " +
                monthCount +
                "; " +
                remaining +
                " to target. Last audit on " +
                lastDate +
                ".";
              $scope.auditSentence =
                "The " +
                title +
                " is conducted " +
                freqRaw +
                " with a minimum target of " +
                target +
                " audits this month. So far, " +
                monthCount +
                " audits have been conducted, leaving " +
                remaining +
                " to reach the target. The last audit was performed on " +
                lastDate +
                ".";
            }
          } else if (freq === "random audit") {
            // Random: show target (sample size) and completed; do not mention "remaining"
            $scope.auditStatusMessage =
              "Target sample size (minimum per month): " +
              target +
              ". Completed this month: " +
              monthCount +
              ". Last audit on " +
              lastDate +
              ".";
            $scope.auditSentence =
              "The " +
              title +
              " is conducted as a Random audit with a minimum monthly sample size of " +
              target +
              ". So far, " +
              monthCount +
              " audits have been conducted this month. The last audit was performed on " +
              lastDate +
              ".";
          } else if (freq === "quarterly") {
            var yrTargetQ = 4,
              yrRemainQ = Math.max(yrTargetQ - yearCount, 0),
              yrExtraQ = Math.max(yearCount - yrTargetQ, 0);
            $scope.auditTargetPerYear = yrTargetQ;
            $scope.auditConductedYear = yearCount;
            $scope.auditRemainingYear = yrRemainQ;
            $scope.auditLastDateYear = lastDateYear;

            $scope.auditStatusMessage =
              "Minimum yearly target (Quarterly): " +
              yrTargetQ +
              ". Completed " +
              yearCount +
              (yrExtraQ > 0 ? " (+" + yrExtraQ + " above target)" : "") +
              ". Last audit in " +
              $scope.selectedYears +
              " on " +
              lastDateYear +
              ".";
            $scope.auditSentence =
              "The " +
              title +
              " is conducted Quarterly with a minimum target of " +
              yrTargetQ +
              " audits in " +
              $scope.selectedYears +
              ". " +
              (yrRemainQ > 0
                ? "So far, " +
                  yearCount +
                  " have been conducted, leaving " +
                  yrRemainQ +
                  " to reach the target. "
                : "Completed " +
                  yearCount +
                  (yrExtraQ > 0
                    ? " (" + yrExtraQ + " above target). "
                    : ". ")) +
              "The last audit in " +
              $scope.selectedYears +
              " was performed on " +
              lastDateYear +
              ".";
          } else if (freq === "half-yearly" || freq === "half yearly") {
            var yrTargetH = 2,
              yrRemainH = Math.max(yrTargetH - yearCount, 0),
              yrExtraH = Math.max(yearCount - yrTargetH, 0);
            $scope.auditTargetPerYear = yrTargetH;
            $scope.auditConductedYear = yearCount;
            $scope.auditRemainingYear = yrRemainH;
            $scope.auditLastDateYear = lastDateYear;

            $scope.auditStatusMessage =
              "Minimum yearly target (Half-Yearly): " +
              yrTargetH +
              ". Completed " +
              yearCount +
              (yrExtraH > 0 ? " (+" + yrExtraH + " above target)" : "") +
              ". Last audit in " +
              $scope.selectedYears +
              " on " +
              lastDateYear +
              ".";
            $scope.auditSentence =
              "The " +
              title +
              " is conducted Half-Yearly with a minimum target of " +
              yrTargetH +
              " audits in " +
              $scope.selectedYears +
              ". " +
              (yrRemainH > 0
                ? "So far, " +
                  yearCount +
                  " have been conducted, leaving " +
                  yrRemainH +
                  " to reach the target. "
                : "Completed " +
                  yearCount +
                  (yrExtraH > 0
                    ? " (" + yrExtraH + " above target). "
                    : ". ")) +
              "The last audit in " +
              $scope.selectedYears +
              " was performed on " +
              lastDateYear +
              ".";
          } else if (freq === "annual") {
            var yrTargetA = 1,
              yrRemainA = Math.max(yrTargetA - yearCount, 0),
              yrExtraA = Math.max(yearCount - yrTargetA, 0);
            $scope.auditTargetPerYear = yrTargetA;
            $scope.auditConductedYear = yearCount;
            $scope.auditRemainingYear = yrRemainA;
            $scope.auditLastDateYear = lastDateYear;

            $scope.auditStatusMessage =
              "Minimum yearly target (Annual): " +
              yrTargetA +
              ". Completed " +
              yearCount +
              (yrExtraA > 0 ? " (+" + yrExtraA + " above target)" : "") +
              ". Last audit in " +
              $scope.selectedYears +
              " on " +
              lastDateYear +
              ".";
            $scope.auditSentence =
              "The " +
              title +
              " is conducted Annually with a minimum target of " +
              yrTargetA +
              " audit in " +
              $scope.selectedYears +
              ". " +
              (yrRemainA > 0
                ? "So far, " +
                  yearCount +
                  " have been conducted, leaving " +
                  yrRemainA +
                  " to reach the target. "
                : "Completed " +
                  yearCount +
                  (yrExtraA > 0
                    ? " (" + yrExtraA + " above target). "
                    : ". ")) +
              "The last audit in " +
              $scope.selectedYears +
              " was performed on " +
              lastDateYear +
              ".";
          } else {
            $scope.auditStatusMessage = "";
            $scope.auditSentence = "";
          }

          console.log($scope.auditSentence);
          $scope.showAuditMsg = true;
        });
    };

    $scope.setupapplication2();

    //aduit frequency end

    // Navigate to a specific page
    $scope.prev = function () {
      window.location.href = "/audit_forms";
    };

    //color for time based on comparision
    const benchmark = 4 * 3600;
    function convertToSeconds(timeStr) {
      const [hours, minutes, seconds] = timeStr.split(":").map(Number);
      return hours * 3600 + minutes * 60 + seconds;
    }

    $scope.getTextColor = function () {
      const calculatedSeconds = convertToSeconds($scope.calculatedResult);
      return calculatedSeconds <= benchmark ? "green" : "red";
    };

    // re-size of textarea based on long text
    function autoResizeTextArea(textarea) {
      // Reset height to auto to allow expansion
      textarea.style.height = "auto";

      // Set the height to the scrollHeight to auto-resize
      textarea.style.height = textarea.scrollHeight + "px";
    }

    var d = new Date();
    $scope.feedback.datetime = d.getTime();
    var params = new URLSearchParams(window.location.search);
    var srcValue = params.get("src");
    $scope.savefeedback = function () {
      if (!$scope.assessmentCalculated) {
        alert("Please calculate before saving.");
        return;
      }

      function isFeedbackValid() {
        if (
          !$scope.feedback.audit_by ||
          ($scope.feedback.audit_by + "").trim() === ""
        ) {
          alert("Please enter audit by");
          return;
        }
       if ($scope.feedback.mid_no == '' || $scope.feedback.mid_no == undefined) {
				alert('Please enter your UHID');
				return false;
			}
        if (
          !$scope.feedback.patient_name ||
          ($scope.feedback.patient_name + "").trim() === ""
        ) {
          alert("Please enter Patient Name");
          return;
        }
        if (
          !$scope.feedback.location ||
          ($scope.feedback.location + "").trim() === ""
        ) {
          alert("Please select Area");
          return;
        }
        if (
          !$scope.feedback.attended_doctor ||
          ($scope.feedback.attended_doctor + "").trim() === ""
        ) {
          alert("Please select Attended Doctor");
          return;
        }

        if (!$scope.feedback.initial_assessment_hr6) {
          alert("Please enter admission date.");
          return; // stop submission
        }
        if (
          $scope.feedback.testname == "" ||
          $scope.feedback.testname == undefined
        ) {
          alert("Please enter test name");
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
        var month = ("0" + (d.getMonth() + 1)).slice(-2);
        var day = ("0" + d.getDate()).slice(-2);
        var hours = ("0" + d.getHours()).slice(-2);
        var minutes = ("0" + d.getMinutes()).slice(-2);

        return `${year}-${month}-${day} ${hours}:${minutes}`;
      };

      // Format date fields
      $scope.feedback.audit_date = formatDateToLocalString(
        $scope.feedback.audit_date
      );
      $scope.feedback.initial_assessment_hr1 = formatDateToLocalString(
        $scope.feedback.initial_assessment_hr1
      );
      $scope.feedback.initial_assessment_hr2 = formatDateToLocalString(
        $scope.feedback.initial_assessment_hr2
      );

      // Validation checks
      if (
        !$scope.feedback.initial_assessment_hr1 ||
        isNaN(new Date($scope.feedback.initial_assessment_hr1).getTime())
      ) {
        alert("Please select bill prepared time.");
        return;
      }

      if (
        !$scope.feedback.initial_assessment_hr2 ||
        isNaN(new Date($scope.feedback.initial_assessment_hr2).getTime())
      ) {
        alert("Please select sample received time.");
        return;
      }

      if (
        new Date($scope.feedback.initial_assessment_hr2) <=
        new Date($scope.feedback.initial_assessment_hr1)
      ) {
        alert("Sample received time must be greater than bill prepared time.");
        return;
      }

      $rootScope.loader = true;

      $scope.feedback.name = $scope.loginname;

      $scope.feedback.contactnumber = $scope.loginnumber;
      $scope.feedback.email = $scope.loginemail;

      // $scope.feedback.questioset = $scope.questioset;
      $http
        .post(
          $rootScope.baseurl_main +
            "/savepatientfeedback_lab_time.php?patient_id=" +
            $rootScope.patientid +
            "&administratorId=" +
            $rootScope.adminId,
          $scope.feedback
        )
        .then(
          function (responsedata) {
            if ((responsedata.status = "success")) {
              $rootScope.loader = false;
              // navigator.showToast('Patient Feedback Submitted Successfully');
              //$location.path('/thankyou');
              $scope.step0 = false;
              $scope.step4 = true;
              $(window).scrollTop(0);
            } else {
              alert("Feeback already submitted for this patient!!");
            }
          },
          function myError(response) {
            $rootScope.loader = false;

            alert("Please check your internet and try again!!");
          }
        );
    };
  }
);
