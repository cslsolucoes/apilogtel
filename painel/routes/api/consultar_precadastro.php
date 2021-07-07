<?php
$this->get('consultar_precadastro', function () {
  $this->core->loadModule('template')->render('consultar_precadastro');
});

$this->post('consultar_precadastro', function ($data) {
  $this->core->loadModule('template')->render('consultar_precadastro', $data);
});