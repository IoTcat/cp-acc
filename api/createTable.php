<?php
include './functions.php';

header("Content-type:application/json");

$hash = $_GET['hash'];
$name = $_GET['name'];
$threshold = $_GET['threshold'];


if(!isset($hash) || !isset($name) || !isset($threshold)) die();


$tableId = hash('sha256', time().$hash.$name);

$cnn = db__connect();
db__pushData($cnn, "table", array(
	"id" => $tableId,
	"state" => '1',
	"name" => $name,
	"threshold" => $threshold,
	"created_by" => $hash,
	"created_at" => date("Y-m-d H:i:s", time())
));

db__pushData($cnn, "user", array(
	"user" => $hash,
	"table" => $tableId,
	"state" => '1',
	"created_at" => date("Y-m-d H:i:s", time())
), array(
	"user" => $hash,
	"table" => $tableId
));


echo json_encode(array(
	"tableId" => $tableId
));
