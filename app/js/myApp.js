    var app = angular.module('digitalNote', ['ngRoute', 'textAngular','ngMask']);

        app.config(['$routeProvider',
          function($routeProvider) {
            $routeProvider.
         
            when('/Materias', {
                templateUrl: 'app/views/materias.html',
                controller: 'materiaController'
            }).            
            when('/MateriasNovo', {
                templateUrl: 'app/views/materias_novo.html',
                controller: 'materiaController'
            }).
            when('/NovaMateria', {
                templateUrl: 'app/views/materia-new.html',
                controller: 'materiaController'
            }).
            when('/TopicoConteudo', {
                templateUrl: 'app/views/topico-conteudo.html',
                controller: 'materiaController'
            }).
            when('/Tarefas', {
                templateUrl: 'app/views/tarefas.html',
                controller: 'materiaController'
            }).
            when('/NovoCaderno', {
                templateUrl: 'app/views/caderno-new.html',
                controller: 'materiaController'
            }).
            when('/Cadernos', {
                templateUrl: 'app/views/cadernos.html',
                controller: 'cadernoController'
            }).
            when('/Login', {
                templateUrl: 'app/views/login.html',
                controller: 'loginController'
            }).            
            when('/Cadastro', {
                templateUrl: 'app/views/cadastro.html',
                controller: 'materiaController'
            }).
            when('/Config', {
                templateUrl: 'app/views/config.html',
                controller: 'materiaController'
            }).
            when('/Home', {
                templateUrl: 'app/views/home.html',
                controller: 'materiaController'
            }).
            otherwise({
                redirectTo: '/Cadernos'
            });
        }]);
         
    
    app.service("toast", function () {

        this.showToast = function (message, time){
          if(!time) { time = 2000 };
            Materialize.toast(message, time);        
        };

    });    

    app.service("route", function ($location) {

        this.goRota = function(rota){
            if (rota) {                 
                $location.path(rota);         
            }
        };

    });

    app.service("InputData", function ($http) {
        this.send = function(sRequestName, oParametros) {
            $http.post("dao/add.php?p=" + sRequestName, {
                oParametros: oParametros
            });
        }; 
    });

    app.factory("RequestData", function ($http, $q) {
        return {
            getServerData: function(p, c) 
            {
                var p = arguments[0] ? arguments[0] : "";
                var deferred = $q.defer();
                $http.get("dao/redirect.php?p="+p+"&c="+c).success(function(data) 
                {
                    deferred.resolve(data);
                });
                return deferred.promise;
            }
        }
    });
  
    app.factory("RequestDataOne", function ($http, $q) {
        return {
            getServerData: function(p,q,c) 
            {
                var p = arguments[0] ? arguments[0] : "";
                var deferred = $q.defer();

                $http.get("dao/redirect.php?p="+p+"&q="+q+"&c="+c).success(function(data) 
                {
                    deferred.resolve(data);
                });
                return deferred.promise;
            }
        }
    });


    app.factory("RequestDataThree", function ($http, $q) {
        return {
            getServerData: function(p,q,c) 
            {
                var p = arguments[0] ? arguments[0] : "";
                var deferred = $q.defer();

                $http.get("dao/redirect.php?p="+p+"&q="+q+"&c="+c).success(function(data) 
                {
                    deferred.resolve(data);
                });
                return deferred.promise;
            }
        }
    });

    app.controller("materiaController", ['$scope','RequestData','InputData','RequestDataOne','$location','$rootScope','$anchorScroll','$timeout','$http','toast','route', function ($scope, RequestData, InputData, RequestDataOne, $location, $rootScope, $anchorScroll, $timeout, $http, toast, route) {  


      // Initialize collapse button
      $(".button-collapse").sideNav();
      // Initialize collapsible (uncomment the line below if you use the dropdown variation)
      //$('.collapsible').collapsible();
        
        var classe = "Materia";
        
        $rootScope.rotas = ['/Cadernos','/NovoMateria','/TopicoConteudo','/Atividades','/NovoCaderno','/Home'];    
        $scope.paineisTema = ['warning','primary','info','danger','success','digital','brown','grey'];

        $scope.data = new Date();        
        $scope.aSemestres = ['1','2']; 
        $scope.aAnos = [$scope.data.getFullYear()-1, $scope.data.getFullYear(), $scope.data.getFullYear()+1, $scope.data.getFullYear()+2, $scope.data.getFullYear()+3];      

        $scope.resizeMenu = function(sizeMenu, sizeConteudo){            
            $scope.slideSize = sizeMenu;
            $scope.sizeConteudo = sizeConteudo;
        }

        $scope.goRota = function(rota){ 
            if (rota) {
               route.goRota(rota);
            }
        };

        $scope.getConexoes = function(codtopico){                
            RequestDataOne.getServerData('getConexoes', codtopico, 1).then(function (dados) {                       
                $scope.aConexoes = dados;                     
            });
           return $scope.aConexoes;                   
        }    

        $scope.loadTopicoNomeTema = function(codtopico){
            RequestDataOne.getServerData('loadTopicoNomeTema', codtopico).then(function (dados) {                       
                $scope.topicosCodNomeTema = dados;                  
            });                   
        }
        
        $scope.getMaterias = function(){
            $scope.func = 'getMaterias';    
            $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe).success(function(result){
                $rootScope.materias = result;               
            });
        };   

        $scope.getOneMateria = function(codmateria){

            $scope.goRota('/Materias');

            $scope.func = 'getOneMateria';

             $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe + "&q=" + codmateria).success(function(result){
                $rootScope.materia = result[0];              
            });
        };      


        $scope.checarCamposMateria = function(materia){  
        
            if(!materia.codmateria) {
                $scope.insertMateria(materia);
                toast.showToast("Inserido!"); 
            } else {
                console.log(materia);
                $scope.updateMateria(materia);
                toast.showToast("Salvo!"); 
            };

            route.goRota('/Materias');              
        };


        $scope.updateMateria = function(oMateria){                    

            $scope.func = 'updateMateria';

            $http.post("dao/redirect.php?func=" + $scope.func + "&c=" + classe, {
                oMateria: oMateria
            }).success(function(result){               
                route.goRota('/Materias');
            });

        };

        $scope.insertMateria = function(oMateria){                      

            $scope.p = 'insertMateria';

            $http.post("dao/redirect.php?p=" + $scope.p, {
                oMateria: oMateria
            }).success(function(result){               
                route.goRota('/Materias');
            });

        };




        $scope.updateCaderno = function(oCaderno){
            $scope.p = 'updateCaderno';
    
            $http.post("dao/redirect.php?p=" + $scope.p, {
                oCaderno: oCaderno
            }).success(function(result){
                $scope.caderno = result;
                route.goRota('/Cadernos');
            });
            
        };

        $scope.inputCaderno = function(oCaderno){
            console.log("cheguei");
            $scope.p = 'insertCaderno';
            $http.post("dao/redirect.php?p=" + $scope.p, {
                oCaderno: oCaderno
            }).success(function(result){
                $scope.caderno = result;
                route.goRota('/Cadernos');
            });
        };

        $scope.getTarefasAtrasadas = function(codcaderno){
            RequestDataOne.getServerData('getTarefasAtrasadas', codcaderno).then(function (dados) {       
                $scope.atrasadas = dados;   
            });
            return $scope.atrasadas;
        };

        $scope.topicoConteudo = function(oMateria) {
            RequestDataOne.getServerData('loadOneTopico', codtopico).then(function (dados) {                       
                $scope.topicosCodNomeTema = dados;                  
            });  
            $rootScope.topico = oMateria;           
        };

        $scope.deleteMateria = function(codtopico){     
                RequestDataOne.getServerData('deleteMateria', codtopico).then(function (dados) {                       
                  $rootScope.msg = dados;      

                if ($rootScope.msg == 'true') {
                  toast.showToast('Deletado com sucesso!', 5000);
                  $scope.goRota('/Cadernos');
                }        
            }); 
        };

        $scope.openModalConexao = function(conexao){
            RequestDataOne.getServerData('openModalConexao', conexao).then(function (dados) {                       
                $rootScope.conteudoConexao = dados;                          
            }); 
        };

    }]);

    app.controller("homeController", ['$scope','RequestData','$location','$rootScope', function ($scope, RequestData, $location, $rootScope) { 

    }]);

    app.controller("tarefasController", ['$scope','$rootScope', '$timeout','$http','toast', 'route', function ($scope, $rootScope, $timeout, $http, toast, route) {

        $scope.addTarefa = function(tarefa, codcaderno){         

            console.log(tarefa, codcaderno);

            tarefa.codcaderno = codcaderno;                     
            tarefa.valor = 'false';   

            $scope.insertTarefa(tarefa);
            $scope.getTarefas(codcaderno);        
        };

        $scope.removeTarefa = function(oTarefa){            
            $scope.aux = $scope.tarefas.indexOf(oTarefa);
            $scope.tarefas.splice($scope.aux, 1);
            $scope.deleteTarefa(oTarefa);           
        };

        $scope.getTarefas = function(codcaderno){
            $scope.p = 'getTarefas';
    
            $http.get("dao/redirect.php?p=" + $scope.p + "&q=" + codcaderno).success(function(result){
                $scope.tarefas = result;               
            });
        };



        $scope.updateTarefa = function(oTarefa){        

            $scope.p = 'updateTarefa';

            $http.post("dao/redirect.php?p=" + $scope.p, {
                oTarefa: oTarefa
            }).success(function(result){               
                // route.goRota('/Materias');
            });     

        };  

        $scope.deleteTarefa = function(oTarefa){        
            InputData.send('deleteTarefa', oTarefa);   
             toast.showToast("Tarefa deletada!");           
        };

        $scope.insertTarefa = function(oTarefa){
           
            $scope.p = 'insertTarefa';

            $http.post("dao/redirect.php?p=" + $scope.p, {
                oTarefa: oTarefa
            }).success(function(result){                            
                toast.showToast("Tarefa adicionada!");
            });            
        };

        $scope.getTarefasAtrasadas = function(codcaderno){
            RequestDataOne.getServerData('getTarefasAtrasadas', codcaderno).then(function (dados) {       
                $scope.atrasadas = dados;                                   
            });
            return $scope.atrasadas;
        }

        $scope.getDay = function(){
            $scope.date = new Date();
         
            $scope.dia =  $scope.date.getDate();
            $scope.mes =  $scope.date.getMonth() + 1;
            $scope.ano =  $scope.date.getFullYear();
            $scope.today = $scope.ano + '-' + ($scope.mes < 9 ? '0' : '') + $scope.mes + '-' + ($scope.dia < 9 ? '0' : '') + $scope.dia;

            return $scope.date;
        }

        $scope.hoje = $scope.getDay();

    }]);  

    app.controller("cadernoController", ['$scope','RequestData','InputData','RequestDataOne','$rootScope', '$location', '$timeout','$http','toast','route', function ($scope, RequestData, InputData, RequestDataOne, $rootScope, $location, $timeout, $http, toast, route) {                  

        $(document).ready(function(){
            $('.collapsible').collapsible();
        });

        var classe = 'Caderno';

        $scope.goRota = function(rota){
            route.goRota(rota);
        }

        $scope.getCadernos = function(){

            $scope.func = 'getCadernos';
    
            $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe).success(function(result){
                $scope.cadernos = result;               
            });

        };        

        $scope.getMateriasByCaderno = function(codcaderno){

            var classe = "Materia"
            $scope.func = 'getMateriasByCaderno';
    
            $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe + "&q=" + codcaderno).success(function(result){
                $scope.materias = result;               
            });        

        };

        $scope.getOneCaderno = function(codcaderno){  
            $scope.func = 'getOneCaderno';
    
            $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe + "&q=" + codcaderno).success(function(result){
                $scope.caderno = result[0];          
            });
        };

        $scope.checarCamposCaderno = function(caderno){                
            if(!caderno.codcaderno) {                   
                $scope.inputCaderno(caderno);     
                toast.showToast('Inserido!');   
                $scope.getCadernos();        
            } else {                   
                $scope.updateCaderno(caderno);
                toast.showToast('Salvo!');
                $scope.getCadernos();
            }
        };        


        $scope.inputCaderno = function(oCaderno){         

            $scope.func = 'insertCaderno';

            $http.post("dao/redirect.php?func=" + $scope.func + "&c=" + classe, {

                oCaderno: oCaderno
            }).success(function(result){
                $scope.caderno = result;
                route.goRota('/Cadernos');
            });
        };

        $scope.deleteCaderno = function(codcaderno){   

            $scope.func = 'deleteCaderno';
    
            $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe + "&q=" + codcaderno).success(function(result){
                $scope.return = result;   

                if ($scope.return.msg == 'true') {
                    toast.showToast('Deletado com sucesso!', 5000);
                    $scope.getCadernos();            
                } else {
                    toast.showToast('O Caderno não pode ser deletado pois possui Matérias', 5000);
                }   
                        
            });

        };

    }]);

    app.controller("loginController", ['$scope','$rootScope', '$location', '$timeout','$http','route','toast', function ($scope, $rs, $location, $timeout, $http, route, toast) {                  
        
        var classe = 'User'; 

        // $scope.verificaUserSession = function(){
        //     RequestDataThree.getServerData('verificaUserSession').then(function (dados) {  
        //         if (dados != 'false') {                    
        //             $rs.user = dados[0];
        //         } else {
        //             $scope.goRota('/Login');                
        //         }
        //     }); 
        // };        

        $scope.verificaUserSession = function(){

            $scope.func = 'verificaUserSession';                    

            $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe).success(function(result){
                if (result != 'false') {
                    $rs.user = result[0];         
                } else {
                    route.goRota('/Login');      
                }
            });

        };

        $scope.verificaUserSession();

        $scope.userAuth = function(oUser){  

            $scope.func = 'userAuth';                    
    
            $http.post("dao/redirect.php?func=" + $scope.func + "&c=" + classe, {
                oUser: oUser
            }).success(function(result){               
                $rs.user = result[0];
                if ($rs.user) {
                    toast.showToast("Login efetuado!");
                    route.goRota('/Cadernos');                    
                } else {
                    toast.showToast("Usuário ou senha inválidos!");
                }

            });

        };
        
        $scope.cleanUserSession = function(){

            $scope.func = "cleanUserSession";

            $http.get("dao/redirect.php?func=" + $scope.func + "&c=" + classe).success(function(result){
                $rootScope.user = [];
            });

        }

        // $scope.goRota = function(rota){ 
        //     if (rota) {
        //         $location.path(rota);                           
        //     }
        // };

        // $scope.bLogin = true;            
        // $scope.switchCadastroLogin = function(){
        //     $scope.bLogin =  !$scope.bLogin;
        //     $scope.bCadastro = !$scope.bCadastro;
        // };

        // $scope.checaUser = function(user){            
        //     if (user.coduser) { 
        //         $scope.updateUser(user); 
        //         $scope.showToast("Salvo!");
        //         $scope.goRota('/Cadernos');
        //     } else {
        //         if (user.password1 === user.password2) {    
        //             user.password = user.password1;                    
        //             $scope.inputUser(user);
        //             $scope.switchCadastroLogin();                
        //         } else {
        //             $scope.showToast('A senha não está correta!', 2000);
        //         }
        //     }
        // }

        // $scope.inputUser = function(oUser){
        //     InputData.send('inputUser', oUser);
        // };

        // $scope.updateUser = function(oUser){
        //     InputData.send('updateUser', oUser);            
        // };        

}]);