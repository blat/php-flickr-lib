<?php

define('APP_ROOT', dirname(__FILE__));
define('CACHE_DIR', APP_ROOT . '/tmp');
require_once APP_ROOT . '/flickr.php';

$config = parse_ini_file(APP_ROOT . '/config.ini', true);

$flickr = new Flickr($config);
$flickr->api_key = $config['api_key'];

var_dump($flickr->photos->getInfo(array('photo_id' => '4996628146')));
var_dump($flickr->photosets->getList(array('user_id' => '44244432@N03')));
