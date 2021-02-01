<?php

$this->post('api/v1/consultar_temperatura_onu', function () {
  (string)$ip = '';
  (string)$uid = '';
  extract($_POST);
  if($ip && $uid) {
    $this->core->loadModule('template')->render('consultar_temperatura_onu', $ip, $uid);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_ocorrencias', function () {
  $this->core->loadModule('template')->render('403');
});