<?php
include('funcoes.php');

$postdata = file_get_contents("php://input");
$oRequestInfo = json_decode($postdata);


if($_GET['p'] == 'inputTopico'){
	inputTopico($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'updateTopico'){
	updateTopico($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'inputCaderno'){
	inputCaderno($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'updateCaderno'){
	updateCaderno($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'inputUser'){
	inputUser($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'updateUser'){
	updateUser($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'inputTarefa'){
	inputTarefa($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'updateTarefa'){
	updateTarefa($oRequestInfo->oParametros);
}
else if($_GET['p'] == 'deleteTarefa'){
	deleteTarefa($oRequestInfo->oParametros);
}
?>