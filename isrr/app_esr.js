var app = angular.module("ehandorApp", ["ngSanitize"]);

const d = new Date();

app.controller("PatientFeedbackCtrl", function ($rootScope, $scope, $http, $window) {
  $scope.typel = "english";
  $scope.type2 = "English";
  $scope.toplogo = false;
  $scope.feedback = {};
  $rootScope.loader = false;
  $scope.loginvar = {};
	$scope.loginvar.userid = '';
	$scope.loginvar.password = '';
  $rootScope.overallScore = [];
  $rootScope.baseurl_main = window.location.origin + "/api";
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

// Function to determine the initial step based on the URL
$scope.initializeStep = function() {
    // Get the current URL
    var currentUrl = window.location.href;

    // Check if the URL contains 'src=Link'
    if (currentUrl.includes('src=Link')) {
        $scope.activeStep("step1");
        $scope.toplogo = true;
    } else {
        $scope.activeStep("step1");
    }
};

// Initialize the step when the controller is loaded
$scope.initializeStep();


  if(localStorage.getItem("ehandor")){
    $rootScope.profilen = JSON.parse(localStorage.getItem('ehandor'));
     console.log($rootScope.profilen);
}
$rootScope.baseurl_main = window.location.origin + '/api';

var ehandor = JSON.parse($window.localStorage.getItem('ehandor'));
  if(ehandor) {
    // Assign the data to scope variables
    $scope.loginemail = ehandor.email;
    $scope.loginid = ehandor.empid;
    $scope.loginname = ehandor.name;
    $scope.loginnumber = ehandor.mobile;

    // Similarly, assign other properties as needed
} else {
    // Handle if data doesn't exist
    console.log('Data not found in local storage');
}

  $scope.encodeImage = function (input) {
    var file = input.files[0];

    if (file) {
      $scope.image = true;
      var reader = new FileReader();

      reader.onload = function (e) {
        var img = new Image();
        img.src = e.target.result;

        img.onload = function () {
          // Create a canvas element to manipulate the image
          var canvas = document.createElement('canvas');
          var ctx = canvas.getContext('2d');

          // Set the canvas dimensions
          canvas.width = img.width;
          canvas.height = img.height;

          // Draw the image on the canvas
          ctx.drawImage(img, 0, 0, img.width, img.height);

          // Compress the image
          var compressedImageData = canvas.toDataURL('image/jpeg', 0.1); // Adjust the quality as needed

          // Update the $scope.feedback.image with the compressed image data
          $scope.$apply(function () {
            $scope.feedback.image = compressedImageData;
          });
        };
      };

      reader.readAsDataURL(file);
    } else {
      $scope.feedback.image = null;
    }
  };

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

        $scope.loginemail =responsedata.data.email;
        $scope.loginid =responsedata.data.empid;
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
                  $scope.loginemail =responsedata.data.email;
                  $scope.loginid =responsedata.data.empid;
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
  };

  //IN USED
  $scope.setupapplication = function () {
    // Consider using $location service for extracting URL parameters
    var url = window.location.href;
    var id = url.substring(url.lastIndexOf("=") + 1);

    $http
      .get($rootScope.baseurl_main + "/esr_wards.php?patientid=" + id, {
        timeout: 20000,
      })
      .then(
        function (responsedata) {
          // Ensure data exists before assigning to avoid runtime errors
          if (responsedata.data) {
            $scope.wardlist = responsedata.data;
            $scope.questioset = responsedata.data.question_set;
            $scope.setting_data = responsedata.data.setting_data;
            $scope.heathcare_employee = responsedata.data.heathcare_employee;
            $scope.bed_no = [];
            $scope.feedback.name = "";
            $scope.feedback.admissiondate = "";
            $scope.feedback.email = "";
            $scope.feedback.image = "";
            $scope.feedback.contactnumber = "";
            $scope.feedback.bedno = "";
            $scope.feedback.ward = "";
            $scope.feedback.section = "ISR";
            $scope.feedback.patientid = "";
            if (responsedata.data.pinfo && responsedata.data.pinfo != null) {
              var pinfo = responsedata.data.pinfo;
              $scope.feedback.name = pinfo.name;
              $scope.feedback.role = pinfo.role;
              $scope.feedback.pimage = pinfo.image;
              $scope.feedback.admissiondate = pinfo.admited_date;
              $scope.feedback.email = pinfo.email;
              $scope.feedback.image = pinfo.image;
              $scope.feedback.contactnumber = pinfo.mobile;
              $scope.feedback.bedno = pinfo.bed_no;
              $scope.feedback.ward = pinfo.ward;
              $scope.feedback.section = "ISR";
              $scope.feedback.patientid = pinfo.patient_id;
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
    $scope.submit_as_concern = false;
    $scope.showBack = false;
    if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
      alert("Please Select Floor/Ward");

      return false;
    }
    if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
      alert("Please Select Site");

      return false;
    }

    if ($scope.feedback.priority == undefined || $scope.feedback.priority == null) {
      $scope.feedback.priority = 'Low';
    }

    $scope.selectedParameterObject = {};
    $scope.feedback.other = $scope.searchTextmain;
    $scope.activeStep("step4");
  };
  $scope.selectQuestionCategory1 = function (Parameter, Question) {
    $scope.showBack = false;
    $scope.submit_as_concern = true;
    if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
      alert("Please Select Floor/Ward");

      return false;
    }
    if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
      alert("Please Select Site");

      return false;
    }

    if ($scope.feedback.priority == undefined || $scope.feedback.priority == null) {
      $scope.feedback.priority = 'Low';
    }
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
    if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
      alert("Please Select Floor/Ward");

      return false;
    }
    if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
      alert("Please Select Site");

      return false;
    }

    if ($scope.feedback.priority == undefined || $scope.feedback.priority == null) {
      $scope.feedback.priority = 'Low';
    }
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
    if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
      alert("Please Select Floor/Ward");
      return false;
    }
    if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
      alert("Please Select Site");
      return false;
    }

    if ($scope.feedback.priority == undefined || $scope.feedback.priority == null) {
      $scope.feedback.priority = 'Low';
    }

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

  $scope.activateselected = function () {
    $scope.feedback.parameter = {};

    angular.forEach($scope.questioset, function (value, key) {
      if (value.settitle == $scope.dropdownvalue) {
        $scope.feedback.parameter = value;
        console.log($scope.feedback.parameter);
      }
    });
  };

  $scope.next1 = function () {

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

    $scope.feedback.patientType = "ISR";

    $scope.feedback.administratorId = $rootScope.adminId;

    $scope.feedback.wardid = $rootScope.wardid;

    $scope.feedback.recommend1Score = $scope.recommend1_definite_grey / 2;

    // $scope.feedback.name = $scope.loginname;
		// $scope.feedback.email = $scope.loginemail;
		// $scope.feedback.contactnumber = $scope.loginnumber;
		// $scope.feedback.patientid = $scope.loginid;

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
        "/savepatientfeedback_eSR.php?patient_id=" +
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
