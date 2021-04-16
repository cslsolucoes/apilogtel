<?php

$core = Core::getInstance();
$api = $core->loadModule('api');
$qtdContratosAtivos = $api->contratosAtivos();
$response = array(
  'quantidade' => $qtdContratosAtivos
);
echo json_encode($response);