<?php
$this->get('', function ($data) {
  if(not_logged_in()) {
    $this->core->loadModule('template')->render('login', $data);
    return;
  }
  $this->core->loadModule('template')->render($_SESSION['tecnico'] ? 'tecnico' : 'home', $data);
});

/* $this->get('{clientid}/{contratoid}', function ($data) {
  if(not_logged_in()) {
    $this->core->loadModule('template')->render('login', $data);
  } else {
    $this->core->loadModule('template')->render('home', $data);
  }
}); */

$this->get('login', function ($data) {
  $this->core->loadModule('template')->render('login', $data);
});

$this->post('login', function ($data) {
  extract($_POST);
  if(isset($login) && isset($password) && $password && $login && ldapLogin($login, $password)) {
    $un = explode('@', $login);
    session_destroy();
    session_start();
    $_SESSION['username'] = $un[0];
    $_SESSION['userid'] = getUserId($_SESSION['username']);
    $_SESSION['user'] = $login;
    $_SESSION['pass'] = $password;
    $_SESSION['tecnico'] = true;
    if(isSeller($_SESSION['username'])) {
      $_SESSION['tecnico'] = true;
    }
    header("Location: ./");
    //$this->core->loadModule('template')->render('tecnico', $data);
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
$this->loadRouteFile('cadastros/precadastro');

// Logtel Chip
$this->loadRouteFile('surftelecom/consultar_planos');
$this->loadRouteFile('surftelecom/consultar_clientes');
$this->loadRouteFile('surftelecom/consultar_subscricoes');
$this->loadRouteFile('surftelecom/consultar_usuarios');
$this->loadRouteFile('surftelecom/consultar_regras_usuario');
$this->loadRouteFile('surftelecom/consultar_operadoras_portabilidade');
$this->loadRouteFile('surftelecom/cadastrar_cliente');
$this->loadRouteFile('surftelecom/cadastrar_subscricao');

// API route files
$this->loadRouteFile('api/consultar_cliente');
$this->loadRouteFile('api/consultar_cliente_ativo');
$this->loadRouteFile('api/consultar_ocorrencias');
$this->loadRouteFile('api/consultar_onu_uid');
$this->loadRouteFile('api/consultar_consumo_onu');
$this->loadRouteFile('api/consultar_sinal_onu');
$this->loadRouteFile('api/consultar_temperatura_onu');
$this->loadRouteFile('api/consultar_status_internet');
$this->loadRouteFile('api/consultar_ultima_ocorrencia');
$this->loadRouteFile('api/consultar_ocorrencia');
$this->loadRouteFile('api/consultar_faturas');
$this->loadRouteFile('api/cadastrar_venda');
$this->loadRouteFile('api/criar_ocorrencia');
$this->loadRouteFile('api/enviar_fatura');
$this->loadRouteFile('api/promessa_pagamento');
$this->loadRouteFile('api/verificamanutencao');
$this->loadRouteFile('api/testar_mumo');
$this->loadRouteFile('api/consultar_fabricante_mac');

// Log de conexão
// http://201.87.240.202:8000/admin/servicos/internet/38288/radiuslog/

// Sessão RADIUS
// http://201.87.240.202:8000/admin/servicos/internet/38288/radius/sessions/

// Encerrar sessão
// http://201.87.240.202:8000/admin/servicos/internet/38288/disconnect/

// Desconectar sessão
// http://201.87.240.202:8000/admin/servicos/internet/38288/disconnect/?session_only=true

// Testar ping
// http://201.87.240.202:8000/admin/servicos/internet/38288/ping/?count=&size=

// Reiniciar ONU
// http://201.87.240.202:8000/admin/network/onu/18658/reset/

// Ver histórico de status dos contratos
// http://201.87.240.202:8000/admin/contrato/75530/status/list/