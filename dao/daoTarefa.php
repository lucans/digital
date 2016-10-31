<?php

function inputTarefa($oParametros) {
	global $link;

	echo 'Input Tarefa';
	echo '<pre>';
	print_r($oParametros);

	$prazoExplode = explode('/', $oParametros->prazo);
	$prazoFinal = $prazoExplode[2] . '-' .  $prazoExplode[1] . '-' .  $prazoExplode[0];
	$oParametros->prazo = $prazoFinal;

	$sQuery = "INSERT INTO tarefas SET "
						."codcaderno = '$oParametros->codcaderno' , "
						."tarefa = '".utf8_decode($oParametros->tarefa)."' , "			
						."prazo = '".utf8_decode($oParametros->prazo)."' ";			
											
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 
}

function updateTarefa($oParametros) {
	global $link;

	$oParametros->valor = !$oParametros->valor;

	$sQuery = "UPDATE tarefas SET valor = !valor, conclusao = NOW() WHERE codtarefa = '$oParametros->codtarefa'";
						
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 	
}

function deleteTarefa($oParametros) {
	global $link;
		
	$sQuery = "DELETE FROM tarefas WHERE codtarefa = '$oParametros->codtarefa' ";						
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 	
}

?>