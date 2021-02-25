<?php
$core = Core::getInstance();
$api = $core->loadModule('api');
echo json_decode($api->validarQualifica($data[0], true));
