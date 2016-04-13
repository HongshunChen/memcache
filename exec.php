<?php
require_once('./config.inc.php');
require_once('./hash.php');
$mem=new memcache();
$diser =new $dis();
foreach ($memserver as $k => $s) {
	$diser->addNode($k);
	# code...
}
set_time_limit(0);
/*echo 'jfsjd';
$diser->printNodes();
echo $diser->num;*/
//$diser->printPosition();
$diser->delNode('D');
//$diser->printPosition();
//exit;
/*$diser->printNodes();
echo $diser->num;
exit;*/
for($i=0;$i<100000;$i++){
	$i=$i%10000;
	$serv=$memserver[$diser->lookup('key'.$i)];
	$mem->connect($serv['host'],$serv['port'],2);
	if(!$mem->get('key'.$i)){
		$mem->set('key'.$i,'value'.$i,0,0);    
	}
	$mem->close();
	usleep(3000);

}