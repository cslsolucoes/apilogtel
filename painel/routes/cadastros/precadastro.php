<?php
$this->get('precadastro', function () {
  $this->core->loadModule('template')->render('precadastro');
});

$this->post('precadastro', function () {
  if($_POST) {
    $this->core->loadModule('template')->render('precadastro', $_POST);
  } else {
    $this->core->loadModule('template')->render('404');
  }
});