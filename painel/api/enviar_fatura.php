<?php
  header('Content-Type: application/json');
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->enviarFatura($data[0]));