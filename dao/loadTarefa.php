<?php
function loadTarefas($q){
	global $link;

	$sQuery = "SELECT * FROM tarefas WHERE codcaderno = '$q' ORDER BY prazo DESC";
	$aTarefa = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aTarefa, arrayEncode((array)$oResult));
	}
	echo json_encode($aTarefa);
} 

function loadTarefasDone($q){
	global $link;

	$sQuery = "SELECT * FROM tarefas WHERE codcaderno = '$q' ";
	$aTarefa = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aTarefa, arrayEncode((array)$oResult));
	}
	echo json_encode($aTarefa);
} 



function loadTarefasAtrasadas($q){
	global $link;

	$sQuery = "SELECT COUNT(*) as atrasadas FROM tarefas WHERE prazo < CURDATE() AND valor = '0' AND codcaderno = $q ";	
	
	$sQuery2 = mysqli_query($link, $sQuery) or die($sQuery . mysql_error());

	// $sResult = mysqli_result($sQuery2, 0, tarefas);

	$sResult = mysqli_fetch_object($sQuery2)->atrasadas;


	$iAtrasadas = $sResult * 1; 


	return $iAtrasadas;
} 

function loadTarefasConcluidas($q){
	global $link;

	$sQuery = "SELECT COUNT(*) as concluidas FROM tarefas WHERE valor = '1' AND conclusao != '' AND codcaderno = $q";	
	
	$sQuery2 = mysqli_query($link, $sQuery) or die($sQuery . mysql_error());

	// $sResult = mysqli_result($sQuery2, 0);
	$sResult = mysqli_fetch_object($sQuery2)->concluidas;

	$iConcluidas = $sResult * 1; 


	return $iConcluidas;
} 


function loadTarefasToDo($q){
	global $link;

	$sQuery = "SELECT COUNT(*) as todo FROM tarefas WHERE prazo >= CURDATE() AND valor = '0' AND codcaderno = $q ";	
	
	$sQuery2 = mysqli_query($link, $sQuery) or die($sQuery . mysql_error());

	// $sResult = mysqli_result($sQuery2, 0);

	$sResult = mysqli_fetch_object($sQuery2)->todo;


	$iAtuais = $sResult * 1; 


	return $iAtuais;
} 
?>