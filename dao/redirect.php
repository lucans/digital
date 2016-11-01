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
	case 'Topicos':
		loadTopicos();
		break;
	case 'Cadernos':
		$Caderno = new Caderno();
		$Caderno->getCadernos($_SESSION['user'][0]['coduser']);
		break;
	case 'loadOneCaderno':
		$Caderno = new Caderno();
		$Caderno->getOneCaderno($_SESSION['user'][0]['coduser'], $q);
		break;
	case 'getTopicosByCaderno':
		$Materia = new Materia();
		$Materia->getTopicosByCaderno($_SESSION['user'][0]['coduser'], $q);
		break;	

	case 'updateCaderno':
		$Caderno = new Caderno();
		$Caderno->updateCaderno($_SESSION['user'][0]['coduser'], $q, $aDados);
		// updateCaderno($oRequestInfo->oParametros);
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


	case 'deleteCaderno':
		deleteCaderno($q);
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
	case 'getTarefas':
		loadTarefas($q);
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