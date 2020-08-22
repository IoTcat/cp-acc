<?php
include './functions.php';

$hash = $_REQUEST['hash'];
$tableId = $_REQUEST['tableId'];


if(!isset($hash) || !isset($tableId)) die();



$cnn = db__connect();

db__pushData($cnn, "user", array(
	"user" => $hash,
	"table" => $tableId,
	"state" => '1',
	"created_at" => date("Y-m-d H:i:s", time())
), array(
	"user" => $hash,
	"table" => $tableId
));

echo '<script>alert("加入成功！");window.location.href="../"</script>';