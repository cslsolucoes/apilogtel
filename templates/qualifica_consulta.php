<?php
header('Content-Type: application/json');
$core = Core::getInstance();
$api = $core->loadModule('api');
$str = str_replace(':[{', ':[', json_encode($api->validarQualifica($data[0], true)));
$str = str_replace('}]}', ']}', $str);
echo $str;