<?php

$this->post('api/v1/verificaacesso', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('verificaacesso', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/verificaacesso', function () {
  $this->core->loadModule('template')->render('403');
});