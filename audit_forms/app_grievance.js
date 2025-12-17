var app = angular.module("ehandorApp", ["ngSanitize"]);

const d = new Date();

app.controller("PatientFeedbackCtrl", function ($rootScope, $scope, $http, $window) {
  $scope.typel = "english";
  $scope.type2 = "English";

  var ehandor = JSON.parse($window.localStorage.getItem('ehandor'));
  if (ehandor) {
    // Assign the data to scope variables
    $scope.loginemail = ehandor.email;
    $scope.loginid = ehandor.empid;
    $scope.loginname = ehandor.data.name;
    $scope.loginnumber = ehandor.data.mobile;
    console.log($scope.loginemail);
    console.log($scope.loginid);
    console.log($scope.loginname);
    console.log($scope.loginnumber);
    // Similarly, assign other properties as needed
  } else {
    // Handle if data doesn't exist
    console.log('Data not found in local storage');
  }
  if (localStorage.getItem("ehandor")) {
    $rootScope.profilen = JSON.parse(localStorage.getItem('ehandor'));
    // console.log($rootScope.profilen);
  }
  $scope.feedback = {};
  $rootScope.loader = false;
  $rootScope.overallScore = [];
  $rootScope.baseurl_main = window.location.origin + "/api";
  $scope.activeStep = function (step) {
    $scope.step0 = false;
    $scope.step1 = false;
    $scope.step2 = false;
    $scope.step3 = false;
    $scope.step4 = false;
    $scope.step5 = false;
    $scope.step6 = false;

    if (step === "step0") $scope.step0 = true;
    if (step === "step1") $scope.step1 = true;
    if (step === "step2") $scope.step2 = true;
    if (step === "step3") $scope.step3 = true;
    if (step === "step4") $scope.step4 = true;
    if (step === "step5") $scope.step5 = true;
    if (step === "step6") $scope.step6 = true;


    $(window).scrollTop(0);
  };
  $scope.activeStep("step2");


  $scope.months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];

  $scope.years = [
    new Date().getFullYear() - 1,
    new Date().getFullYear(),
    new Date().getFullYear() + 1
  ];

  $scope.selectedMonth = $scope.months[new Date().getMonth()];
  $scope.selectedYear = $scope.years[1];


  $scope.saveSelection = function () {
    // Save month, year, and patient index to localStorage
    localStorage.setItem('selectedMonth', $scope.selectedMonth);
    localStorage.setItem('selectedYear', $scope.selectedYear);

  };

  // Audit range on category
    $scope.hasAuditInRange = function (start, end) {
      for (let i = start; i <= end; i++) {
        let key = 'AUDIT' + i;
        if ($scope.profilen[key]) {
          let label = $scope.lang[key.toLowerCase()] || '';
          if (!$scope.searchAudit || $scope.searchAudit.trim() === '') {
            return true;
          }
          if ($scope.matchSearch(label)) {
            return true;
          }
        }
      }
      return false;
    };

    // Check if any of the given audit numbers exist
$scope.hasAuditList = function (list) {
  for (let i = 0; i < list.length; i++) {
    let key = 'AUDIT' + list[i];
    if ($scope.profilen[key]) {
      let label = $scope.lang[key.toLowerCase()] || '';
      if (!$scope.searchAudit || $scope.searchAudit.trim() === '') {
        return true;
      }
      if ($scope.matchSearch(label)) {
        return true;
      }
    }
  }
  return false;
};


  // Search filter
  $scope.matchSearch = function (text) {
    if (!$scope.searchAudit || $scope.searchAudit.trim() === "") {
      return true; // show all if search empty
    }
    if (!text) {
      return false;
    }
    return text.toLowerCase().indexOf($scope.searchAudit.toLowerCase()) !== -1;
  };




  $scope.encodeImage = function (input) {
    var file = input.files[0];

    if (file) {
      $scope.image = true;
      var reader = new FileReader();

      reader.onload = function (e) {
        // Load the image using image-conversion
        loadImage(
          e.target.result,
          function (img) {
            // Compress the image
            var compressedImageData = img.toDataURL('image/jpeg', 0.1); // Adjust the quality as needed

            // Update the $scope.feedback.image with the compressed image data
            $scope.$apply(function () {
              $scope.feedback.image = compressedImageData;
            });
          },
          { orientation: true, maxWidth: 800 } // Adjust options as needed
        );
      };

      reader.readAsDataURL(file);
    } else {
      $scope.feedback.image = null;
    }
  };

  $scope.menuVisible = false;
  $scope.aboutVisible = false;

  // Function to hide menu only when clicking "Home"
  $scope.hideMenu = function () {
    $scope.menuVisible = false;
  };

  // Function to show all content
  $scope.showAllContent = function () {
    $scope.aboutVisible = false;
    $scope.supportVisible = false;
    $scope.appDownloadVisible = false;
    $scope.dashboardVisible = false;
    $scope.menuVisible = true;
    $scope.hideMenu();
  };


  // Function to show the 'About' content
  $scope.showAbout = function () {
    $scope.menuVisible = false;
    $scope.supportVisible = false;
    $scope.appDownloadVisible = false;
    $scope.dashboardVisible = false;
    $scope.aboutVisible = true;
  };

  // Function to show the 'Support' content
  $scope.showSupport = function () {
    $scope.menuVisible = false;
    $scope.aboutVisible = false;
    $scope.appDownloadVisible = false;
    $scope.dashboardVisible = false;
    $scope.supportVisible = true;
  };

  // Function to show the 'Web dashboard' content
  $scope.showDashboard = function () {
    $scope.menuVisible = false;
    $scope.aboutVisible = false;
    $scope.appDownloadVisible = false;
    $scope.supportVisible = false;
    $scope.dashboardVisible = true;

  };

  // Function to show the 'App download' content
  $scope.showAppDown = function () {
    $scope.menuVisible = false;
    $scope.aboutVisible = false;
    $scope.supportVisible = false;
    $scope.dashboardVisible = false;
    $scope.appDownloadVisible = true;
  };

  // To downlaod the apk
  $scope.downloadApk = function () {
    if ($scope.setting_data && $scope.setting_data.android_apk) {
      window.location.href = $scope.setting_data.android_apk;
    } else {
      alert("APK download link is not available.");
    }
  };

  //To redirect to user activity page
  $scope.redirectToUserActivity = function (event) {
    event.preventDefault();
    window.location.href = "/view/user_activity";
  };

  $scope.closeMenuOnClickOutside = function (event) {
    if ($scope.menuVisible && !event.target.closest('.menu-dropdown') && !event.target.closest('.menu-toggle')) {
      $scope.menuVisible = false;
      $scope.$apply(); // Ensure Angular updates the UI
    }
  };

  // Attach event listener when step is active
  $scope.$watchGroup(['step2', 'step3', 'step4', 'step5'], function (newVals) {
    if (newVals.includes(true)) {
      document.addEventListener('click', $scope.closeMenuOnClickOutside);
    } else {
      document.removeEventListener('click', $scope.closeMenuOnClickOutside);
    }
  });

  $scope.prev_pop = function () {
    $scope.step100 = true;
    $scope.step200 = false;
    $(window).scrollTop(0);
  }

  $scope.next0 = function () {
    // Validation: Check if contact number is defined and in valid range
    if (
      !$scope.feedback.contactnumber ||
      $scope.feedback.contactnumber < 1111111111 ||
      $scope.feedback.contactnumber > 9999999999
    ) {
      alert("Please enter a valid mobile number or email id");
      return false;
    }

    if ($scope.feedback.pin == "" || $scope.feedback.pin == undefined) {
      alert("Please Enter PIN");

      return false;
    }
    // HTTP Request: Fetch data based on the contact number
    $http.get($rootScope.baseurl_main + '/esr_mobile_number.php?mobile=' + $scope.feedback.contactnumber + '&email=' + $scope.feedback.contactnumber + '&pin=' + $scope.feedback.pin, { timeout: 20000 }).then(function (responsedata) {

      if (responsedata.data.pinfo == "NO") {
        alert(responsedata.data.message);
        // $scope.activeStep("step1");
        // $scope.feedback.name =
        //   responsedata.data && responsedata.data.pinfo
        //     ? responsedata.data.pinfo.name
        //     : "";
        // $scope.feedback.section = "GRIEVANCE";
        // $scope.backtonumber = false;
      } else {
        $scope.activeStep("step2");
        // Assigning values from response to feedback object
        var pinfo = responsedata.data.pinfo;
        $scope.feedback.name = pinfo.name;
        $scope.feedback.admissiondate = pinfo.admited_date;
        $scope.feedback.email = pinfo.email;
        $scope.feedback.image = pinfo.image;
        $scope.feedback.contactnumber = pinfo.mobile;
        $scope.feedback.bedno = pinfo.bed_no;
        $scope.feedback.role = pinfo.role;
        $scope.feedback.ward = pinfo.ward;
        $scope.feedback.section = "GRIEVANCE";
        $scope.feedback.patientid = pinfo.patient_id;
        // $scope.backtonumber = true;

        // Ensure to remove or safeguard logging in production
      }
    },
      function myError(response) {
        $rootScope.loader = false;
        alert("An error occurred while fetching data. Please try again."); // User feedback on error
      }
    );
  };
  $scope.step100 = true;
  $scope.next_popup = function () {


    // // Validation: Check if contact number is defined and in valid range
    if (
      !$scope.feedback.patient_number ||
      $scope.feedback.patient_number < 1111111111 ||
      $scope.feedback.patient_number > 9999999999
    ) {
      alert("Please enter a valid mobile number or email id ");
      return false;
    }

    // HTTP Request: Fetch data based on the contact number
    $http
      .get(
        $rootScope.baseurl_main +
        "/mobile_patientfrom_admission.php?mobile=" +
        $scope.feedback.patient_number,
        { timeout: 20000 }
      )
      .then(
        function (responsedata) {
          if (responsedata.data.pinfo == "NO") {
            alert("Error: Unable to proceed to the next page as the mobile number does not match with the available patient data"); // User feedback on error
            // $scope.activeStep("step1");
            // $scope.feedback.name =
            //   responsedata.data && responsedata.data.pinfo
            //     ? responsedata.data.pinfo.name
            //     : "";
            // $scope.feedback.section = "GRIEVANCE";
            // $scope.backtonumber = false;
          } else {

            $scope.step200 = true;
            $scope.step100 = false;

            // Assigning values from response to feedback object
            var pinfo = responsedata.data.pinfo;
            $scope.feedback.pname = pinfo.name;
            $scope.feedback.padmissiondate = pinfo.admited_date;
            $scope.feedback.pemail = pinfo.email;
            $scope.feedback.pimage = pinfo.image;
            $scope.feedback.pcontactnumber = pinfo.mobile;
            $scope.feedback.pbedno = pinfo.bed_no;
            $scope.feedback.prole = pinfo.role;
            $scope.feedback.pward = pinfo.ward;
            $scope.feedback.psection = "GRIEVANCE";
            $scope.feedback.ppatientid = pinfo.patient_id;


            // Ensure to remove or safeguard logging in production
          }
        },
        function myError(response) {
          $rootScope.loader = false;
          alert("An error occurred while fetching data. Please try again."); // User feedback on error
        }
      );
  };


  $scope.pin_popup = function () {

    $http.get($rootScope.baseurl_main + '/forgotten_pin.php?mobile=' + $scope.feedback.pin_contactnumber + '&email=' + $scope.feedback.pin_contactnumber, { timeout: 20000 }).then(function (responsedata) {


      if (responsedata.data.pinfo == "NO") {

        if (
          !$scope.feedback.pin_contactnumber ||
          $scope.feedback.pin_contactnumber < 1111111111 ||
          $scope.feedback.pin_contactnumber > 9999999999
        ) {
          $scope.please = true;
          $('#pinModel').modal('show');
          // Set $scope.no_email back to false after 2 seconds
          setTimeout(function () {
            $scope.$apply(function () {
              $scope.please = false;
            });
          }, 2000);
        } else {

          $scope.no_email = true;
          $('#pinModel').modal('show');

          // Set $scope.no_email back to false after 2 seconds
          setTimeout(function () {
            $scope.$apply(function () {
              $scope.no_email = false;
            });
          }, 2000);
        }

      } else {

        $scope.no_mobile = true;
        $('#pinModel').modal('hide');

        // Set $scope.no_email back to false after 2 seconds
        setTimeout(function () {
          $scope.$apply(function () {
            $scope.no_mobile = false;
          });
        }, 4000);

      }
    },

      function myError(response) {
        $rootScope.loader = false;

      }
    );

  }

  $scope.selectedCategory = null;
  $scope.selectedQuestion = null;
  $scope.isSearchActive = false;

  $scope.searchChanged = function () {
    if ($scope.searchTextmain && $scope.searchTextmain.length >= 3) {
      $scope.isSearchActive = true; // Set the search active flag
      let foundCategory = null;
      let foundQuestion = null;
      console.log(foundQuestion);
      // Loop through each category to find the question.
      for (let category of $scope.questioset) {
        foundQuestion = category.question_set.find(
          (q) =>
            q.question
              .toLowerCase()
              .includes($scope.searchTextmain.toLowerCase()) ||
            q.questionk
              .toLowerCase()
              .includes($scope.searchTextmain.toLowerCase()) ||
            q.questionm
              .toLowerCase()
              .includes($scope.searchTextmain.toLowerCase())
        );
        if (foundQuestion) {
          foundCategory = category;
          $scope.selectedCategory = foundCategory;
          $scope.selectedQuestion = foundQuestion;
          $scope.feedback.comment = {
            settitle: $scope.searchTextmain,
          };
          $scope.activeStep("step3");
          break; // Exit the loop once a match is found
        }
      }

      if (foundQuestion) {
        $scope.selectedCategory = foundCategory;
        $scope.selectedQuestion = foundQuestion;
        $scope.activeStep("step3");
        $scope.activateCard(foundCategory);
      } else {
        $scope.feedback.other = $scope.searchTextmain;
        $scope.feedback.comment = {
          settitle: $scope.searchTextmain,
        };
        $scope.activeStep("step3");
      }
    }
  };

  $scope.isLiTagsEmpty = function (questions) {
    // Check if the li tags are empty
    return !questions || !questions.length || !questions.some(function (p) {
      return (
        p.question.trim() !== '' ||
        p.questionk.trim() !== '' ||
        p.questionm.trim() !== ''
      );
    });
  };

  //for radio button
  $scope.selected = undefined;

  $scope.checkstatus = function (clickedQuestion) {
    angular.forEach($scope.feedback.parameter.question, function (question) {
      if (question === clickedQuestion) {
        question.showQuestion = true; // Show the clicked question
      } else {
        question.showQuestion = false; // Hide other questions

        question.valuetext = false; // Uncheck other checkboxes
      }
    });
  };

  $scope.checkstatus2s = function (z) {
    if (z.Others) {
      // Search for the question in the questioset.
      let foundQuestion = $scope.questioset.find(
        (set) => set.settitle == z.Others
      );

      if (foundQuestion) {
        // If found, activate the card for this question set.
        $scope.activateCard(foundQuestion);

        // Set step3 to true to show the selected question and category.
        $scope.activeStep("step3");
      } else {
        // If the "Others" option is selected and no corresponding question set is found.
        $scope.feedback.other = z.Others;
        $scope.feedback.comment = {
          settitle: z.Others,
        };
        $scope.activeStep("step3");
      }
    } else {
      angular.forEach($scope.feedback.parameter.question, function (question) {
        question.showQuestion = false; // Hide all questions
        question.valuetext = false; // Uncheck all checkboxes
      });
    }
  };

  $scope.questionvalueset = function (v, key, q) {
    $rootScope.positivefeedback = true;

    q.valuetext = v;

    $scope.feedback[key] = v;

    $rootScope.overallScore[key] = v;

    $scope.overallSum($rootScope.overallScore);

    $scope.showerrorbox = false;

    angular.forEach($scope.questioset, function (questioncat, kcat) {
      $scope.questioset[kcat].errortitle = false;
    });

    angular.forEach($scope.feedback, function (value, k) {
      angular.forEach($scope.questioset, function (questioncat, kcat) {
        angular.forEach(questioncat.question, function (questionset, kq) {
          if (k == questionset.shortkey) {
            if (value == 1 || value == 2) {
              $scope.questioset[kcat].errortitle = true;

              $scope.showerrorbox = true;

              $rootScope.positivefeedback = false;

              //$scope.$apply();
            }
          }
        });
      });
    });
  };

  $scope.change_ward = function () {
    var foundWard = $scope.wardlist.ward.find(function (ward) {
      return ward.title === $scope.feedback.ward;
    });

    $scope.bed_no = foundWard.bedno;
    console.log($scope.bed_no);
  };

  //IN USED
  $scope.setupapplication = function () {
    // Consider using $location service for extracting URL parameters
    var url = window.location.href;
    var id = url.substring(url.lastIndexOf("=") + 1);

    $http
      .get($rootScope.baseurl_main + "/grievance_wards.php?patientid=" + id, {
        timeout: 20000,
      })
      .then(
        function (responsedata) {
          // Ensure data exists before assigning to avoid runtime errors
          if (responsedata.data) {
            $scope.wardlist = responsedata.data;
            $scope.questioset = responsedata.data.question_set;
            $scope.setting_data = responsedata.data.setting_data;
            $scope.bed_no = [];
            $scope.feedback.name = "";
            $scope.feedback.pname = "";
            $scope.feedback.admissiondate = "";
            $scope.feedback.email = "";
            $scope.feedback.contactnumber = "";
            $scope.feedback.bedno = "";
            $scope.feedback.ward = "";
            $scope.feedback.image = "";
            $scope.feedback.section = "GRIEVANCE";
            $scope.feedback.patientid = "";
            $scope.feedback.ppatientid = "";
            if (responsedata.data.pinfo && responsedata.data.pinfo != null) {
              var pinfo = responsedata.data.pinfo;
              $scope.feedback.name = pinfo.name;
              $scope.feedback.pname = pinfo.pname;
              $scope.feedback.role = pinfo.role;
              $scope.feedback.admissiondate = pinfo.admited_date;
              $scope.feedback.email = pinfo.email;
              $scope.feedback.image = pinfo.image;
              $scope.feedback.contactnumber = pinfo.mobile;
              $scope.feedback.bedno = pinfo.bed_no;
              $scope.feedback.ward = pinfo.ward;
              $scope.feedback.section = "GRIEVANCE";
              $scope.feedback.patientid = pinfo.patient_id;
              $scope.feedback.ppatientid = pinfo.ppatient_id;
            }
            if ($scope.feedback.name != "") {
              $scope.manageActiveForm("step2");
            }
          } else {
            alert("Data is unavailable or in an incorrect format.");
          }
        },
        function myError(response) {
          $rootScope.loader = false;
          alert("An error occurred while fetching data. Please try again."); // User feedback on error
        }
      );
  };

  $scope.setupapplication();

  $scope.filterFunction = function (item) {
    if (!$scope.searchText || $scope.searchText.length < 2) return true; // If no search text, don't filter.
    var questionInCurrentLang;
    switch ($scope.typel) {
      case "english":
        questionInCurrentLang = item.question;
        break;
      case "lang2":
        questionInCurrentLang = item.questionk;
        break;
      case "lang3":
        questionInCurrentLang = item.questionm;
        break;
    }
    return questionInCurrentLang
      .toLowerCase()
      .includes($scope.searchText.toLowerCase());
  };

  $scope.filterQuestions = function (p) {
    if (!$scope.searchTextmain || $scope.searchTextmain.length < 3) return true; // If no search text or less than 3 characters, show all questions.

    let questionInCurrentLang;
    switch ($scope.typel) {
      case "english":
        questionInCurrentLang = p.question;
        break;
      case "lang2":
        questionInCurrentLang = p.questionk;
        break;
      case "lang3":
        questionInCurrentLang = p.questionm;
        break;
    }
    if (questionInCurrentLang) {
      return questionInCurrentLang
        .toLowerCase()
        .includes($scope.searchTextmain.toLowerCase());
    } else {
      return false;
    }
  };

  $scope.customTicket = function () {
    $scope.showBack = false;
    $scope.submit_as_concern = false;

    $scope.selectedParameterObject = {};
    $scope.feedback.other = $scope.searchTextmain;
    $scope.activeStep("step4");
  };
  $scope.selectQuestionCategory1 = function (Parameter, Question) {
    $scope.showBack = false;
    $scope.submit_as_concern = true;
    //$scope.selectedQuestionObject = Question;
    $scope.selectedQuestionObject = Question;
    var category = Question.category; // Access the 'category' property
    console.log(category);
    $scope.selectedParameterObject = Parameter;
    $scope.activeStep("step4");
  };
  $scope.selectQuestionCategory = function (Parameter, Question) {
    $scope.showBack = true;
    $scope.submit_as_concern = true;
    //$scope.selectedQuestionObject = Question;
    $scope.selectedQuestionObject = Question;
    var category = Question.category; // Access the 'category' property
    console.log(category);
    $scope.selectedParameterObject = Parameter;
    $scope.activeStep("step4");
  };
  $scope.OtherCategorySelected = '';
  // $scope.selectValuefromOption = function(){
  //   console.log('12321312312');
  //   console.log($scope.OtherCategorySelected);

  // }

  $scope.selectedQuestionObject = {};
  $scope.selectedParameterObject = {};
  $scope.showBack = false;
  $scope.selectQuestion = function (Question) {
    $scope.showBack = true;

    // Assign the value to category in the higher scope
    $scope.category = Question.category;

    $scope.selectedQuestionObject = Question;
    console.log($scope.category);
    $scope.activeStep("step3");
  };

  $scope.activateStepBasedOnShowBack = function () {
    if ($scope.showBack) {
      $scope.activeStep('step3');
    } else {
      $scope.activeStep('step2');
    }
  };

  $scope.activateCard = function (selectedItem) {
    $scope.activeStep("step3");

    $scope.condition2 = true;
  };

  $scope.dropdownvalue = "";

  // $scope.feedback.parameter = [];

  $scope.feedback.other = "";

  // $scope.feedback.source = 1;
  $scope.dept = false;

  $scope.activateselected = function () {
    $scope.feedback.parameter = {};

    angular.forEach($scope.questioset, function (value, key) {
      if (value.settitle == $scope.dropdownvalue) {
        $scope.feedback.parameter = value;
        console.log($scope.feedback.parameter);
        $scope.dept = true;

      }
    });
  };

  $scope.next1 = function () {
    // Simplified validation checks with clear messages
    if (!$scope.feedback.name) {
      alert("Please enter a valid Patient Name");
      return false;
    }

    if (!$scope.feedback.patientid) {
      alert("Please enter your UHID");
      return false;
    }

    if (!$scope.feedback.role) {
      alert("Please select your role");
      return false;
    }

    // Check if contact number is valid when it is provided
    if (
      $scope.feedback.contactnumber &&
      ($scope.feedback.contactnumber < 1111111111 ||
        $scope.feedback.contactnumber > 9999999999)
    ) {
      alert("Please enter a valid Mobile Number");
      return false;
    }

    // Proceed to the next step if all validations pass
    $scope.activeStep("step2");
  };

  $scope.next4 = function () {

    if ($scope.feedback.other == "" || $scope.feedback.other == undefined) {

      $scope.description = false;

    } else {
      $scope.description = true;
    }




    if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
      $scope.feedback.ward = 'Others';
    }
    if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
      $scope.bed_no = ['Others'];
      $scope.feedback.bedno = 'Others';
    }

    // Proceed to the next step if all validations pass
    $scope.activeStep("step5");
  };



  var d = new Date();

  $scope.feedback.datetime = d.getTime();

  $scope.save_popup = function () {

    if ($scope.feedback.pname == "" || $scope.feedback.pname == undefined) {
      alert("Please enter patient name");
      return false;

    }
    if ($scope.feedback.ppatientid == "" || $scope.feedback.ppatientid == undefined) {
      alert("Please enter patient ID");
      return false;

    }
    if ($scope.feedback.patient_type == "" || $scope.feedback.patient_type == undefined) {
      alert("Please select patient type");
      return false;

    }
    if ($scope.feedback.pconsultant == "" || $scope.feedback.pconsultant == undefined) {
      alert("Please enter primary consultant");
      return false;

    }

    $scope.tagpatient = true;
    console.log($scope.feedback);
    $('#tagPatientModal').modal('hide');
  };

  $scope.savefeedback = function () {

    if (!$scope.selectedParameterObject.question) {
      angular.forEach($scope.questioset, function (value, key) {
        if (value.settitle == $scope.OtherCategorySelected) {
          $scope.selectedQuestionObject = value;

          angular.forEach($scope.selectedQuestionObject.question, function (v, k) {
            if (v.question == 'Others') {
              $scope.selectedParameterObject = v;
              $scope.selectedQuestionObject.question[k].valuetext = true;
            }
          })

        }

      });

      if (!$scope.selectedParameterObject.question) {
        let lastQuestion = $scope.questioset.slice(-1);
        lastQuestion[0].question[0].valuetext = true;
        $scope.selectedQuestionObject = lastQuestion[0];
        $scope.selectedParameterObject = lastQuestion[0].question[0];
      }

    }
    if ($scope.selectedParameterObject.shortname == 'Other' || $scope.selectedParameterObject.question == 'Others') {
      if ($scope.feedback.other == '' || $scope.feedback.other == undefined) {
        alert("Please Provide a comment because you have selected Other.");
        return false;
      }
    }

    $scope.feedback.name = $scope.loginname;
    $scope.feedback.email = $scope.loginemail;
    $scope.feedback.contactnumber = $scope.loginnumber;
    $scope.feedback.patientid = $scope.loginid;

    $rootScope.loader = true;

    $scope.feedback.patientType = "GRIEVANCE";

    $scope.feedback.administratorId = $rootScope.adminId;

    $scope.feedback.wardid = $rootScope.wardid;

    $scope.feedback.recommend1Score = $scope.recommend1_definite_grey / 2;

    $scope.feedback.reason = {};
    $scope.feedback.comment = {};
    $scope.feedback.comment[$scope.selectedParameterObject.type] = $scope.feedback.other;
    $scope.feedback.reason[$scope.selectedParameterObject.shortkey] = true;
    // $scope.feedback.parameter = $scope.selectedQuestionObject;
    // console.log( $scope.feedback);
    // return false;
    $http
      .post(
        $rootScope.baseurl_main +
        "/savepatientfeedback_grievance.php?patient_id=" +
        $scope.feedback.patientid +
        "&administratorId=" +
        $rootScope.adminId,
        $scope.feedback

      )
      .then(
        function (responsedata) {
          if ((responsedata.status = "success")) {
            $rootScope.loader = false;
            $scope.activeStep("step6");
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



  var params = new URLSearchParams(window.location.search);
  var srcValue = params.get("src");
  if (srcValue == "" || srcValue == undefined) {
    $scope.feedback.source = "WLink";
  } else {
    // alert(srcValue);
    $scope.feedback.source = srcValue;
  }



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

  $rootScope.language("english");
});
