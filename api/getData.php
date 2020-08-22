<?php
include './functions.php';
header("Content-type:application/json");

$hash = $_REQUEST['hash'];


if(!isset($hash)) die();

$cnn = db__connect();
$res = db__getData($cnn, "user", "user", $hash, "state", '1');

$o = [];

foreach($res as $item){
	array_push($o, getFinalData($cnn, $item['table']));
}



echo json_encode($o);
