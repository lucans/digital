<?php

$link = mysqli_connect("localhost","root","","db_digitalgit");
// $link = mysqli_connect('192.168.10.20','root','proxy','db_digitalgit');

// mysqli_select_db($link, "db_lucas");



include('DaoBasico.php');
require_once('../server/class/caderno.php');
require_once('../server/class/materia.php');
require_once('../server/class/tarefa.php');


include('daoCaderno.php');
include('daoTopico.php');
include('daoUser.php');
include('daoTarefa.php');

include('loadUser.php');
include('loadCaderno.php');
include('loadTopico.php');

include('loadTarefa.php');

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
