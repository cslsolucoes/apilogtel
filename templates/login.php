<?php

$core = Core::getInstance();
$checkUser = $core->loadModule('api');
if($checkUser->checkUser($data[0], $data[1], $data[2])) {

} else {
  $response = array(
    'msg' => 'user not provided and/or is incorrect',
    'error' => 'true',
    'user' => $data[0],
    'cpf' => '',
    'statusCode' => 403
  );
  header('X-PHP-Response-Code: 403', true, 403);
}

echo json_encode($response);