<?php
  header('Content-Type: application/json');
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->consultarClienteAtivo($data[0]));