<?php
require_once('./config.inc.php');
$mem=new memcache();
$gets=$hits=0;
foreach ($memserver as $k => $s) {
	$mem->connect($s['host'],$s['port'],2);
	//echo $k."号服务器的统计情况<br>";
	//print_r($mem->getStats());
	$res=$mem->getStats();
	$gets+=$res['cmd_get'];
	$hits+=$res['get_hits'];
	
}
//echo $hits;
$rate=1;
if($gets>0){
	//echo $hits.' '. $gets;
	$rate=$hits/$gets;
}

echo $rate;