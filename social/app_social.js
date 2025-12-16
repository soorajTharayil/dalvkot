var app = angular.module("ehandorApp", ["ngSanitize"]);

const d = new Date();

app.controller("PatientFeedbackCtrl", function ($rootScope, $scope, $http) {
  $scope.typel = "english";
  $scope.type2 = "English";
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

    if (step === "step0") $scope.step0 = true;
    if (step === "step1") $scope.step1 = true;
    if (step === "step2") $scope.step2 = true;
    if (step === "step3") $scope.step3 = true;
    if (step === "step4") $scope.step4 = true;
    if (step === "step5") $scope.step5 = true;
    $(window).scrollTop(0);
  };
  $scope.activeStep("step1");

  $scope.next0 = function () {
    // Validation: Check if contact number is defined and in valid range
    if (
      !$scope.feedback.contactnumber ||
      $scope.feedback.contactnumber < 1111111111 ||
      $scope.feedback.contactnumber > 9999999999
    ) {
      alert("Please enter a valid Mobile Number");
      return false;
    }

    // HTTP Request: Fetch data based on the contact number
    $http
      .get(
        $rootScope.baseurl_main +
        "/mobile_interim.php?mobile=" +
        $scope.feedback.contactnumber,
        { timeout: 20000 }
      )
      .then(
        function (responsedata) {
          if (responsedata.data.pinfo == "NO") {
            $scope.activeStep("step1");
            $scope.feedback.name =
              responsedata.data && responsedata.data.pinfo
                ? responsedata.data.pinfo.name
                : "";
            $scope.feedback.section = "SOCIAL";
            $scope.backtonumber = false;
          } else {
            $scope.activeStep("step2");
            // Assigning values from response to feedback object
            var pinfo = responsedata.data.pinfo;
            $scope.feedback.name = pinfo.name;
            $scope.feedback.admissiondate = pinfo.admited_date;
            $scope.feedback.email = pinfo.email;
            $scope.feedback.contactnumber = pinfo.mobile;
            $scope.feedback.bedno = pinfo.bed_no;
            $scope.feedback.bednok = pinfo.bed_nok;
            $scope.feedback.bednom = pinfo.bed_nom;
            $scope.feedback.ward = pinfo.ward;
            $scope.feedback.section = "SOCIAL";
            $scope.feedback.patientid = pinfo.patient_id;
            $scope.backtonumber = true;

            // Ensure to remove or safeguard logging in production
          }
        },
        function myError(response) {
          $rootScope.loader = false;
          alert("An error occurred while fetching data. Please try again."); // User feedback on error
        }
      );
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

  //IN USED
  $scope.setupapplication = function () {
    // Consider using $location service for extracting URL parameters
    var url = window.location.href;
    var id = url.substring(url.lastIndexOf("=") + 1);

    $http
      .get($rootScope.baseurl_main + "/ward_social.php?patientid=" + id, {
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
            $scope.bed_nok = [];
            $scope.bed_nom = [];
            $scope.feedback.name = "";
            $scope.feedback.admissiondate = "";
            $scope.feedback.email = "";
            $scope.feedback.contactnumber = "";
            $scope.feedback.bedno = "";
            $scope.feedback.bednok = "";
            $scope.feedback.bednom = "";
            $scope.feedback.ward = "";
            $scope.feedback.section = "SOCIAL";
            $scope.feedback.patientid = "";
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
              $scope.feedback.section = "SOCIAL";
              $scope.feedback.patientid = pinfo.patient_id;
            }
            if ($scope.feedback.name != "") {
              $scope.activeStep("step2");
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
    if (!$scope.searchText || $scope.searchText.length < 3) return true; // If no search text, don't filter.
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
    console.log($scope.submit_as_concern);
     $scope.selectedParameterObject = {};


    $scope.feedback.other = $scope.searchTextmain;
    $scope.activeStep("step4");
  };

  $scope.selectQuestionCategory1 = function (Parameter, Question) {
    $scope.showBack = false;
    $scope.submit_as_concern = true;

    //$scope.selectedQuestionObject = Question;
    $scope.selectedQuestionObject = Question;
    $scope.selectedParameterObject = Parameter;
    $scope.activeStep("step4");
  };

  $scope.selectQuestionCategory = function (Parameter, Question) {
    $scope.submit_as_concern = true;

    //$scope.selectedQuestionObject = Question;
    $scope.selectedQuestionObject = Question;
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
    $scope.activeStep("step4");
   
  };

  $scope.activateStepBasedOnShowBack = function() {
    if ($scope.showBack) {
        $scope.activeStep('step2');
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

  $scope.activateselected = function () {
    $scope.feedback.parameter = {};

    angular.forEach($scope.questioset, function (value, key) {
      if (value.settitle == $scope.dropdownvalue) {
        $scope.feedback.parameter = value;
      }
    });
  };

  $scope.next1 = function () {
    $scope.feedback.bedno = $scope.bed_no[$scope.feedback.bedno];

    // Simplified validation checks with clear messages
    if (!$scope.feedback.name) {
      alert("Please enter a valid Patient Name");
      return false;
    }

    if (!$scope.feedback.patientid) {
      alert("Please enter your UHID");
      return false;
    }

    if (!$scope.feedback.ward) {
      alert("Please select a social media type");
      return false;
    }

    // if (!$scope.feedback.bedno) {
    //   alert("Please enter a valid Bed Number");
    //   return false;
    // }

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

  // $scope.overallSum = function (obj) {
  //   var sum = 0,
  //     length = 0;

  //   for (var el in obj) {
  //     if (obj.hasOwnProperty(el)) {
  //       sum += parseFloat(obj[el]);

  //       length++;
  //     }
  //   }

  //   window.overallSumScore = sum / length;

  //   window.overallSumScore = Math.round(window.overallSumScore);

  //   $scope.feedback.overallScore = window.overallSumScore;
  // };

  // $scope.recommend1_definite_grey = -1;

  var d = new Date();

  $scope.feedback.datetime = d.getTime();



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


    $rootScope.loader = true;

    $scope.feedback.patientType = "SOCIAL";

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
        "/savepatientfeedback_social.php?patient_id=" +
        $scope.feedback.patientid +
        "&administratorId=" +
        $rootScope.adminId,
        $scope.feedback
      )
      .then(
        function (responsedata) {
          if ((responsedata.status = "success")) {
            $rootScope.loader = false;
            $scope.activeStep("step5");
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
        $scope.type2 = 'English'
      });
    }

    if (type == "lang2") {
      $http.get("language/lang2.json").then(function (responsedata) {
        $rootScope.lang = responsedata.data;
        $scope.type2 = 'ಕನ್ನಡ';
      });
    }

    if (type == "lang3") {
      $http.get("language/lang3.json").then(function (responsedata) {
        $rootScope.lang = responsedata.data;
        $scope.type2 = 'മലയാളം';
			//	$scope.type2 = 'தமிழ்';

      });
    }
    $scope.feedback.langsub = type;

  };
  $scope.language('english');

});
