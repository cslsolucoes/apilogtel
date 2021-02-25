<?php
$core = Core::getInstance();
$api = $core->loadModule('api');
echo json_decode(json_encode($api->validarQualifica($data[0], true)));
