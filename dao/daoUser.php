<?php

function inputUser($oParametros) {
	global $link;

	echo 'Input User';
	echo '<pre>';
	print_r($oParametros);


	$sQuery = "INSERT INTO usuarios SET "
						."nome = '".utf8_decode($oParametros->nome)."' , "
						."email = '".utf8_decode($oParametros->email)."' , "
						."password = '".utf8_decode($oParametros->password)."' , "
						."semestre = '".utf8_decode($oParametros->semestre)."' , "				
						."ano = '$oParametros->ano'";						
											
	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 
}

function updateUser($oParametros) {
	global $link;

	echo 'Update User teste';
	echo '<pre>';
	print_r($oParametros);

	$sQuery = "UPDATE usuarios SET "
						."nome = '".utf8_decode($oParametros->nome)."' , "
						."email = '".utf8_decode($oParametros->email)."' , "
						."password = '".utf8_decode($oParametros->password)."' , "
						."semestre = '".utf8_decode($oParametros->semestre)."' , "				
						."ano = '$oParametros->ano' WHERE coduser = '$oParametros->coduser' ";

	mysqli_query($link, $sQuery) or die($sQuery . mysql_error()); 
}
?>