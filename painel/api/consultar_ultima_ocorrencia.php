<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->consultarUltimaOcorrencia());