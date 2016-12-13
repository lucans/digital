<?php 

include('funcoes.php');

$postdata = file_get_contents("php://input");
$aDados = json_decode($postdata);


$p = $_GET['p'];

if(empty($_GET['q'])){
	$q = '';
} else {
	$q = $_GET['q'];
}

if(empty($_GET['c'])){
	$c = '';
} else {
	$c = $_GET['c'];
}


switch ($p) {
	case 'insertCaderno':
		$Caderno = new Caderno();
		$Caderno->insertCaderno($_SESSION['user'][0]['coduser'], $aDados);
		break;	

	case 'getCadernos':
		$Caderno = new Caderno();
		$Caderno->getCadernos($_SESSION['user'][0]['coduser']);
		break;

	case 'loadOneCaderno':
		$Caderno = new Caderno();
		$Caderno->getOneCaderno($_SESSION['user'][0]['coduser'], $q);
		break;

	case 'getMateriasByCaderno':
		$Materia = new Materia();
		$Materia->getMateriasByCaderno($_SESSION['user'][0]['coduser'], $q);
		break;	

	case 'updateCaderno':
		$Caderno = new Caderno();
		$Caderno->updateCaderno($_SESSION['user'][0]['coduser'], $aDados);
		break;

	case 'deleteCaderno':
		$Caderno = new Caderno();
		$Caderno->deleteCaderno($_SESSION['user'][0]['coduser'], $q);
		break;	

	case 'getMaterias':
		$Materia = new Materia();
		$Materia->getMaterias($_SESSION['user'][0]['coduser']);
		break;	

	case 'getOneMateria':
		$Materia = new Materia();
		$Materia->getOneMateria($_SESSION['user'][0]['coduser'], $q);
		break;

	case 'insertMateria':
		$Materia = new Materia();
		$Materia->insertMateria($_SESSION['user'][0]['coduser'], $aDados);
		break;	
		
	case 'updateMateria':
		$Materia = new Materia();
		$Materia->updateMateria($_SESSION['user'][0]['coduser'], $aDados);
		break;

	case 'getTarefas':
		$Tarefa = new Tarefa();
		$Tarefa->getTarefas($_SESSION['user'][0]['coduser'], $q);
		break;	

	case 'insertTarefa':
		$Tarefa = new Tarefa();
		$Tarefa->insertTarefa($_SESSION['user'][0]['coduser'], $aDados);
		break;	

	case 'updateTarefa':
		$Tarefa = new Tarefa();
		$Tarefa->updateTarefa($_SESSION['user'][0]['coduser'], $aDados);
		break;



	case 'CadernosAndTopicos':
		loadCadernosAndTopicos();
		break;
	case 'Topicos':
		loadTopicos();
		break;
	case 'loadOneTopico':
		loadOneTopico($q);
		break;
	case 'Top3':
		loadTop3();
		break;
	case 'removeTag':
		$aResultCadernosNomes = loadNomeTopicos();
		loadRemove($q, $aResultCadernosNomes);
		break;
	case 'getConexoes':
		loadConexoes($c);
		break;
	case 'loadTopicoNomeTema':
		loadTopicoNomeTema();
		break;
	case 'loadUser':
		loadUser();
		break;	
	case 'loadTopicosAnos':
		loadTopicosAnos($_SESSION['user'][0]['semestre'], $_SESSION['user'][0]['ano'], $_SESSION['user'][0]['coduser']);
		break;
	case 'countPalavras':
		countPalavras($q);
		break;		
	case 'deleteMateria':
		deleteMateria($q);
		break;	
	case 'openModalConexao':
		openModalConexao($q);
		break;	
	case 'userAuth':
		userAuth($q, $p, $c);
		break;	
	case 'getUser':
		getUser();
		break;						
	case 'getTarefasAtrasadas':
		loadTarefasAtrasadas($q);
		break;		
	case 'loadTarefasToDo':
		loadTarefasToDo($q);
		break;	
	case 'limpaUser':
		limpaUser();
		break;		
	case 'verificaUserSession':
		verificaUserSession();
		break;	
	default:		
		echo "Nenhum Case";
		break;
}
?>