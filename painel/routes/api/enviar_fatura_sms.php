<?php

$this->post('api/v1/enviar_fatura', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('enviar_fatura', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/enviar_fatura', function () {
  $this->core->loadModule('template')->render('403');
});