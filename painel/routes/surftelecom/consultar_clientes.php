<?php

$this->get('surftelecom/clientes', function ($data) {
  $this->core->loadModule('template')->render('surftelecom/clientes', $data);
});

$this->get('surftelecom/api/v1/consultar_clientes', function () {
  if(isset($_GET['document']) && $_GET['document'] && is_numeric($_GET['document'])) {
    $this->core->loadModule('template')->render('surftelecom/consultar_clientes', $_GET);
  }
});