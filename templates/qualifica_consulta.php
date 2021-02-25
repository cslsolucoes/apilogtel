<?php
$core = Core::getInstance();
$api = $core->loadModule('api');
for($i = 1; $i < 512; $i ++)
echo json_encode($api->validarQualifica($data[0], true), 0, $i);
