<?php 
function loadNomeTopicos($coduser){
	global $link;

	$sQuery = "SELECT nome FROM topicos WHERE coduser = $coduser ";	
	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, utf8_encode($oResult->nome));
	}

	$aResultCadernosNomes = $aResult;	
	return $aResultCadernosNomes;
}


function loadTopicoNomeTema(){
	global $link;

	$sQuery = "SELECT codtopico, nome, tema FROM topicos";
	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}

	echo json_encode($aResult);
}

function loadTopicosAnos($semestre, $ano, $coduser){
	global $link;

	$semestreQuery = ($semestre ? "AND t.semestre = '$semestre'" : '');
	$anoQuery = ($ano != '0000' ? "AND t.ano = '$ano'" : '');


	if (empty($semestreQuery) && empty($anoQuery)) {
		$sWhere = " AND t.coduser = $coduser AND t.ativo = 'S' ORDER BY t.dtalteracao, t.hralteracao DESC";
	} else {
		$sWhere = "WHERE t.coduser = $coduser " . $anoQuery . " " .  $semestreQuery . " AND t.ativo = 'S' ORDER BY t.dtalteracao, t.hralteracao DESC";
	}

	$sQuery = "SELECT UPPER(LEFT(c.nomecaderno,1)) as leftcaderno, c.nomecaderno, t.codtopico, t.nome, t.tema, t.palavras, t.conexoes, t.codcaderno FROM cadernos c JOIN topicos t ON c.codcaderno = t.codcaderno " . $sWhere;

	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}

	echo json_encode($aResult);
}

function loadConexoes($conteudo){
	global $link;

	$aResultCadernosNomes = loadNomeTopicos($_SESSION['user'][0]['coduser']);	

	$aConexoes = loadRemove($aResultCadernosNomes, $conteudo);

	$sConexoes = implode(',', $aConexoes);
	return $sConexoes;
}

function loadRemove(&$aResultCadernosNomes, $conteudo){
	global $link;

	if (count_chars($conteudo)) {

		$conteudo = strip_tags($conteudo);
		$aConteudo = explode(' ', $conteudo);

		$aConexoes = array();

		foreach ($aConteudo as $palavra) {			
			if(array_search($palavra, $aResultCadernosNomes) !== FALSE){
				array_push($aConexoes, $palavra);
			}
		}
		return $aConexoes;
	}
}

function loadTopicos(){
	global $link;

	$sQuery = 'SELECT * FROM topicos ORDER BY dtalteracao DESC, hralteracao DESC';
	$aResult = array();
	$oStmt = mysqli_query($link,$sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}
	echo json_encode($aResult);
}

function loadTopicosByCaderno($q){
	global $link;

	$sQuery = "SELECT t.*, LEFT(c.nomecaderno, 1) as leftcaderno FROM topicos as t
	INNER JOIN cadernos c
	ON t.codcaderno = c.codcaderno

	WHERE t.codcaderno = '$q' AND t.ativo = 'S' ORDER BY t.dtalteracao DESC, t.hralteracao DESC ";


	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}
	echo json_encode($aResult);
}

function loadTop3(){
	global $link;

	$sQuery = 'SELECT * FROM topicos ORDER BY dtalteracao DESC, hralteracao DESC LIMIT 1';
	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}
	echo json_encode($aResult);
}

function loadOneTopico($q){
	global $link;

	$sQuery = "SELECT * FROM topicos WHERE codtopico = '$q' ";
	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aResult, arrayEncode((array)$oResult));
	}

	echo json_encode($aResult);
}


function countPalavras($conteudo){
	global $link;

	if (count_chars($conteudo)) {
		$conteudo = strip_tags($conteudo);
		$aConteudo = explode(' ', $conteudo);
		$iPalavras = count($aConteudo);
		return $iPalavras;		
	} 
	return $iPalavras;
}

function deleteMateria($q){
	global $link;

	$sQuery2 = "SELECT ativo FROM topicos WHERE codtopico = '$q' ";
	$sStmt = mysqli_query($link, $sQuery2) or die($sQuery2 . mysql_error()); 


	// $sAtivo = mysqli_result($sStmt, 0) or die($sQuery . mysql_error());
	$sAtivo = mysqli_fetch_object($sStmt)->ativo;

	switchAtivoMateria($q, $sAtivo);		
	echo 'true';	
}

function openModalConexao($q){
	global $link;

	$sQuery = "SELECT conteudo FROM topicos WHERE nome = '$q' ";
	$sQuery2 = mysqli_query($link, $sQuery);

	if (mysqli_num_rows($sQuery2)) {
		$sStmt = mysqli_result($sQuery2, 0); 
		$sStmt = strip_tags($sStmt);
		echo utf8_encode($sStmt);
	}
}
?>