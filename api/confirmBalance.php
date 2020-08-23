<?php
include './functions.php';

$first = $_GET['first'];
$last = $_GET['last'];



if(!isset($first) || !isset($last)) die();

$cnn = db__connect();

if(!db__rowNum($cnn, "account", "id", $first) || !db__rowNum($cnn, "account", "id", $last)) die();

db__pushData($cnn, "account", array(
	"state" => '1'
), array(
	"id" => $first
));

db__pushData($cnn, "account", array(
	"state" => '1'
), array(
	"id" => $last
));

echo '<script>
alert("收款确认成功");
window.location.href="https://cp-acc.yimian.xyz/";
</script>';
