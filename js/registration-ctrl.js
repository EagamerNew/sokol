var app = angular.module("index", []);
app.controller("registration", function($scope, $http,$location,$window, $timeout) {
    $scope.user = {
        surname: '',
        name: '',
        lastname: '',
        email: '',
        phone: '',
        password: '',
        uchcenter: '',
        bin: '',
        fact_address: '',
        project_vmest: '',
        specialization: '',
        srokObuch: '',
        language: '1',
        lessons: '1',
        groups: '1',
        specializations: [],
        strSpecializations: ''
    };
    $scope.file_ustav;
    $scope.file_rekvisity;
    $scope.file_uchdocs;

    $scope.init = function(){

        $window.localStorage.removeItem('nextStep');
        $window.localStorage.removeItem('loginPage');
        $window.localStorage.removeItem('prevStep');
        $window.localStorage.removeItem('currentStep');
        $window.localStorage.removeItem('formName');
        $window.sessionStorage.removeItem('email');
        $window.sessionStorage.removeItem('userId');
    }
    $scope.init();

    $scope.saveStep1 = function(){
        console.log($scope.user);
    }

    $scope.saveStep2 = function(){
        console.log($scope.user);
        console.log($scope.file_ustav);
        console.log($scope.file_rekvisity);
        console.log($scope.file_uchdocs);
    }
    
    $scope.addSpecialization = function(){
        $scope.user.specializations.push('');
    }

    $scope.saveAll = function(){
        var language = angular.element(document.getElementById('language'));
        var lessons = angular.element(document.getElementById('lessons'));
        var groups = angular.element(document.getElementById('groups'));
        // if(language)
        $scope.user.language = language.val();
        $scope.user.lessons = lessons.val();
        $scope.user.groups = groups.val();
        $scope.user.srokObuch = $scope.user.srokObuch.replace('г','');
        $scope.user.file_ustav = $scope.file_ustav.name;
        $scope.user.file_rekvisity = $scope.file_rekvisity.name;
        $scope.user.file_uchdocs = $scope.file_uchdocs.name;
        console.log($scope.user);
        $scope.register();
    }

    $scope.register = function(){
        // $scope.user.file_uchdocs = $scope.file_uchdocs;
        // $scope.user.file_rekvisity = $scope.file_rekvisity;
        // $scope.user.file_ustav = $scope.file_ustav;
        // $scope.user.strSpecializations=$scope.user.specializations.map(val => {
        //     var temp = val.replace(',','');
        //     return temp;
        // }).join(',');
        console.log($scope.user);
        $http({
            method:"POST",
            url:"functions/registration.php",
            data:$scope.user
           }).then(function(data){
                console.log(data);
                console.log(parseInt(data.data.replace(' ','')));
                var insertedId = parseInt(data.data.replace(' ',''));
                console.log('crassavchik' + $scope.user.email);
                // $cookies.put('email',$scope.user.email);
                $window.sessionStorage.setItem('email',$scope.user.email);
                $window.sessionStorage.setItem('userId',insertedId);
                $scope.saveUserSpecs(insertedId);
                 // $window.location.href = 'thanks.html';
            });
    }

    $scope.toLogin = function(){

        $window.location.href = '19_login.html';
    }

    $scope.saveUserSpecs = function(id){
        let values = '(';
        $scope.user.specializations.map(val=>{
            values = values + id + ",'" + val + "'),(";
        });
        values += id + ",'"+ $scope.user.specialization + "')";
        console.log('specs: ', values);
        $http({
            method:"POST",
            url:"functions/user-spec/user-spec-post.php",
            data:{specValues: values}
        }).then(function(data){
            console.log(data);
            console.log('specValues:' , values);
            $timeout(function () {
                // $window.location.href = 'thanks.html';
            }, 120);
            // var insertedId = parseInt(data.data.replace(' ',''));
            // console.log('crassavchik' + $scope.user.email);
            // $cookies.put('email',$scope.user.email);
            // $window.sessionStorage.setItem('email',$scope.user.email);
            // $window.sessionStorage.setItem('userId',insertedId);
            // $window.location.href = 'thanks.html';
        });
    }

    // $scope.uploadFiles = function(){
    //     var fd = new FormData();
    //     var files = document.getElementById('file').files[0];
    //     fd.append('file',files);

    //     $http({
    //         method: 'post',
    //         url: 'functions/upload.php',
    //         data: fd,
    //         headers: {'Content-Type': undefined},
    //     }).then(function successCallback(response) { 
    //         console.log('first ok');
    //     });
    // }

    $scope.onSelectChange = function(){
        console.log('hello');
    }
});
app.directive('fileModel', ['$parse', function ($parse) {
    return {
       restrict: 'A',
       link: function(scope, element, attrs) {
          var model = $parse(attrs.fileModel);
          var modelSetter = model.assign;
          
          element.bind('change', function() {
             scope.$apply(function() {
                modelSetter(scope, element[0].files[0]);
             });
          });
       }
    };
 }]);