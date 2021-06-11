<?php

$this->get('surftelecom/cadastro_cliente', function () {
  $this->core->loadModule('template')->render('surftelecom/cadastro_cliente');
});

$this->post('surftelecom/api/v1/cadastrar_cliente', function () {
  $this->core->loadModule('template')->render('surftelecom/cadastrar_cliente', $_POST);
});