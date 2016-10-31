<?php

function loadCadernos($c){
	global $link;

	$sQuery = "SELECT *, LEFT(nomecaderno,1) as leftcaderno FROM cadernos WHERE coduser = '$c' AND ativo = 'S' ";
	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}
	
	echo json_encode($aResult);
}


function loadOneCaderno($q){
	global $link;

	$sQuery = "SELECT * FROM cadernos WHERE codcaderno = '$q' ";
	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}

	echo json_encode($aResult);
}

function deleteCaderno($q){
	global $link;

	$sQuery = "SELECT * FROM topicos WHERE codcaderno = '$q' AND ativo = 'S'";
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	$aResult = array();
	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}

	$sQuery2 = "SELECT ativo FROM cadernos WHERE codcaderno = '$q' ";
	$sStmt = mysqli_query($link, $sQuery2) or die($sQuery2 . mysql_error()); 

	$sAtivo = mysqli_fetch_object($sStmt)->ativo;


	if ($aResult) {
		echo ('false');
	} else {
		switchAtivoCaderno($q, $sAtivo);		
		echo ('true');	
	}

}


 ?>