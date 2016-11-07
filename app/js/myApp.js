    var app = angular.module('digitalNote', ['ngRoute', 'textAngular','ngMask']);

        app.config(['$routeProvider',
          function($routeProvider) {
            $routeProvider.
         
            when('/Materias', {
                templateUrl: 'app/views/materias.html',
                controller: 'topicoController'
            }).
            when('/NovoTopico', {
                templateUrl: 'app/views/materia-new.html',
                controller: 'topicoController'
            }).
            when('/TopicoConteudo', {
                templateUrl: 'app/views/topico-conteudo.html',
                controller: 'topicoController'
            }).
            when('/Tarefas', {
                templateUrl: 'app/views/tarefas.html',
                controller: 'topicoController'
            }).
            when('/NovoCaderno', {
                templateUrl: 'app/views/caderno-new.html',
                controller: 'topicoController'
            }).
            when('/Cadernos', {
                templateUrl: 'app/views/cadernos.html',
                controller: 'cadernoController'
            }).
            when('/Login', {
                templateUrl: 'app/views/login.html',
                controller: 'topicoController'
            }).            
            when('/Cadastro', {
                templateUrl: 'app/views/cadastro.html',
                controller: 'topicoController'
            }).
            when('/Config', {
                templateUrl: 'app/views/config.html',
                controller: 'topicoController'
            }).
            when('/Home', {
                templateUrl: 'app/views/home.html',
                controller: 'topicoController'
            }).
            otherwise({
                redirectTo: '/Materias'
            });
        }]);
         
        
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

    app.controller("topicoController", ['$scope','RequestData','InputData','RequestDataOne','$location','$rootScope','$anchorScroll','$timeout','$http', function ($scope, RequestData, InputData, RequestDataOne, $location, $rootScope, $anchorScroll, $timeout, $http) {	

        $rootScope.rotas = ['/Cadernos','/NovoTopico','/TopicoConteudo','/Atividades','/NovoCaderno','/Home'];    
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
                $location.path(rota);
            }
        };

        $scope.getTopicos = function(){
            RequestData.getServerData('Topicos').then(function (dados) {
                $scope.topicos = dados;
            });           
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

        $scope.loadTopicosAnos = function(ano){  
            if (!ano) {ano = 'Todos'; }                                   
            RequestDataOne.getServerData('loadTopicosAnos').then(function (dados) {                       
                $scope.topicosAnos = dados;                            
            });  
        }

        $scope.getOneTopico = function(codtopico, rota){
          $rootScope.topico = [];   
            $scope.showInfos = false;
            RequestDataOne.getServerData('loadOneTopico', codtopico).then(function (dados) {                       
                $rootScope.topico = dados[0];                      
                $scope.conexoes = $rootScope.topico.conexoes.split(",");
                $scope.goRota(rota);  
            }); 
            $scope.showInfos = true;
        };

        $scope.checarCampos = function(topico){  
    
            topico.tema = (!topico.tema) ? 'default' : topico.tema;               

            if(!topico.codtopico) {
                $scope.inputTopico(topico);
                $scope.showToast("Inserido!"); 
            } else {
                $scope.updateTopico(topico);
                $scope.showToast("Atualizado!"); 
            };

            $scope.goRota('/Materias');              
        };

        $scope.showToast = function (message, time){
          if(!time) { time = 2000 };
            Materialize.toast(message, time);        
        };

        $scope.checarCamposCaderno = function(caderno){       
            if(!caderno.codcaderno) {
                $scope.showToast('Inserido!');
                $scope.inputCaderno(caderno);
            }else{
                $scope.showToast('Atualizado!');
                $scope.updateCaderno(caderno);
            }
        };

        $scope.updateTopico = function(oTopico){            
            InputData.send('updateTopico', oTopico);  
        };

        $scope.inputTopico = function(oTopico){
            InputData.send('inputTopico', oTopico);        
        };

        $scope.updateCaderno = function(oCaderno){

            $scope.p = 'updateCaderno';
    
            $http.post("dao/redirect.php?p=" + $scope.p, {
                oCaderno: oCaderno
            }).success(function(result){
                $scope.caderno = result;
            });
            
            $scope.goRota('/Cadernos');
        };

        $scope.inputCaderno = function(oCaderno){
            InputData.send('inputCaderno', oCaderno);  
            $scope.goRota('/Cadernos');
        };

        $scope.getTarefasAtrasadas = function(codcaderno){
            RequestDataOne.getServerData('getTarefasAtrasadas', codcaderno).then(function (dados) {       
                $scope.atrasadas = dados;   
            });
            return $scope.atrasadas;
        };

        $scope.topicoConteudo = function(oTopico) {
            RequestDataOne.getServerData('loadOneTopico', codtopico).then(function (dados) {                       
                $scope.topicosCodNomeTema = dados;                  
            });  
            $rootScope.topico = oTopico;           
        };

        $scope.deleteMateria = function(codtopico){     
                RequestDataOne.getServerData('deleteMateria', codtopico).then(function (dados) {                       
                  $rootScope.msg = dados;      

                if ($rootScope.msg == 'true') {
                  $scope.showToast('Deletado com sucesso!', 5000);
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

    app.controller("tarefasController", ['$scope','RequestData','InputData','RequestDataOne','$rootScope', '$location', '$timeout', function ($scope, RequestData, InputData, RequestDataOne, $rootScope, $location, $timeout) {          

        $scope.addTarefa = function(tarefa, codcaderno){         
            tarefa.codcaderno = codcaderno;                     
            tarefa.valor = 'false';   

            $scope.inputTarefa(tarefa);
            $scope.getTarefas(codcaderno);
            $scope.showToast("Tarefa adicionada!");
        };

        $scope.removeTarefa = function(oTarefa){            
            $scope.aux = $scope.tarefas.indexOf(oTarefa);
            $scope.tarefas.splice($scope.aux, 1);
            $scope.deleteTarefa(oTarefa);
            $scope.showToast("Tarefa deletada!");
        };

        $scope.getTarefas = function(codcaderno){
            RequestDataOne.getServerData('getTarefas', codcaderno).then(function (dados) {                       
                $scope.tarefas = dados;           
            }); 
        };

        $scope.updateTarefa = function(oTarefa){        
            InputData.send('updateTarefa', oTarefa);              
        };  

        $scope.deleteTarefa = function(oTarefa){        
            InputData.send('deleteTarefa', oTarefa);              
        };

        $scope.inputTarefa = function(oTarefa){
            InputData.send('inputTarefa', oTarefa);              
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

    app.controller("cadernoController", ['$scope','RequestData','InputData','RequestDataOne','$rootScope', '$location', '$timeout', function ($scope, RequestData, InputData, RequestDataOne, $rootScope, $location, $timeout) {                  

        $scope.goRota = function(rota){           
            if (rota) {                 
                $location.path(rota);         
            }
        };

        $scope.getCadernos = function(){
            RequestData.getServerData('Cadernos').then(function (dados) {    
                $scope.cadernos = dados;                          
            });
        };        

        $scope.getTopicosByCaderno = function(codcaderno){
            RequestDataOne.getServerData('getTopicosByCaderno', codcaderno).then(function (dados) {
                $scope.topicosAnos = dados;
            });           
        };

        $scope.getOneCaderno = function(codcaderno, rota){
          $rootScope.caderno = [];      
            RequestDataOne.getServerData('loadOneCaderno', codcaderno).then(function (dados) {                       
                $rootScope.caderno = dados[0];             
                $scope.goRota(rota);                      
            }); 
        };

        $scope.deleteCaderno = function(codcaderno){     
                RequestDataOne.getServerData('deleteCaderno', codcaderno).then(function (dados) {                       
                  $rootScope.msg = dados;      

                if ($rootScope.msg == 'true') {
                  $scope.showToast('Deletado com sucesso!', 5000);
                  $scope.goRota('/Cadernos');
                } else {
                  $scope.showToast('O Caderno não pode ser deletado pois possui Matérias', 5000);
                }    
            }); 
        };

    }]);

    app.controller("loginController", ['$scope','RequestData','InputData','RequestDataOne','$rootScope', '$location', '$timeout','RequestDataThree', function ($scope, RequestData, InputData, RequestDataOne, $rootScope, $location, $timeout, RequestDataThree) {                  
        

        $scope.verificaUserSession = function(){
            RequestDataThree.getServerData('verificaUserSession').then(function (dados) {  
                if (dados != 'false') {                    
                    $rootScope.user = dados[0];
                } else {
                    $scope.goRota('/Login');                
                }
            }); 
        };

        $scope.verificaUserSession();

        $scope.userAuth = function(user){            
            RequestDataThree.getServerData('userAuth', user.email, user.password).then(function (dados) {  
                $rootScope.user = dados[0];
                if ($rootScope.user) {
                    $scope.goRota('/Cadernos'); 
                } 
            }); 
        };
        
        $scope.limpaUser = function(){
            RequestDataThree.getServerData('limpaUser').then(function (dados) {                       
                console.log("limpo");  
                $rootScope.user = [];
            }); 
        }

        $scope.goRota = function(rota){ 
            if (rota) {
                $location.path(rota);                           
            }
        };

        $scope.bLogin = true;            
        $scope.switchCadastroLogin = function(){
            $scope.bLogin =  !$scope.bLogin;
            $scope.bCadastro = !$scope.bCadastro;
        };

        $scope.checaUser = function(user){            
            if (user.coduser) { 
                $scope.updateUser(user); 
                $scope.showToast("Atualizado!");
                $scope.goRota('/Cadernos');
            } else {
                if (user.password1 === user.password2) {    
                    user.password = user.password1;                    
                    $scope.inputUser(user);
                    $scope.switchCadastroLogin();                
                } else {
                    $scope.showToast('A senha não está correta!', 2000);
                }
            }
        }

        $scope.inputUser = function(oUser){
            InputData.send('inputUser', oUser);
        };

        $scope.updateUser = function(oUser){
            InputData.send('updateUser', oUser);            
        };        

}]);