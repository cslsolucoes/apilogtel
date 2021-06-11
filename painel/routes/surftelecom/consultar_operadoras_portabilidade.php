<?php

$this->get('surftelecom/operadoras_portabilidade', function () {
  $this->core->loadModule('template')->render('surftelecom/operadoras_portabilidade', $_GET);
});