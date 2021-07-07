<?php
$this->get('consultar_ocorrencias_vendedores', function () {
  $this->core->loadModule('template')->render('consultar_ocorrencias_vendedores');
});

$this->post('consultar_ocorrencias_vendedores', function ($data) {
  $this->core->loadModule('template')->render('consultar_ocorrencias_vendedores', $data);
});