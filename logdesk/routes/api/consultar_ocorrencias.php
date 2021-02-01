<?php

$this->post('api/v1/consultar_ocorrencias', function () {
  (string)$contrato = '';
  extract($_POST);
  if($contrato) {
    $this->core->loadModule('template')->render('consultar_ocorrencias', $contrato);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_ocorrencias', function () {
  $this->core->loadModule('template')->render('403');
});