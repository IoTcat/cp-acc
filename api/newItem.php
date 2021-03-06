<?php

include './functions.php';


$url = $_GET['url'];
$passby = $_GET['passby'];


if(!isset($url) || !isset($passby)) die();



/* special php program */
set_time_limit(0);
ob_end_clean();
header("Connection: close");
header("Location: https://cp-acc.yimian.xyz/"); 
ob_start();


$passby = json_decode(base64_decode($passby), true);

$tableId = $passby['tableId'];
$value = $passby['value'];
$hash = $passby['hash'];

$itemId = hash('sha256', time().$hash.$tableId);

$cnn = db__connect();

db__pushData($cnn, "account", array(
	"id" => $itemId,
	"table" => $tableId,
	"user" => $hash,
	"type" => 'external',
	"state" => '1',
	"value" => $value,
	"url" => $url,
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


$data = getFinalData($cnn, $tableId);

$threshold = getThreshold($cnn, $tableId);

while(!checkBalance($data, $threshold)){
	asort($data['virtualTotals']);
	reset($data['virtualTotals']);
	$first = key($data['virtualTotals']);
	end($data['virtualTotals']);
	$last = key($data['virtualTotals']);
	if($data['average'] - $data['virtualTotals'][$first] > $threshold){
        $divisor_f = ($data['average'] - $data['virtualTotals'][$first])/$threshold;
        settype($divisor_f, "int");
        $divisor_l = ($data['virtualTotals'][$last] - $data['average'])/$threshold;
        settype($divisor_l, "int");
		setBalance($first, $last, min($divisor_f, $divisor_l)*$threshold, $tableId, $cnn);
	}
    Sleep(10);
	$data = getFinalData($cnn, $tableId);
}



