<?php
$this->get('consultar_precadastro', function () {
  $this->core->loadModule('template')->render('consultar_precadastro');
});