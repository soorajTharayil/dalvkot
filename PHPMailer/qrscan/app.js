var app = angular.module('ehandorApp', []);

app.controller('PatientFeedbackCtrl', function($rootScope, $scope, $http, $location) {
	$scope.typel = 'english';
	$scope.feedback = {};
	$rootScope.loader = false;
	 $rootScope.overallScore = [];
	 
	$rootScope.baseurl_main = window.location.origin+'/api'; 
	$scope.step1 = true;
	$scope.language = function(type){
		 $scope.typel = type;
		 $('#englishid').removeClass('btn-primary');
		 $('#kanadaid').removeClass('btn-primary');
		 $('#malayalamid').removeClass('btn-primary');
		if(type =='english'){
			 $http.get('dist/english.json').then(function(responsedata) {
                
                $scope.lang = responsedata.data;
				$('#englishid').addClass('btn-primary');
                
            });
		}
		if(type =='kanada'){
			 $http.get('dist/kanada.json').then(function(responsedata) {
                
                $scope.lang = responsedata.data;
				$('#kanadaid').addClass('btn-primary');
                
			 });
		}
		if(type =='tamil'){
			 $http.get('dist/tamil.json').then(function(responsedata) {
                
                $scope.lang = responsedata.data;
                $('#tamilid').addClass('btn-primary');
			 });
		}
	
	if(type =='malayalam'){
		$http.get('dist/malayalam.json').then(function(responsedata) {
		   
		   $scope.lang = responsedata.data;
		   $('#malayalamid').addClass('btn-primary');
		});
   }
}
	$scope.language('english');
	// $scope.language('kanada');
	//  $scope.language('malayalam');
	/*$scope.questionset = function(){
		
			 $http.get('dist/questionset.json').then(function(responsedata) {
                
                $scope.questioset = responsedata.data;
				console.log($scope.questioset);
                
            });
		
	}*/
	//$scope.questionset();
    window.setTimeout(function() {
        $(window).scrollTop(0);
    }, 0);
	
	$scope.setupapplication = function(){ 
		//$rootScope.loader = true;
		var url = window.location.href;
		//console.log(url);
		var id = url.substring(url.lastIndexOf('=') + 1);
		//alert(id);
		$http.get($rootScope.baseurl_main + '/roles.php?patientid='+id, {timeout:20000}).then(function(responsedata) {
            	$scope.wardlist = responsedata.data;
				$scope.questioset = responsedata.data.question_set;
				$scope.setting_data = responsedata.data.setting_data;
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
	$scope.setupapplication();
	
	
	
	
	
	$scope.questionvalueset = function(v,key,q){
		$rootScope.positivefeedback = true;
		q.valuetext = v;
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
				   if(k == questionset.shortkey){
					   if(value == 1 || value == 2){
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
	
	$scope.next1 = function() {
        console.log($scope.feedback.name);
        if ($scope.feedback.name == '' ||  $scope.feedback.name == undefined) {
            alert('Please enter valid Patient Name');
			return false;
        }
		if ($scope.feedback.patientid == '' || $scope.feedback.patientid ==undefined) {
            alert('Please enter valid Patient ID');
			return false;
        }
		//alert($scope.feedback.ward);
		//if ($scope.feedback.ward == '' ||  $scope.feedback.ward == 'undefined') {
        //    alert('Please select Ward');
		//	return false;
       // }
	   if(isNaN($scope.feedback.contactnumber) || $scope.feedback.contactnumber == null){
		   $scope.step1 = false;
			$scope.step2 = true;
			$(window).scrollTop(0);
	   }else{
			if ($scope.feedback.contactnumber < 1111111111 || $scope.feedback.contactnumber > 9999999999) {
				alert('Please enter valid Mobile Number');
				return false;
			}else {
				$scope.step1 = false;
				$scope.step2 = true;
				$(window).scrollTop(0);

			}
	   }

    }
	$scope.prev1 = function() {
		$scope.step1 = true;
		$scope.step2 = false;
		$(window).scrollTop(0);
	}
	
	$scope.prev2 = function() {
		$scope.step2 = true;
		$scope.step3 = false;
		$(window).scrollTop(0);
	}
	
	$scope.next2 = function() {
		$scope.step2 = false;
		$scope.step3 = true;
		$(window).scrollTop(0);
	}
	
	$scope.next3 = function() {
		$scope.step3 = false;
		$scope.step4 = true;
		$(window).scrollTop(0);
	}
	
	$scope.overallSum = function(obj) {

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
	
	$scope.savefeedback = function() {
		//alert($scope.recommend1_definite_grey);
		if ($scope.recommend1_definite_grey == 0 || $scope.recommend1_definite_grey > 0) {
				console.log('ok');
        }else{
			alert('Please select recommendations');
				return false;
		}
		$rootScope.loader = true;
        $scope.feedback.patientType = "In-Patient";
		$scope.feedback.administratorId = $rootScope.adminId;
		$scope.feedback.wardid = $rootScope.wardid;
		$scope.feedback.recommend1Score = $scope.recommend1_definite_grey/2;
        $http.post($rootScope.baseurl_main + '/saveempoyeefeedback.php?patient_id=' + $rootScope.patientid + '&administratorId=' + $rootScope.adminId, $scope.feedback).then(function(responsedata) {
		   if(responsedata.status = "success"){
					$rootScope.loader = false;
				// navigator.showToast('Patient Feedback Submitted Successfully');
					//$location.path('/thankyou');
					$scope.step3 = false;
					$scope.step4 = true;
					$(window).scrollTop(0);
				}
				else{
					alert("Feeback already submitted for this patient!!")
				}
				

		},function myError(response) {
			$rootScope.loader = false;
			
			alert("Please check your internet and try again!!")
		});
            

	}
	
	
})

