<?php
include './functions.php';

$hash = $_GET['hash'];
$tableId = $_GET['tableId'];


if(!isset($hash) || !isset($tableId) || strlen($hash)<60 || strlen($tableId)<60) die();



$cnn = db__connect();
$data = getFinalData($cnn, $tableId);

if(!db__rowNum($cnn, "user", "user", $hash, "table", $tableId, "state", "1")){
    $itemId = hash('sha256', time().$hash.$tableId.rand(222,999));

    db__pushData($cnn, "account", array(
        "id" => $itemId,
        "table" => $tableId,
        "user" => $hash,
        "type" => 'placeholde',
        "state" => '0',
        "value" => $data['average'],
        "created_at" => date("Y-m-d H:i:s", time())
    ));
}
    db__pushData($cnn, "user", array(
        "user" => $hash,
        "table" => $tableId,
        "state" => '1',
        "created_at" => date("Y-m-d H:i:s", time())
    ), array(
        "user" => $hash,
        "table" => $tableId
    ));


setcookie("tableId", $tableId, time()+3600*12*60*365, "/");


echo '<script>alert("加入成功！");window.location.href="../"</script>';
