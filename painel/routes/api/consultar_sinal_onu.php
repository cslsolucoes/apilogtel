<?php

$this->post('api/v1/consultar_sinal_onu', function () {
  (string)$ip = '';
  (string)$uid = '';
  extract($_POST);
  if($ip && $uid) {
    $this->core->loadModule('template')->render('consultar_sinal_onu', $ip, $uid);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_sinal_onu', function () {
  $this->core->loadModule('template')->render('403');
});