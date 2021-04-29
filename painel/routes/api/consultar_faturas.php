<?php

$this->post('api/v1/consultar_faturas', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('consultar_faturas', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_faturas', function () {
  $this->core->loadModule('template')->render('403');
});