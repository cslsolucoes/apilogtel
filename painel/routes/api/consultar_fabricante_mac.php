<?php
  $this->get('api/v1/consultar_fabricante_mac', function () {
  $this->core->loadModule('template')->render('consultar_fabricante_mac', $_GET['mac']);
});