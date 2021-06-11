<?php

$this->get('surftelecom/regras_usuario', function () {
  $this->core->loadModule('template')->render('surftelecom/regras_usuario', $_GET);
});