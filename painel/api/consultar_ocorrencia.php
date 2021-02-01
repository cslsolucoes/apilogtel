<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->consultarOcorrencia($data[0]));