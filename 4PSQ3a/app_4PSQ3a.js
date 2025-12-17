var app = angular.module("ehandorApp", []);
// adf
app.controller(
  "PatientFeedbackCtrl",
  function ($rootScope, $scope, $http, $location, $window, $timeout) {
    $scope.typel = "english";
    $scope.type2 = "English";
    $scope.feedback = {};

    $rootScope.loader = false;
    $rootScope.overallScore = [];
    $rootScope.baseurl_main = window.location.origin + "/api";
    $scope.step0 = false;
    $scope.step1 = true;
    $scope.step4 = false;

    var selectedMonths = $window.localStorage.getItem("selectedMonth");
    console.log(selectedMonths); // This will log "June"
    var selectedYears = $window.localStorage.getItem("selectedYear");
    console.log(selectedYears); // This will log "2024"

    $scope.selectedMonths = $window.localStorage.getItem("selectedMonth");
    $scope.selectedYears = $window.localStorage.getItem("selectedYear");

    //Code for deadline of submission of KPI
    function monthNameToIndex(name) {
      const map = {
        january: 0,
        february: 1,
        march: 2,
        april: 3,
        may: 4,
        june: 5,
        july: 6,
        august: 7,
        september: 8,
        october: 9,
        november: 10,
        december: 11,
      };
      return map[String(name).toLowerCase().trim()];
    }

    function computeDeadline(monthName, yearStr) {
      const m = monthNameToIndex(monthName);
      const y = parseInt(yearStr, 10);
      if (m == null || isNaN(y)) return null;
      let nextMonth = m + 1,
        nextYear = y;
      if (nextMonth > 11) {
        nextMonth = 0;
        nextYear += 1;
      }
      const d = new Date(nextYear, nextMonth, 8);
      d.setHours(23, 59, 59, 999);
      return d;
    }

    function formatKPIDate(d, longWeekday = false) {
      if (!d) return "";
      const DAY = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
      const DAY_LONG = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ];
      const MONTH_ABBR = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sept",
        "Oct",
        "Nov",
        "Dec",
      ];
      const dd = d.getDate();
      const m = MONTH_ABBR[d.getMonth()];
      const y = d.getFullYear();
      const wd = longWeekday ? DAY_LONG[d.getDay()] : DAY[d.getDay()];
      return `${dd} ${m} ${y} (${wd})`;
    }

    $scope.kpiDeadline = computeDeadline(
      $scope.selectedMonths,
      $scope.selectedYears
    );

    $scope.formatKPIDate = formatKPIDate;

    $scope.deadlineMessage =
      "KPI submission deadline for " +
      $scope.selectedMonths +
      " " +
      $scope.selectedYears +
      " is " +
      formatKPIDate($scope.kpiDeadline, false) +
      ".";

    $timeout(function () {
      if ($scope.kpiDeadline) {
        angular.element("#deadlineModal").modal("show");
      }
    }, 500);

    //End for deadline of submission of KPI(rest code in html)

    //Code for deadline of submission of KPI
    function monthNameToIndex(name) {
      const map = {
        january: 0,
        february: 1,
        march: 2,
        april: 3,
        may: 4,
        june: 5,
        july: 6,
        august: 7,
        september: 8,
        october: 9,
        november: 10,
        december: 11,
      };
      return map[String(name).toLowerCase().trim()];
    }

    function computeDeadline(monthName, yearStr) {
      const m = monthNameToIndex(monthName);
      const y = parseInt(yearStr, 10);
      if (m == null || isNaN(y)) return null;
      let nextMonth = m + 1,
        nextYear = y;
      if (nextMonth > 11) {
        nextMonth = 0;
        nextYear += 1;
      }
      const d = new Date(nextYear, nextMonth, 8);
      d.setHours(23, 59, 59, 999);
      return d;
    }

    function formatKPIDate(d, longWeekday = false) {
      if (!d) return "";
      const DAY = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
      const DAY_LONG = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ];
      const MONTH_ABBR = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sept",
        "Oct",
        "Nov",
        "Dec",
      ];
      const dd = d.getDate();
      const m = MONTH_ABBR[d.getMonth()];
      const y = d.getFullYear();
      const wd = longWeekday ? DAY_LONG[d.getDay()] : DAY[d.getDay()];
      return `${dd} ${m} ${y} (${wd})`;
    }

    $scope.kpiDeadline = computeDeadline(
      $scope.selectedMonths,
      $scope.selectedYears
    );

    $scope.formatKPIDate = formatKPIDate;

    $scope.deadlineMessage =
      "KPI submission deadline for " +
      $scope.selectedMonths +
      " " +
      $scope.selectedYears +
      " is " +
      formatKPIDate($scope.kpiDeadline, false) +
      ".";

    $timeout(function () {
      if ($scope.kpiDeadline) {
        angular.element("#deadlineModal").modal("show");
      }
    }, 500);

    //End for deadline of submission of KPI(rest code in html)

    $rootScope.language = function (type) {
      $scope.typel = type;
      if (type == "english") {
        $http.get("language/english.json").then(function (responsedata) {
          $rootScope.lang = responsedata.data;
          $scope.type2 = "English";
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

    $scope.setupapplication = function () {
      //$rootScope.loader = true;
      var url = window.location.href;
      //console.log(url);
      var id = url.substring(url.lastIndexOf("=") + 1);
      //alert(id);
      $http
        .get(
          $rootScope.baseurl_main +
            "/api_4PSQ3a.php?patientid=" +
            id +
            "&month=" +
            selectedMonths +
            "&year=" +
            selectedYears,
          { timeout: 20000 }
        )
        .then(
          function (responsedata) {
            $scope.feedback.initial_assessment_hr =
              responsedata.data.medication_errors_count;
            $scope.feedback.total_admission = responsedata.data.incident_count;
            console.log($scope.medication_errors_count);
          },
          function myError(response) {
            $rootScope.loader = false;
          }
        );
    };
    $scope.setupapplication();

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

    var ehandor = JSON.parse($window.localStorage.getItem("ehandor"));
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
      console.log("Data not found in local storage");
    }

    $scope.valuesEdited = false; // Flag to track if values have been edited

    // Function to call when values are edited
    $scope.onValuesEdited = function () {
      $scope.valuesEdited = true;
    };

    document
      .getElementById("formula_para1")
      .addEventListener("input", $scope.onValuesEdited);
    document
      .getElementById("formula_para2")
      .addEventListener("input", $scope.onValuesEdited);

    $scope.calculateMedicationErrorRate = function () {
      // Get the number of medication errors
      var medicationErrors = parseInt(
        document.getElementById("formula_para1").value
      );

      // Get the number of opportunities for medication errors
      var opportunitiesForErrors = parseInt(
        document.getElementById("formula_para2").value
      );

      // Validate inputs (only check NaN, allow 0)
      if (isNaN(medicationErrors) || medicationErrors < 0) {
        alert("Enter the number of medication errors.");
        return;
      }

      if (isNaN(opportunitiesForErrors)) {
        alert("Enter the number of opportunities for errors.");
        return;
      }

      // Skip comparison if denominator is 0
      if (
        opportunitiesForErrors > 0 &&
        medicationErrors > opportunitiesForErrors
      ) {
        alert(
          "The no. of medication errors must be less than the no. of opportunities for errors."
        );
        return;
      }

      // Calculate the medication error rate — safe zero handling
      var errorRatePercentage;
      if (opportunitiesForErrors === 0) {
        errorRatePercentage = 0; // avoid division by zero
      } else {
        errorRatePercentage = (medicationErrors / opportunitiesForErrors) * 100;
      }

      // Format result: whole number or 2 decimals
      if (errorRatePercentage % 1 === 0) {
        $scope.calculatedResult = errorRatePercentage.toString();
      } else {
        $scope.calculatedResult = errorRatePercentage.toFixed(2);
      }

      // Store result
      $scope.feedback.calculatedResult = $scope.calculatedResult;

      console.log("Calculated result", $scope.calculatedResult);
      $scope.valuesEdited = false;
    };

    $scope.currentMonthYear = getCurrentMonthYear();

    // Navigate to a specific page
    $scope.prev = function () {
      window.location.href = "/qim_forms/?src=Link";
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
      if (!$scope.selectedMonths || !$scope.selectedYears) {
        alert("Please choose the month and year before submitting.");
        return;
      }

      if ($scope.valuesEdited) {
        alert("Please calculate before submitting the form.");
        return false;
      }

      if (
        $scope.feedback.dataAnalysis == "" ||
        $scope.feedback.dataAnalysis == undefined
      ) {
        alert("Please enter data analysis");
        return false;
      }

      if (
        $scope.feedback.correctiveAction == "" ||
        $scope.feedback.correctiveAction == undefined
      ) {
        alert("Please enter corrective action");
        return false;
      }

      if (
        $scope.feedback.preventiveAction == "" ||
        $scope.feedback.preventiveAction == undefined
      ) {
        alert("Please enter preventive action");
        return false;
      }
      if (
        $scope.feedback.initial_assessment_hr > $scope.feedback.total_admission
      ) {
        alert(
          "The no. of medication errors must be less than the no. of opportunities for errors."
        );
        return false;
      }

      // First check for duplicates
      $http
        .get(
          $rootScope.baseurl_main +
            "/quality_duplication_submission.php?patient_id=" +
            $rootScope.patientid +
            "&month=" +
            $scope.selectedMonths +
            "&year=" +
            $scope.selectedYears +
            "&table=" +
            "bf_feedback_4PSQ3a"
        )
        .then(
          function (response) {
            if (response.data.status === "exists") {
              alert("The KPI is already recorded for this month");
              return;
            } else {
              $rootScope.loader = true;
              $scope.feedback.benchmark = "04:00:00";
              $scope.feedback.name = $scope.loginname;
              $scope.feedback.patientid = $scope.loginid;
              $scope.feedback.contactnumber = $scope.loginnumber;
              $scope.feedback.email = $scope.loginemail;

              // $scope.feedback.questioset = $scope.questioset;
              $http
                .post(
                  $rootScope.baseurl_main +
                    "/savepatientfeedback_kpi4.php?patient_id=" +
                    $rootScope.patientid +
                    "&administratorId=" +
                    $rootScope.adminId +
                    "&month=" +
                    selectedMonths +
                    "&year=" +
                    selectedYears,
                  $scope.feedback
                )
                .then(
                  function (responsedata) {
                    if ((responsedata.status = "success")) {
                      $rootScope.loader = false;
                      // navigator.showToast('Patient Feedback Submitted Successfully');
                      //$location.path('/thankyou');
                      $scope.step1 = false;
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
            }
          },
          function (error) {
            alert("Error while checking existing KPI");
          }
        );
    };
  }
);
