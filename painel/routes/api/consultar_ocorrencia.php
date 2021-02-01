<?php

$this->get('api/v1/consultar_ocorrencia', function () {
  (string)$numero = '';
  extract($_GET);
  if($numero) {
    $this->core->loadModule('template')->render('consultar_ocorrencia', $numero);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->post('api/v1/consultar_ocorrencia', function () {
  $this->core->loadModule('template')->render('403');
});