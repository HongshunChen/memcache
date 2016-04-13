<?php
 $mem= new Memcache;

/* connect to memcached server */
$mem->connect('127.0.0.1', 11211);

/*
set value of item with key 'var_key', using on-the-fly compression
expire time is 50 seconds
*/
$mem->set('var_key', 'some really big variable', MEMCACHE_COMPRESSED, 50);

echo $mem->get('var_key');