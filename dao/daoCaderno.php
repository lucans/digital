<?php

function inputCaderno($oParametros) {
	global $link;

	echo 'Input Caderno';
	echo '<pre>';
	print_r($oParametros);

	$coduser = $_SESSION['user'][0]['coduser'];
	
	$sQuery = "INSERT INTO cadernos SET "
						."nomecaderno = '".utf8_decode($oParametros->nomecaderno)."' , "
						."atrasadas = '$oParametros->atrasadas' , "
						."concluidas = '$oParametros->concluidas' , "
						."atuais = '$oParametros->atuais' , "
						."coduser = '$coduser' , "
						."dtalteracao = NOW()";
											
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 
}

function updateCaderno($oParametros) {	
	global $link;
	
	$oParametros->atrasadas = loadTarefasAtrasadas($oParametros->codcaderno);
	if (empty($oParametros->atrasadas)) {
		$oParametros->atrasadas = 0;
	}	

	$oParametros->concluidas = loadTarefasConcluidas($oParametros->codcaderno);
	if (empty($oParametros->concluidas)) {
		$oParametros->concluidas = 0;
	}	

	$oParametros->atuais = loadTarefasToDo($oParametros->codcaderno);
	if (empty($oParametros->atuais)) {
		$oParametros->atuais = 0;
	}

	echo 'Update Caderno';
	echo '<pre>';
	print_r($oParametros);

	$sQuery = "UPDATE cadernos SET "
						."nomecaderno = '".utf8_decode($oParametros->nomecaderno)."' , "			
						."atrasadas = '$oParametros->atrasadas' , "			
						."concluidas = '$oParametros->concluidas' , "			
						."atuais = '$oParametros->atuais' , "			
						."dtalteracao = NOW() WHERE codcaderno = '$oParametros->codcaderno' ";
						
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 	
}

function switchAtivoCaderno($q, $sAtivo) {	
	global $link;

	if ($sAtivo == 'S') { $aux = 'N';} else { $aux = 'S'; };

	$sQuery = "UPDATE cadernos SET ativo = '$aux' WHERE codcaderno = '$q' ";				
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 	
}
?>