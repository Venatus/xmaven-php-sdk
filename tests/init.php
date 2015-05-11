<?php
// Include Composer Autoloader
require_once(__DIR__ . "/../vendor/autoload.php");

$xm = new Xmaven\API($userId, $privateKey);
$res = $xm->makeRequest('POST','/v1/media',array(),array(
  'title' => 'test',
));
var_dump($res);