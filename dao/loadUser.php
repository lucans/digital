<?php 

function userAuth($q, $p, $c){
	global $link;

	$sQuery = "SELECT * FROM usuarios WHERE email = '$q' ";	

	$aResult = array();
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysqli_error()); 


	if (mysqli_num_rows($oStmt)) {
		$oResult = mysqli_fetch_object($oStmt);
		if ($oResult->password == $c) {

			$_SESSION['user'] = loadUser($oResult->email);

			echo json_encode($_SESSION['user']);
		}		
	}
}

function loadUser($q){
	global $link;

	$sQuery = "SELECT *, UPPER(LEFT(nome, 1)) as inicial, coduser, email, nome, semestre, ano FROM usuarios WHERE email = '$q' ";
	$oStmt = mysqli_query($link, $sQuery) or die($sQuery . mysqli_error()); 
	$aUser = array();

	while($oResult = mysqli_fetch_object($oStmt)){
		array_push($aUser, arrayEncode((array)$oResult));
	}

	return $aUser;
}

function verificaUserSession(){
	if (isset($_SESSION['user'])) {
		echo json_encode($_SESSION['user']);
	} else { 
		echo 'false'; 
	}
}

function limpaUser(){
	session_destroy();
}

?>