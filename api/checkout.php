<?php

include './functions.php';

$hash = $_REQUEST['hash'];
$tableId = $_REQUEST['tableId'];


if(!isset($hash) || !isset($tableId)) die();

$cnn = db__connect();

$data = getFinalData($cnn, $tableId);

if($data['average'] > $data['virtualTotals'][$hash]){
	foreach($data['users'] as $user){
		$to = $user;
		if($to != $hash) break;
	}
	setBalance($hash, $to, $data['average'] - $data['virtualTotals'][$hash], $tableId, $cnn);
}

if($data['average'] < $data['virtualTotals'][$hash]){
	foreach($data['users'] as $user){
		$to = $user;
		if($to != $hash) break;
	}
	setBalance($to, $hash, - $data['average'] + $data['virtualTotals'][$hash], $tableId, $cnn);
}


db__pushData($cnn, "user", array(
	"state" => '0',
	"updated_at" => date("Y-m-d H:i:s", time())
), array(
	"user" => $hash,
	"table" => $tableId
));

echo '<script>alert("您已退出！请根据邮件提示进行checkout!!");window.location.href="https://cp-acc.yimian.xyz/"</script>';
