var app = angular.module("ehandorApp", ["ngSanitize"]);

const d = new Date();

app.controller("PatientFeedbackCtrl", function ($rootScope, $scope, $http, $window, $sce) {
  $scope.typel = "english";
  $scope.type2 = "English";
  $scope.toplogo = false;
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

    // Set the appropriate step to true based on the argument
    if (step === "step0") $scope.step0 = true;
    if (step === "step1") $scope.step1 = true;
    if (step === "step2") $scope.step2 = true;
    if (step === "step3") $scope.step3 = true;
    if (step === "step4") $scope.step4 = true;
    if (step === "step5") $scope.step5 = true;
    if (step === "step6") $scope.step6 = true;

    // Scroll to top of the window
    $(window).scrollTop(0);
  };

  // Function to determine the initial step based on the URL
  $scope.initializeStep = function () {
    // Get the current URL
    var currentUrl = window.location.href;

    // Check if the URL contains 'src=Link'
    if (currentUrl.includes('src=Link')) {
      $scope.activeStep("step2");
      $scope.toplogo = true;
    } else {
      $scope.activeStep("step0");
    }
  };

  // Initialize the step when the controller is loaded
  $scope.initializeStep();



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
  // $scope.redirectToUserActivity = function (event) {
  //   event.preventDefault();
  //   window.location.href = "/view/user_activity";
  // };

  $scope.closeMenuOnClickOutside = function (event) {
    if ($scope.menuVisible && !event.target.closest('.menu-dropdown') && !event.target.closest('.menu-toggle')) {
      $scope.menuVisible = false;
      $scope.$apply(); // Ensure Angular updates the UI
    }
  };

  // Attach event listener when step is active
  $scope.$watchGroup(['step2', 'step3', 'step4', 'step5', 'step6'], function (newVals) {
    if (newVals.includes(true)) {
      document.addEventListener('click', $scope.closeMenuOnClickOutside);
    } else {
      document.removeEventListener('click', $scope.closeMenuOnClickOutside);
    }
  });

  $scope.setLogoutUrl = function () {
    var urlParams = new URLSearchParams(window.location.search);
    var userid = urlParams.get("userid");

    // Check if userid exists in URL
    if (userid) {
      $scope.logoutUrl = "/form_login";
    } else {
      $scope.logoutUrl = "/imf";
    }
  };

  // Call the function when the controller initializes
  $scope.setLogoutUrl();

  $scope.userid = new URLSearchParams(window.location.search).get("user_id") || new URLSearchParams(window.location.search).get("userid");




  $scope.encodeFile = function (element) {
    var file = element.files[0];  // Get the uploaded file
    var formData = new FormData();
    formData.append('file', file);  // Append the file to FormData

    // Use $http to post the file to the server
    $http.post($rootScope.baseurl_main + '/upload_file.php', formData, {
      transformRequest: angular.identity,
      headers: { 'Content-Type': undefined }  // Let the browser set content type
    }).then(function (response) {
      if (response.data.file_url) {
        // Check if file_url is complete. If it's relative, prepend base URL
        var fileUrl = response.data.file_url;
        if (!fileUrl.startsWith('http')) {
          fileUrl = $rootScope.baseurl_main + '/' + fileUrl;
        }

        // Store the file URL and name in the scope for display
        $scope.feedback.file = fileUrl;  // Store the full file URL
        $scope.feedback.fileName = file.name;  // Store the file name for display
      }
    }).catch(function (error) {
      console.error('Error uploading file:', error);
    });
  };




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

  $scope.userid = new URLSearchParams(window.location.search).get("user_id") || new URLSearchParams(window.location.search).get("userid");



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
      alert("Please enter PIN");

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
        // $scope.feedback.section = "INCIDENT";
        // $scope.backtonumber = false;
      } else {
        $scope.activeStep("step2");
        // Assigning values from response to feedback object
        var pinfo = responsedata.data.pinfo;
        $scope.feedback.name = pinfo.name;
        $scope.feedback.admissiondate = pinfo.admited_date;
        $scope.feedback.email = pinfo.email;
        $scope.feedback.image = pinfo.image;
        $scope.feedback.file = pinfo.file;
        $scope.feedback.contactnumber = pinfo.mobile;
        $scope.feedback.bedno = pinfo.bed_no;
        $scope.feedback.role = pinfo.role;
        $scope.feedback.ward = pinfo.ward;
        $scope.feedback.section = "INCIDENT";
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
      alert("Please enter a valid Mobile Number");
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
            // $scope.feedback.section = "INCIDENT";
            // $scope.backtonumber = false;
          } else {

            $scope.step200 = true;
            $scope.step100 = false;

            // Assigning values from response to feedback object
            var pinfo = responsedata.data.pinfo;
            $scope.feedback.tag_name = pinfo.name;
            $scope.feedback.padmissiondate = pinfo.admited_date;
            $scope.feedback.pemail = pinfo.email;
            $scope.feedback.pimage = pinfo.image;
            $scope.feedback.pcontactnumber = pinfo.mobile;
            $scope.feedback.pbedno = pinfo.bed_no;
            $scope.feedback.prole = pinfo.role;
            $scope.feedback.pward = pinfo.ward;
            $scope.feedback.psection = "INCIDENT";
            $scope.feedback.tag_patientid = pinfo.patient_id;


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

  $scope.selectedCategory = null;
  $scope.selectedQuestion = null;
  $scope.isSearchActive = false;

  $scope.searchChanged = function () {
    if ($scope.searchTextmain && $scope.searchTextmain.length >= 3) {
      $scope.isSearchActive = true; // Set the search active flag
      let foundCategory = null;
      let foundQuestion = null;

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

  var urlParams = new URLSearchParams(window.location.search);
  var userId = urlParams.get('user_id'); // Extract user_id from URL
  $scope.userId = userId;

  //IN USED
  $scope.setupapplication = function () {
    // Consider using $location service for extracting URL parameters
    var url = window.location.href;
    var id = url.substring(url.lastIndexOf("=") + 1);

    $http
      .get($rootScope.baseurl_main + "/incident_wards.php?patientid=" + id, {
        timeout: 20000,
      })
      .then(
        function (responsedata) {
          // Ensure data exists before assigning to avoid runtime errors
          if (responsedata.data) {
            $scope.wardlist = responsedata.data;
            $scope.questioset = responsedata.data.question_set;
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
              $scope.userId = matchedUser.emp_id;

              $scope.feedback.name = $scope.userFirstName;
              $scope.feedback.email = $scope.userEmail;
              $scope.feedback.contactnumber = $scope.userNumber;
              $scope.feedback.patientid = $scope.userId;

              $scope.loginemail = $scope.userEmail;
              $scope.loginid = $scope.userId;
              $scope.loginname = $scope.userFirstName;
              $scope.loginnumber = $scope.userNumber;


              console.log("User First Name:", $scope.userFirstName);
              console.log("User Email:", $scope.userEmail);
            } else {
              console.log("No matching user found for user_id:", $scope.userId);
            }

            $scope.bed_no = [];
            $scope.feedback.name = "";
            $scope.feedback.tag_name = "";
            $scope.feedback.admissiondate = "";
            $scope.feedback.email = "";
            $scope.feedback.contactnumber = "";
            $scope.feedback.bedno = "";
            $scope.feedback.ward = "";
            $scope.feedback.image = "";
            $scope.feedback.file = "";
            $scope.feedback.section = "INCIDENT";
            $scope.feedback.patientid = "";
            $scope.feedback.tag_patientid = "";
            if (responsedata.data.pinfo && responsedata.data.pinfo != null) {
              var pinfo = responsedata.data.pinfo;
              $scope.feedback.name = pinfo.name;
              $scope.feedback.tag_name = pinfo.tag_name;
              $scope.feedback.role = pinfo.role;
              $scope.feedback.admissiondate = pinfo.admited_date;
              $scope.feedback.email = pinfo.email;
              $scope.feedback.image = pinfo.image;
              $scope.feedback.file = pinfo.file;
              $scope.feedback.contactnumber = pinfo.mobile;
              $scope.feedback.bedno = pinfo.bed_no;
              $scope.feedback.ward = pinfo.ward;
              $scope.feedback.section = "INCIDENT";
              $scope.feedback.patientid = pinfo.patient_id;
              $scope.feedback.tag_patientid = pinfo.ppatient_id;
            }

            // Compare extracted ID with user_id
            if ($scope.user && Array.isArray($scope.user)) {
              var matchedUser = $scope.user.find(user => user.user_id == id);
              if (matchedUser) {
                $rootScope.adminId = matchedUser.user_id;
              }
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
    $scope.categoryk = Question.categoryk;
    $scope.categorym = Question.categorym;

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

    if ($scope.feedback.incident_type == "" || $scope.feedback.incident_type == undefined) {
      $scope.feedback.incident_type = 'No-harm';
    }
    if ($scope.feedback.priority == "" || $scope.feedback.priority == undefined) {
      $scope.feedback.priority = 'Low';
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

    if ($scope.feedback.tag_name == "" || $scope.feedback.tag_name == undefined) {
      alert("Please enter patient name");
      return false;

    }
    if ($scope.feedback.tag_patientid == "" || $scope.feedback.tag_patientid == undefined) {
      alert("Please enter patient ID");
      return false;

    }
    if ($scope.feedback.tag_patient_type == "" || $scope.feedback.tag_patient_type == undefined) {
      alert("Please select patient type");
      return false;

    }
    if ($scope.feedback.tag_consultant == "" || $scope.feedback.tag_consultant == undefined) {
      alert("Please enter primary consultant");
      return false;

    }

    $scope.tagpatient = true;
    console.log($scope.feedback);
    $('#tagPatientModal').modal('hide');
  };

  $scope.employeename = true;
  $scope.employeeid = true;
  $scope.showmobileno = true;
  $scope.showemail = true;

  $scope.onAnonymousIncidentChange = function () {
    if ($scope.anonymousIncident) {

      $scope.employeeid = true;
      $scope.showmobileno = false;
      $scope.showemail = false;
      $scope.feedback.name = 'Anonymous';
      $scope.feedback.email = '';
      $scope.feedback.contactnumber = '';
      let randomNumber = Math.floor(1000 + Math.random() * 9000); // Ensures a 4-digit number
      $scope.feedback.patientid = 'anys' + randomNumber;
      $scope.loginid = 'anys' + randomNumber;
      console.log("Checkbox is checked: Report the incident anonymously.");
      console.log("Generated Patient ID:", $scope.feedback.patientid);
      $scope.loginname = 'Anonymous';
      $scope.loginemail = '';
      $scope.loginnumber = '';

      console.log("Checkbox is checked: Report the incident anonymously.");
      // Add your logic for handling anonymous incident reporting
    } else {

      $scope.employeename = true;
      $scope.employeeid = true;
      $scope.showmobileno = true;
      $scope.showemail = true;
      $scope.loginemail = ehandor.email;
      $scope.loginid = ehandor.empid;
      $scope.loginname = ehandor.data.name;
      $scope.loginnumber = ehandor.data.mobile;
      $scope.feedback.name = $scope.loginname;
      $scope.feedback.email = $scope.loginemail;
      $scope.feedback.contactnumber = $scope.loginnumber;
      $scope.feedback.patientid = $scope.loginid;
      console.log("Checkbox is unchecked: Report the incident normally.");
      // Add your logic for normal incident reporting
      let randomNumber = Math.floor(1000 + Math.random() * 9000); // Ensures a 4-digit number
      $scope.feedback.patientid = 'anys' + randomNumber;
      $scope.loginid = 'anys' + randomNumber;
    }
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

    $scope.feedback.patientType = "INCIDENT";

    $scope.feedback.administratorId = $rootScope.adminId;

    $scope.feedback.wardid = $rootScope.wardid;

    $scope.feedback.recommend1Score = $scope.recommend1_definite_grey / 2;

    $scope.feedback.reason = {};
    $scope.feedback.comment = {};
    $scope.feedback.comment[$scope.selectedParameterObject.type] = $scope.feedback.other;
    $scope.feedback.reason[$scope.selectedParameterObject.shortkey] = true;
    $scope.feedback.parameter = $scope.selectedQuestionObject;
    $scope.feedback.checkedParameter = $scope.selectedParameterObject;
    // console.log( $scope.feedback);
    // return false;
    $http
      .post(
        $rootScope.baseurl_main +
        "/savepatientfeedback_incident.php?patient_id=" +
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
