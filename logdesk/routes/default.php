<?php
$this->get('', function ($data) {
  if(not_logged_in()) {
    $this->core->loadModule('template')->render('login', $data);
  } else {
    $this->core->loadModule('template')->render('home', $data);
  }
});

$this->get('login', function ($data) {
  $this->core->loadModule('template')->render('login', $data);
});

$this->post('login', function ($data) {
  extract($_POST);
  if(isset($login) && isset($password) && ldapLogin($login, $password)) {
    $un = explode('@', $login);
    session_destroy();
    session_start();
    $_SESSION['username'] = $un[0];
    $_SESSION['userid'] = getUserId($_SESSION['username']);
    $_SESSION['user'] = $login;
    $_SESSION['pass'] = $password;
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

// Load another router files if you want to separate each route on it's own file
$this->loadRouteFile('cadastros/pontuacao');
$this->loadRouteFile('cadastros/penalizacoes');

// API route files
$this->loadRouteFile('api/consultar_cliente');
$this->loadRouteFile('api/consultar_ocorrencias');
$this->loadRouteFile('api/cadastrar_venda');
$this->loadRouteFile('api/criar_ocorrencia');
$this->loadRouteFile('api/consultar_onu_uid');
$this->loadRouteFile('api/consultar_consumo_onu');
$this->loadRouteFile('api/consultar_sinal_onu');
$this->loadRouteFile('api/consultar_temperatura_onu');
$this->loadRouteFile('api/consultar_status_internet');
$this->loadRouteFile('api/consultar_ultima_ocorrencia');

// http://201.87.240.202:8000/admin/servicos/internet/38288/radiuslog/
// http://201.87.240.202:8000/admin/servicos/internet/38288/radius/sessions/
// http://201.87.240.202:8000/admin/servicos/internet/38288/disconnect/
// http://201.87.240.202:8000/admin/servicos/internet/38288/disconnect/?session_only=true
// http://201.87.240.202:8000/admin/servicos/internet/38288/ping/?count=&size=
// http://201.87.240.202:8000/admin/network/onu/18658/reset/