<?php

$this->post('api/v1/consultar_ultima_ocorrencia', function () {
  $this->core->loadModule('template')->render('403');
});

$this->get('api/v1/consultar_ultima_ocorrencia', function () {
  $this->core->loadModule('template')->render('consultar_ultima_ocorrencia');
});