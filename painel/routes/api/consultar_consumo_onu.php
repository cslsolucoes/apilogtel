<?php

$this->post('api/v1/consultar_consumo_onu', function () {
  (string)$id = '';
  extract($_POST);
  if($id) {
    $this->core->loadModule('template')->render('consultar_consumo_onu', $id);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_consumo_onu', function () {
  $this->core->loadModule('template')->render('403');
});