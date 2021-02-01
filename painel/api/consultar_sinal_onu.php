<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->getOnuTxSignal($data[0], $data[1]));