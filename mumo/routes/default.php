<?php

/* $this->get('', function () {
  $response = array(
    'msg' => 'file not found',
    'error' => 'true',
    'user' => 'none',
    'statusCode' => 404
  );
  header('X-PHP-Response-Code: 404', true, 404);
  echo json_encode($response);
}); */

$this->get('login', function () {
  $response = array(
    'msg' => 'file not found',
    'error' => 'true',
    'user' => 'none',
    'statusCode' => 404
  );
  header('X-PHP-Response-Code: 404', true, 404);
  echo json_encode($response);
});

$this->get('contratos_ativos', function () {
  $this->core->loadModule('template')->render('contratos_ativos', $_GET ?? NULL);
});

$this->post('login', function () {
  (string)$user = '';
  (string)$token = '';
  $data = json_decode(file_get_contents('php://input'), true);
  $user = $data['user'];
  $token = $data['token'];
  if($user && $token) {
    $this->core->loadModule('template')->render('login', $user, $token, $_POST);
  } else {
    $response = array(
      'msg' => 'user not provided',
      'error' => 'true',
      'user' => '',
      'statusCode' => 403
    );
    header('X-PHP-Response-Code: 403', true, 403);
    echo json_encode($response);
  }
});

$this->get('{uri}', function ($data) {
  $this->core->loadModule('template')->render('api', $data);
});

$this->get('{uri}/{data}', function ($data) {
  $this->core->loadModule('template')->render('api', $data);
});

$this->get('', function ($data) {
  $this->core->loadModule('template')->render('api', $data);
});

$this->post('{uri}', function ($data) {
  $this->core->loadModule('template')->render('api', $data);
});

$this->post('{uri}/{data}', function ($data) {
  $this->core->loadModule('template')->render('api', $data);
});

$this->post('', function () {
  $response = array(
    'msg' => 'file not found',
    'error' => 'true',
    'user' => 'none',
    'statusCode' => 404
  );
  header('X-PHP-Response-Code: 404', true, 404);
  echo json_encode($response);
});

// Load another router files if you want to separate each route on it's own file

// API route files
