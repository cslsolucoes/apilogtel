<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->verificaAcesso($data[0]));