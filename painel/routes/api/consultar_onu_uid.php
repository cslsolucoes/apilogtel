<?php

$this->post('api/v1/consultar_onu_uid', function () {
  (string)$ip = '';
  (string)$pa = '';
  extract($_POST);
  if($ip && $pa) {
    $this->core->loadModule('template')->render('consultar_onu_uid', $ip, $pa);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_ocorrencias', function () {
  $this->core->loadModule('template')->render('403');
});