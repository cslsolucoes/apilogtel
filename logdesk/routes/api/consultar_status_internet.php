<?php

$this->post('api/v1/consultar_status_internet', function () {
  (string)$id = '';
  extract($_POST);
  if($id) {
    $this->core->loadModule('template')->render('consultar_status_internet', $id);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});

$this->get('api/v1/consultar_status_internet', function () {
  $this->core->loadModule('template')->render('403');
});