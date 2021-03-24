<?php

$this->post('api/v1/consultar_cliente', function () {
  (string)$busca = '';
  extract($_POST);
  if($busca) {
    $this->core->loadModule('template')->render('consultar_cliente', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_cliente', function () {
  $this->core->loadModule('template')->render('403');
});