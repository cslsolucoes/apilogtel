<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->verificamanutencao($data[0]));