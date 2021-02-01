<?php

$this->post('api/v1/criar_ocorrencia', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('criar_ocorrencia', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/criar_ocorrencia', function () {
  $this->core->loadModule('template')->render('403');
});