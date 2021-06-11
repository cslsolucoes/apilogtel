<?php

$this->get('surftelecom/usuarios', function () {
  $this->core->loadModule('template')->render('surftelecom/usuarios', $_GET);

});

$this->get('surftelecom/api/v1/consultar_usuarios', function () {
  $this->core->loadModule('template')->render('surftelecom/consultar_usuarios', $_GET);
});