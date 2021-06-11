<?php

$this->get('surftelecom/subscricoes', function ($data) {
  $this->core->loadModule('template')->render('surftelecom/subscricoes', $data);
});

$this->get('surftelecom/api/v1/consultar_subscricoes', function () {
  if(isset($_GET['document']) && $_GET['document'] && is_numeric($_GET['document'])) {
    $this->core->loadModule('template')->render('surftelecom/consultar_subscricoes', $_GET);
  }
});