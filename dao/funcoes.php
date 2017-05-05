<?php

if ($_SERVER['DOCUMENT_ROOT'] == 'C:/Users/Lucas/Documents/GitHub') {
	$link = mysqli_connect('192.168.10.20','root','proxy','db_digitalgit');
} else {
	$link = mysqli_connect("localhost","root","","db_digitalgit");
}


include('DaoBasico.php');
require_once('../server/class/caderno.php');
require_once('../server/class/materia.php');
require_once('../server/class/tarefa.php');
require_once('../server/class/user.php');


session_start();

function countPalavras($conteudo){
	
	if (count_chars($conteudo)) {
		$conteudo = strip_tags($conteudo);
		$aConteudo = explode(' ', $conteudo);
		$iPalavras = count($aConteudo);
		return $iPalavras;		
	}

	return $iPalavras;
}

function buildSet ($aDados) {

	$sSet = 'SET ';

	$i = 1;

	foreach ($aDados as $key => $value) {
		foreach ($value as $key2 => $value2) {

			$sSet .= $key2 . " = '" . utf8_decode($value2) . "' ";

				if ($i < sizeof((array)$value)) {
					$sSet .= ", ";
				}
				
			$i++; 
		}
	}

	return $sSet;
}




function ArrayEncode ($array) {
	if(is_object($array)){
		$array = (array) $array;
		$obj = true;
	}
	foreach ($array as $k => $v) {
		if(is_array($v))
			$array[$k] = utf8_encode($v);
		else 
			$array[$k] = utf8_encode($v);		
	}
	if(isset($obj) && $obj === true) $array = (object) $array;
	return $array;
}

function ArrayDecode ($array) {
	if(is_object($array)){
		$array = (array) $array;
		$obj = true;
	}
	foreach ($array as $k => $v) {
		if(is_array($v))
			$array[$k] = utf8_decode($v);
		else 
			$array[$k] = utf8_decode($v);		
	}
	if(isset($obj) && $obj === true) $array = (object) $array;
	return $array;
}


function stringEncode ($string){
	return utf8_encode($string);
}

function stringDecode ($string){
	return utf8_decode($string);
}


?>
