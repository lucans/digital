<?php 

include('funcoes.php');

$postdata = file_get_contents("php://input");
$aDados = json_decode($postdata);


$coduser = isset($_SESSION['user'][0]['coduser']) ?  $_SESSION['user'][0]['coduser'] : '';

$func = $_GET['func'];
$c = $_GET['c'];



if (isset($_GET['q'])) {
	$q = $_GET['q'];
} else{
	$q = '';
}

switch ($c) {
	case 'Caderno':
		$Caderno = new Caderno();
		$Caderno->$func($coduser, $q, $aDados);
		break;	
	case 'Materia':	 
		$Materia = new Materia();
		$Materia->$func($coduser, $q, $aDados);
		break;	
	case 'Tarefa':	 
		$Tarefa = new Tarefa();
		$Tarefa->$func($coduser, $q, $aDados);
		break;	
	case 'User':
		$User = new User();
		$User->$func($coduser, $q, $aDados);
		break;
	
	default:
		echo "Classe não indicada";
		break;
}

?>