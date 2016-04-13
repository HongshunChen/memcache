<?php
require_once('./config.inc.php');
require_once("./hash.php");
$mem=new memcache();
$diser=new $dis();
foreach ($memserver as $k => $s) {
	$diser->addNode($k);
	# code...
}
set_time_limit(0);
for($i=0;$i<10000;$i++){
	$key='key'.$i;
	$value='value'.$i;
	$serv=$memserver[$diser->lookup($key)];
	$mem->connect($serv['host'],$serv['port'],2);
	$mem->add($key,$value,0,0);
	$mem->close();
}
/*foreach ($memserver as $k => $s) {
	$mem->connect($s['host'],$s['port'],2);
	for($i=1;$i<=1000;$i++){
		$mem->add('key'.$i,'value'.$i,0,0);
	}
	echo $k."服务器初始化完毕<br/>";
}*/
echo '初始化数据完成';