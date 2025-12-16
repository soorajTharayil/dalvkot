var app = angular.module("ehandorApp", ["ngSanitize"]);

app.filter('questionSearch', function () {
  return function (items, search) {
    if (!search) return items;
    if (!items) return [];

    search = search.toLowerCase();

    return items.filter(function (item) {
      let q1 = (item.question || "").toLowerCase();
      let q2 = (item.questionk || "").toLowerCase();
      let q3 = (item.questionm || "").toLowerCase();

      return q1.includes(search) || q2.includes(search) || q3.includes(search);
    });
  };
});


app.filter('questionSort', function () {
  return function (items, search) {
    if (!search || !items) return items;

    search = search.toLowerCase();

    let starts = [];
    let contains = [];

    items.forEach(item => {
      let text = (item.question || "").toLowerCase();
      if (text.startsWith(search)) starts.push(item);
      else if (text.includes(search)) contains.push(item);
    });

    return starts.concat(contains);
  };
});

const d = new Date();

app.controller(
  "PatientFeedbackCtrl",
  function ($rootScope, $scope, $http, $window, $sce) {
    $scope.typel = "english";
    $scope.type2 = "English";
    $scope.toplogo = false;
    $scope.AnonymousIncident_show = true;
    var ehandor = JSON.parse($window.localStorage.getItem("ehandor"));
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
      console.log("Data not found in local storage");
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
      if (step === "step2") {
        $scope.step2 = true;
        $scope.searchTextmain = "";
        $scope.feedback.other = "";
        $scope.feedback.images = [];
      }
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
      if (currentUrl.includes("src=Link")) {
        $scope.activeStep("step1");
        $scope.AnonymousIncident_show = true;
        $scope.toplogo = true;
      } else {
        $scope.activeStep("step1");
        $scope.AnonymousIncident_show = true;
      }
    };

    // Initialize the step when the controller is loaded
    $scope.initializeStep();

    $scope.encodeFile = function (element) {
      var file = element.files[0]; // Get the uploaded file
      var formData = new FormData();
      formData.append("file", file); // Append the file to FormData

      // Use $http to post the file to the server
      $http
        .post($rootScope.baseurl_main + "/upload_file.php", formData, {
          transformRequest: angular.identity,
          headers: { "Content-Type": undefined }, // Let the browser set content type
        })
        .then(function (response) {
          if (response.data.file_url) {
            // Check if file_url is complete. If it's relative, prepend base URL
            var fileUrl = response.data.file_url;
            if (!fileUrl.startsWith("http")) {
              fileUrl = $rootScope.baseurl_main + "/" + fileUrl;
            }

            // Store the file URL and name in the scope for display
            $scope.feedback.file = fileUrl; // Store the full file URL
            $scope.feedback.fileName = file.name; // Store the file name for display
          }
        })
        .catch(function (error) {
          console.error("Error uploading file:", error);
        });
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

    // Trigger file input click
    $scope.triggerFileInput = function () {
      document.getElementById("imageInput").click();
    };

    // Remove image by index
    $scope.removeImage = function (index) {
      $scope.feedback.images.splice(index, 1);
    };

    // Handle multiple image uploads with compression
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
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");

                canvas.width = img.width;
                canvas.height = img.height;

                ctx.drawImage(img, 0, 0, img.width, img.height);

                var compressedImageData = canvas.toDataURL("image/jpeg", 0.1);

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

    let fabricCanvas;
    let currentEditIndex = null;
    let pathStack = [];

    $scope.editImage = function (index) {
      currentEditIndex = index;

      // Show modal at top of screen
      const modal = document.getElementById("imageEditorModal");
      modal.style.display = "block";
      modal.style.top = "20px";

      // Clear previous canvas if exists
      if (fabricCanvas) {
        fabricCanvas.dispose();
      }

      // Initialize canvas with better touch support
      fabricCanvas = new fabric.Canvas("fabricCanvas", {
        isDrawingMode: true,
        selection: false,
        preserveObjectStacking: true,
        fireRightClick: true,
        stopContextMenu: true,
        hoverCursor: "pointer",
      });

      // Configure drawing brush
      fabricCanvas.freeDrawingBrush.width = 5;
      fabricCanvas.freeDrawingBrush.color = "#000000";

      // Add smoothing for touch drawing:
      fabricCanvas.freeDrawingBrush.decimate = 10;
      fabricCanvas.freeDrawingBrush.curveThreshold = 0.5;

      // Clear undo stack when new image loads
      pathStack = [];

      const imgElement = new Image();
      imgElement.crossOrigin = "Anonymous";

      imgElement.onload = function () {
        // Create fabric image with original dimensions
        const imgInstance = new fabric.Image(imgElement, {
          left: 0,
          top: 0,
          selectable: false,
          hasControls: false,
          hasBorders: false,
        });

        // Set canvas to original image size (preserves quality)
        fabricCanvas.setWidth(imgElement.naturalWidth);
        fabricCanvas.setHeight(imgElement.naturalHeight);
        fabricCanvas.add(imgInstance);
        fabricCanvas.sendToBack(imgInstance);

        // Scale display while maintaining aspect ratio
        scaleCanvasToFit();

        // Recalculate offsets for accurate drawing
        fabricCanvas.calcOffset();

        // Handle window resizing
        window.addEventListener("resize", scaleCanvasToFit);
      };

      // Load the marked image (not the original) to show existing markings
      imgElement.src = $scope.feedback.images[index];

      // Auto-save drawings and track path for undo
      fabricCanvas.on("path:created", function (e) {
        pathStack.push(e.path); // push new path into stack

        $scope.$apply(function () {
          $scope.feedback.images[currentEditIndex] = fabricCanvas.toDataURL({
            format: "png", // PNG preserves transparency
            quality: 1, // Maximum quality
          });
        });
      });

      function scaleCanvasToFit() {
        const maxWidth = modal.clientWidth - 40;
        const maxHeight = window.innerHeight - 150;

        const scale = Math.min(
          maxWidth / fabricCanvas.width,
          maxHeight / fabricCanvas.height
        );

        fabricCanvas.setZoom(scale);
        fabricCanvas.setDimensions(
          {
            width: fabricCanvas.width * scale,
            height: fabricCanvas.height * scale,
          },
          { backstoreOnly: true }
        );
      }
    };

    // Undo function: remove last drawn path and update image
    $scope.undoLast = function () {
      if (pathStack.length === 0) return;

      const lastPath = pathStack.pop();
      fabricCanvas.remove(lastPath);
      fabricCanvas.renderAll();

      // Update saved image after undo
      $scope.feedback.images[currentEditIndex] = fabricCanvas.toDataURL({
        format: "png",
        quality: 1,
      });

      $scope.$applyAsync();
    };

    $scope.closeEditor = function () {
      const modal = document.getElementById("imageEditorModal");
      modal.style.display = "none";

      window.removeEventListener("resize", scaleCanvasToFit);

      if (fabricCanvas) {
        fabricCanvas.off("path:created");
        fabricCanvas.dispose();
        fabricCanvas = null;
      }
    };

    $scope.raiseAnonymousIncident = function () {
      $scope.AnonymousIncident_show = false;
      $scope.feedback.name = "";
      $scope.feedback.email = "";
      $scope.feedback.contactnumber = "";
      $scope.feedback.patientid = "";
      let randomNumber = Math.floor(1000 + Math.random() * 9000); // Ensures a 4-digit number
      $scope.feedback.patientid = "anys" + randomNumber;
      $scope.loginid = "anys" + randomNumber;
      $scope.activeStep("step2");
    };
    $scope.refresh_back = function () {
      $scope.AnonymousIncident_show = true;
      $scope.activeStep("step1");
      $scope.feedback.patientid = "";
    };
    $scope.login = function () {
      /*var intstatus = $rootScope.internetcheck();
    if (intstatus == false) {
      return false;
    }*/
      $rootScope.loader = true;
      $scope.toplogo = true;

      $http
        .post($rootScope.baseurl_main + "/login.php", $scope.loginvar, {
          timeout: 20000,
        })
        .then(
          function (responsedata) {
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
              if (response.status === "fail") {
                $scope.loginerror = response.message;
              } else if (response.status === "success") {
                $rootScope.loginactive = true;
                $scope.activeStep("step2");
                // $window.location.href = 'http://demo30.efeedor.com/all_button';
              }
            } else {
              $scope.loginerror = "Some error happend";
              $rootScope.loader = false;
            }
          },
          function errorCallback(responsedata) {
            if (localStorage.getItem("cordinator")) {
              $scope.cordinatorlist = JSON.parse(
                localStorage.getItem("cordinator")
              );
              if ($scope.cordinatorlist) {
                if ($scope.cordinatorlist.cordinators) {
                  if ($scope.cordinatorlist.cordinators.length > 0) {
                    angular.forEach(
                      $scope.cordinatorlist.cordinators,
                      function (value, key) {
                        console.log(value);
                        //alert(value.guid);
                        if (
                          value.guid.toLowerCase() ==
                          $scope.loginvar.userid.toLowerCase() &&
                          value.password == $scope.loginvar.password
                        ) {
                          //	alert(2);
                          value.userid = $scope.loginvar.userid;
                          $rootScope.profilen = value;
                          $rootScope.adminId = $rootScope.profilen.userid;
                          $scope.loginemail = responsedata.data.email;
                          $scope.loginid = responsedata.data.empid;
                          $scope.loginname = responsedata.data.name;
                          $scope.loginnumber = responsedata.data.mobile;

                          $scope.profiled = $rootScope.profilen;
                          localStorage.setItem(
                            "ehandor",
                            JSON.stringify(value)
                          );
                          $rootScope.loginactive = true;
                          $scope.activeStep("step2");
                          // $window.location.href = 'http://demo30.efeedor.com/all_button';
                        }
                      }
                    );
                  }
                }
              }
            } else {
              $scope.loginerror = "Internet Connection error";
            }
            $rootScope.loader = false;
          }
        );
    };

    $scope.prev_pop = function () {
      $scope.step100 = true;
      $scope.step200 = false;
      $(window).scrollTop(0);
    };

    $scope.setIncidentType = function (type) {
      $scope.feedback.incident_type = type;
      $scope.showIncidentMenu = false;
    };
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
      $http
        .get(
          $rootScope.baseurl_main +
          "/esr_mobile_number.php?mobile=" +
          $scope.feedback.contactnumber +
          "&email=" +
          $scope.feedback.contactnumber +
          "&pin=" +
          $scope.feedback.pin,
          { timeout: 20000 }
        )
        .then(
          function (responsedata) {
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
              alert(
                "Error: Unable to proceed to the next page as the mobile number does not match with the available patient data"
              ); // User feedback on error
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
      $http
        .get(
          $rootScope.baseurl_main +
          "/forgotten_pin.php?mobile=" +
          $scope.feedback.pin_contactnumber +
          "&email=" +
          $scope.feedback.pin_contactnumber,
          { timeout: 20000 }
        )
        .then(
          function (responsedata) {
            if (responsedata.data.pinfo == "NO") {
              if (
                !$scope.feedback.pin_contactnumber ||
                $scope.feedback.pin_contactnumber < 1111111111 ||
                $scope.feedback.pin_contactnumber > 9999999999
              ) {
                $scope.please = true;
                $("#pinModel").modal("show");
                // Set $scope.no_email back to false after 2 seconds
                setTimeout(function () {
                  $scope.$apply(function () {
                    $scope.please = false;
                  });
                }, 2000);
              } else {
                $scope.no_email = true;
                $("#pinModel").modal("show");

                // Set $scope.no_email back to false after 2 seconds
                setTimeout(function () {
                  $scope.$apply(function () {
                    $scope.no_email = false;
                  });
                }, 2000);
              }
            } else {
              $scope.no_mobile = true;
              $("#pinModel").modal("hide");

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
    };

    $scope.isLiTagsEmpty = function (questions) {
      // Check if the li tags are empty
      return (
        !questions ||
        !questions.length ||
        !questions.some(function (p) {
          return (
            p.question.trim() !== "" ||
            p.questionk.trim() !== "" ||
            p.questionm.trim() !== ""
          );
        })
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
        angular.forEach(
          $scope.feedback.parameter.question,
          function (question) {
            question.showQuestion = false; // Hide all questions
            question.valuetext = false; // Uncheck all checkboxes
          }
        );
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
        .get($rootScope.baseurl_main + "/incident_wards.php?patientid=" + id, {
          timeout: 20000,
        })
        .then(
          function (responsedata) {
            // Ensure data exists before assigning to avoid runtime errors
            if (responsedata.data) {
              $scope.wardlist = responsedata.data;
              $scope.questioset = responsedata.data.question_set;
              // Push All questions from all categories
              $scope.allQuestions = [];

              $scope.questioset.forEach(cat => {
                if (cat.question && Array.isArray(cat.question)) {
                  cat.question.forEach(q => {
                    q.categoryName = cat.category;
                    $scope.allQuestions.push(q);
                  });
                }
              });

              $scope.setting_data = responsedata.data.setting_data;
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
      if (!$scope.searchTextmain || $scope.searchTextmain.length < 3)
        return true; // If no search text or less than 3 characters, show all questions.

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
      $scope.submit_as_concern = true;
      $scope.selectedParameterObject = {
        title: "Others",
        question: "Other incidents",
        shortkey: "incident230",
      };
      $scope.feedback.other = $scope.searchTextmain;
      $scope.activeStep("step4");
    };

    $scope.selectQuestionCategory1 = function (questionObj) {
      $scope.showBack = false;
      $scope.submit_as_concern = true;
      //$scope.selectedQuestionObject = Question;

      //questionObj contains BOTH question and category
      $scope.selectedParameterObject = questionObj;
      $scope.selectedCategory = questionObj.categoryName;

      console.log("Selected question:", questionObj.question);
      console.log("Category:", questionObj.categoryName);

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
    $scope.OtherCategorySelected = "";
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
        $scope.activeStep("step3");
      } else {
        $scope.activeStep("step2");
      }
      $scope.feedback.other = "";
      $scope.feedback.incident_occured_in = "";
      $scope.feedback.action_taken = "";
      $scope.feedback.what_went_wrong = "";
      $scope.feedback.risk_matrix = "";
      $scope.feedback.priority = "";
      $scope.feedback.incident_type = "";
      $scope.feedback.ward = "";
      $scope.feedback.bedno = "";
      $scope.feedback.tag_name = "";
      $scope.feedback.tag_patientid = "";
      $scope.feedback.files_name = [];
      $scope.feedback.images = [];
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
      // Proceed to the next step if all validations pass
      if ($scope.feedback.name == "" || $scope.feedback.name == undefined) {
        alert("Please Enter Employe Name");
        return false;
      }

      if (
        $scope.feedback.patientid == "" ||
        $scope.feedback.patientid == undefined
      ) {
        alert("Please enter Employe ID");
        return false;
      }

      if (
        isNaN($scope.feedback.contactnumber) ||
        $scope.feedback.contactnumber == null
      ) {
        $scope.step1 = false;
        $scope.step2 = true;
        $(window).scrollTop(0);
      } else {
        if (
          $scope.feedback.contactnumber < 1111111111 ||
          $scope.feedback.contactnumber > 9999999999
        ) {
          alert("Please Enter Valid Mobile Number");
          return false;
        } else {
          $scope.step1 = false;
          $scope.step2 = true;
          $(window).scrollTop(0);
        }
      }
      $scope.activeStep("step2");
    };

    $scope.next4 = function () {
      if (
        !$scope.feedback.incident_occured_in ||
        $scope.feedback.incident_occured_in === ""
      ) {
        alert("Please enter incident occurred date");
        // Scroll to incident_occured_in field
        setTimeout(function () {
          document.getElementById("incident_occured_in").scrollIntoView({
            behavior: "smooth",
            block: "center",
          });
          document.getElementById("incident_occured_in").focus();
        }, 100);
        return false;
      }

      if (!$scope.feedback.other || $scope.feedback.other === "") {
        alert("Please enter incident description");
        // Scroll to description textarea
        setTimeout(function () {
          document.getElementById("comment").scrollIntoView({
            behavior: "smooth",
            block: "center",
          });
          document.getElementById("comment").focus();
        }, 100);
        return false;
      }

      if (!$scope.feedback.ward || $scope.feedback.ward === "") {
        alert("Please select floor");
        // Scroll to ward field
        setTimeout(function () {
          document.getElementById("ward").scrollIntoView({
            behavior: "smooth",
            block: "center",
          });
          document.getElementById("ward").focus();
        }, 100);
        return false;
      }

      if (!$scope.feedback.bedno || $scope.feedback.bedno === "") {
        alert("Please select site");
        // Scroll to bed number field
        setTimeout(function () {
          document.getElementById("bedno").scrollIntoView({
            behavior: "smooth",
            block: "center",
          });
          document.getElementById("bedno").focus();
        }, 100);
        return false;
      }

      if (
        $scope.feedback.tag_name == "" ||
        $scope.feedback.tag_name == undefined
      ) {
        $scope.tag_name = false;
      } else {
        $scope.tag_name = true;
      }

      if (
        $scope.feedback.tag_patientid == "" ||
        $scope.feedback.tag_patientid == undefined
      ) {
        $scope.tag_patientid = false;
      } else {
        $scope.tag_patientid = true;
      }
      if ($scope.feedback.other == "" || $scope.feedback.other == undefined) {
        $scope.description = false;
      } else {
        $scope.description = true;
      }
      if (
        $scope.feedback.what_went_wrong == "" ||
        $scope.feedback.what_went_wrong == undefined
      ) {
        $scope.what_went_wrong = false;
      } else {
        $scope.what_went_wrong = true;
      }

      if (
        $scope.feedback.action_taken == "" ||
        $scope.feedback.action_taken == undefined
      ) {
        $scope.action_taken = false;
      } else {
        $scope.action_taken = true;
      }

      if ($scope.feedback.ward == "" || $scope.feedback.ward == undefined) {
        $scope.feedback.ward = "Others";
      }
      if ($scope.feedback.bedno == "" || $scope.feedback.bedno == undefined) {
        $scope.bed_no = ["Others"];
        $scope.feedback.bedno = "Others";
      }
      if (
        $scope.feedback.patientid == "" ||
        $scope.feedback.patientid == undefined
      ) {
        let randomNumber = Math.floor(1000 + Math.random() * 9000); // Ensures a 4-digit number
        $scope.feedback.patientid = "anys" + randomNumber;
        $scope.loginid = "anys" + randomNumber;
      }
      if ($scope.feedback.name == "" || $scope.feedback.name == undefined) {
        $scope.feedback.name = "Anonymous";
        $scope.employeeid = true;
        $scope.showmobileno = false;
        $scope.showemail = false;
      }

      // Proceed to the next step if all validations pass
      $scope.activeStep("step5");
    };

    $scope.feedback = { priority: "" };

    $scope.priorityCode = function (value) {
      switch (value) {
        case "P1-Critical":
        case "Sentinel":
          return "p1"; // red
        case "P2-High":
        case "Adverse":
          return "p2"; // orange
        case "P3-Medium":
        case "No-harm":
          return "p3"; // blue
        case "P4-Low":
        case "Near miss":
          return "p4"; // green
        default:
          return "";
      }
    };

    $scope.setPriority = function (value) {
      $scope.feedback.priority = value; // store selected value
      $scope.showMenu = false; // close dropdown
    };
    $scope.feedback = {
      risk_matrix: { impact: "", likelihood: "" },
    };

    $scope.setRisk = function (impact, likelihood, level) {
      // If the same cell is clicked again → clear (deselect)
      if (
        $scope.feedback.risk_matrix.impact === impact &&
        $scope.feedback.risk_matrix.likelihood === likelihood
      ) {
        $scope.feedback.risk_matrix = { impact: "", likelihood: "", level: "" };
      } else {
        // Otherwise, select the new cell
        $scope.feedback.risk_matrix = { impact, likelihood, level };
      }
    };

    $scope.isSelected = function (impact, likelihood) {
      return (
        $scope.feedback.risk_matrix.impact === impact &&
        $scope.feedback.risk_matrix.likelihood === likelihood
      );
    };

    var d = new Date();

    $scope.feedback.datetime = d.getTime();

    $scope.save_popup = function () {
      if (
        $scope.feedback.tag_name == "" ||
        $scope.feedback.tag_name == undefined
      ) {
        alert("Please enter patient name");
        return false;
      }
      if (
        $scope.feedback.tag_patientid == "" ||
        $scope.feedback.tag_patientid == undefined
      ) {
        alert("Please enter patient ID");
        return false;
      }
      if (
        $scope.feedback.tag_patient_type == "" ||
        $scope.feedback.tag_patient_type == undefined
      ) {
        alert("Please select patient type");
        return false;
      }
      if (
        $scope.feedback.tag_consultant == "" ||
        $scope.feedback.tag_consultant == undefined
      ) {
        alert("Please enter primary consultant");
        return false;
      }

      $scope.tagpatient = true;
      console.log($scope.feedback);
      $("#tagPatientModal").modal("hide");
    };

    $scope.employeename = true;
    $scope.employeeid = true;
    $scope.showmobileno = true;
    $scope.showemail = true;

    $scope.onAnonymousIncidentChange = function () {
      if ($scope.anonymousIncident) {
        $scope.employeeid = false;
        $scope.showmobileno = false;
        $scope.showemail = false;
        $scope.feedback.name = "Anonymous";
        $scope.feedback.email = "";
        $scope.feedback.contactnumber = "";
        $scope.feedback.patientid = "";
        $scope.loginname = "Anonymous";
        $scope.loginemail = "";
        $scope.loginnumber = "";
        $scope.loginid = "";
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
        $scope.feedback.name = $scope.feedback.name;
        $scope.feedback.email = $scope.loginemail;
        $scope.feedback.contactnumber = $scope.feedback.contactnumber;
        $scope.feedback.patientid = $scope.feedback.patientid;
        console.log("Checkbox is unchecked: Report the incident normally.");
        // Add your logic for normal incident reporting
      }
    };

    $scope.savefeedback = function () {
      if (
        $scope.feedback.patientid == "" ||
        $scope.feedback.patientid == undefined
      ) {
        let randomNumber = Math.floor(1000 + Math.random() * 9000); // Ensures a 4-digit number
        $scope.feedback.patientid = "anys" + randomNumber;
        $scope.loginid = "anys" + randomNumber;
      }
      if (!$scope.selectedParameterObject.question) {
        angular.forEach($scope.questioset, function (value, key) {
          if (value.settitle == $scope.OtherCategorySelected) {
            $scope.selectedQuestionObject = value;

            angular.forEach(
              $scope.selectedQuestionObject.question,
              function (v, k) {
                if (v.question == "Others") {
                  $scope.selectedParameterObject = v;
                  $scope.selectedQuestionObject.question[k].valuetext = true;
                }
              }
            );
          }
        });

        if (!$scope.selectedParameterObject.question) {
          let lastQuestion = $scope.questioset.slice(-1);
          lastQuestion[0].question[0].valuetext = true;
          $scope.selectedQuestionObject = lastQuestion[0];
          $scope.selectedParameterObject = lastQuestion[0].question[0];
        }
      }
      if (
        $scope.selectedParameterObject.shortname == "Other" ||
        $scope.selectedParameterObject.question == "Others"
      ) {
        if ($scope.feedback.other == "" || $scope.feedback.other == undefined) {
          alert("Please Provide a comment because you have selected Other.");
          return false;
        }
      }

      // $scope.feedback.name = $scope.loginname;
      // $scope.feedback.email = $scope.loginemail;
      // $scope.feedback.contactnumber = $scope.loginnumber;
      // $scope.feedback.patientid = $scope.loginid;

      $rootScope.loader = true;

      $scope.feedback.patientType = "INCIDENT";

      $scope.feedback.administratorId = $rootScope.adminId;

      $scope.feedback.wardid = $rootScope.wardid;

      $scope.feedback.recommend1Score = $scope.recommend1_definite_grey / 2;

      $scope.feedback.reason = {};
      $scope.feedback.comment = {};
      $scope.feedback.comment[$scope.selectedParameterObject.type] =
        $scope.feedback.other;
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
          // $scope.type2 = "മലയാളം";
          $scope.type2 = "தமிழ்";
        });
      }
      $scope.feedback.langsub = type;
    };

    $rootScope.language("english");
  }
);
