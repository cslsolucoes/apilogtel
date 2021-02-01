<?php

$this->post('api/v1/cadastrar_venda', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('cadastrar_venda', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/cadastrar_venda', function () {
  $this->core->loadModule('template')->render('403');
});