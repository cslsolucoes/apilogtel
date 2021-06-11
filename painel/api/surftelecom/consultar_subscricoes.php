<?php
  header('Content-Type: application/json');
  $core = Core::getInstance();
  $api = $core->loadModule('surftelecom');
  echo json_encode($api->consultarSubscricoes($data[0]['document']));