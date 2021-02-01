<?php
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

$this->post('', function ($data) {
  $this->core->loadModule('template')->render('api', $data);
});

/*
$this->get('login', function ($data) {
  $this->core->loadModule('template')->render('login', $data);
});

$this->post('login', function ($data) {
  extract($_POST);
  if(ldapLogin($login, $password)) {
    $_SESSION['user'] = $login;
    header("Location: ./");
    $this->core->loadModule('template')->render('home', $data);
  } else {
    $error = array(
      'msg' => 'Usuário ou senha inválidos.',
      'error' => true
    );
    $this->core->loadModule('template')->render('login', $data, $error);
  }
});

$this->get('logout', function($data) {
  $this->core->loadModule('template')->render('logout', $data);
});

*/