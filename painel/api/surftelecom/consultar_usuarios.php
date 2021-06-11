<?php
  header('Content-Type: application/json');
  $core = Core::getInstance();
  $api = $core->loadModule('surftelecom');
  $data[0]['role'] = $data[0]['role'] ?? NULL;
  $data[0]['regionalId'] = $data[0]['regionalId'] ?? NULL;
  echo json_encode($api->consultarUsuarios($data[0]['role'], $data['regionalId']));