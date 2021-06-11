<?php

$this->get('surftelecom/cadastro_subscricao', function () {
  $this->core->loadModule('template')->render('surftelecom/cadastro_subscricao');
});

$this->post('surftelecom/api/v1/cadastrar_subscricao', function () {
  $this->core->loadModule('template')->render('surftelecom/cadastrar_subscricao', $_POST);
});