<?php
include './functions.php';

$tableId = $_REQUEST['tableId'];
$name = $_REQUEST['name'];
$threshold = $_REQUEST['threshold'];


if(!isset($tableId) || !isset($name) || !isset($threshold)) die();


$cnn = db__connect();
db__pushData($cnn, "table", array(
	"id" => $tableId,
	"state" => '1',
	"name" => $name,
	"threshold" => $threshold,
	"updated_at" => date("Y-m-d H:i:s", time())
), array(
	"id" => $tableId
));
