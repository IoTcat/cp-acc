<?php
include './functions.php';

$first = $_REQUEST['first'];
$last = $_REQUEST['last'];


if(!isset($first) || !isset($last)) die();

$cnn = db__connect();

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