<?php

function inputTopico($oParametros) {	
	global $link;

	echo 'Input Topico';
	echo '<pre>';
	print_r($oParametros);	


	$coduser = $_SESSION['user'][0]['coduser'];

	$sQuery = "INSERT INTO topicos SET "
						."nome = '".utf8_decode($oParametros->nome)."' , "
						."professor = '".utf8_decode($oParametros->professor)."' , "
						."local = '".utf8_decode($oParametros->local)."', "
						."prioridade = '".utf8_decode($oParametros->prioridade)."' , "
						."conteudo = '".utf8_decode($oParametros->conteudo)."' , "
						."semestre = '".utf8_decode($oParametros->semestre)."' , "
						."ano = '".utf8_decode($oParametros->ano)."' , "
						."tema = '$oParametros->tema' , "
						."conexoes = '$oParametros->conexoes' ,"
						."palavras = '$oParametros->palavras' ,"
						."codcaderno = '$oParametros->codcaderno' , "
						."coduser = '$coduser', "
						."dtalteracao = NOW(), hralteracao = CURTIME()";
											
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 
}

function updateTopico($oParametros) {	
	global $link;
	
	echo 'Update Topico';
	echo '<pre>';
	print_r($oParametros);


	$oParametros->palavras = countPalavras($oParametros->conteudo);
	$oParametros->conexoes = loadConexoes($oParametros->conteudo);


	$sQuery = "UPDATE topicos SET "
						."nome = '".utf8_decode($oParametros->nome)."' , "
						."professor = '".utf8_decode($oParametros->professor)."' , "
						."local = '".utf8_decode($oParametros->local)."', "
						."prioridade = '".utf8_decode($oParametros->prioridade)."' , "
						."conteudo = '".utf8_decode($oParametros->conteudo)."' , "
						."semestre = '".utf8_decode($oParametros->semestre)."' , "
						."ano = '".utf8_decode($oParametros->ano)."' , "
						."codcaderno = '$oParametros->codcaderno' , "
						."tema = '$oParametros->tema' ,"
						."conexoes = '".utf8_decode($oParametros->conexoes)."' ,"
						."palavras = '$oParametros->palavras' ,"
						."dtalteracao = NOW(), hralteracao = CURTIME() WHERE codtopico = '$oParametros->codtopico' ";
						
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 	
}

function switchAtivoMateria($q, $sAtivo) {		
	global $link;
	
	if ($sAtivo == 'S') { $aux = 'N';} else { $aux = 'S'; };

	$sQuery = "UPDATE topicos SET ativo = '$aux' WHERE codtopico = '$q' ";				
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 	
}
?>