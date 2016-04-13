<?php
//配制文件,配制Memecache的节点信息
$memserver=array();
$memserver['A']=array('host'=>'127.0.0.1','port'=>'11211');
$memserver['B']=array('host'=>'127.0.0.1','port'=>'11212');
$memserver['C']=array('host'=>'127.0.0.1','port'=>'11213');
$memserver['D']=array('host'=>'127.0.0.1','port'=>'11214');
$memserver['E']=array('host'=>'127.0.0.1','port'=>'11215');

//$dis='Moder';//Consistent
$dis='Consistent';