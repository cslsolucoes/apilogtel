<?php

$this->post('api/v1/verificamanutencao', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('verificamanutencao', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/verificamanutencao', function () {
  $this->core->loadModule('template')->render('403');
});