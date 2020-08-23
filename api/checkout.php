<?php

include './functions.php';

$hash = $_GET['hash'];
$tableId = $_GET['tableId'];


if(!isset($hash) || !isset($tableId)) die();


/* special php program */
set_time_limit(0);
ob_end_clean();
header("Connection: close");
ob_start();


$cnn = db__connect();

$data = getFinalData($cnn, $tableId);

echo '<script>alert("您已退出！请根据邮件提示进行checkout!!");window.location.href="https://cp-acc.yimian.xyz/"</script>';

db__pushData($cnn, "user", array(
	"state" => '0',
	"updated_at" => date("Y-m-d H:i:s", time())
), array(
	"user" => $hash,
	"table" => $tableId
));


$itemId = hash('sha256', time().$hash.$tableId.rand(222,999));
db__pushData($cnn, "account", array(
    "id" => $itemId,
    "table" => $tableId,
    "user" => $hash,
    "type" => 'placeholde',
    "state" => '0',
    "value" => -$data['average'],
    "created_at" => date("Y-m-d H:i:s", time())
));

/* close connection */
ob_end_flush();
flush();
if (function_exists("fastcgi_finish_request")) {
    fastcgi_finish_request();
}
sleep(2);
ignore_user_abort(true);
set_time_limit(0);



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



