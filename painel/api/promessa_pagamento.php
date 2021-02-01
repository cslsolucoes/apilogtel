<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->promessaPagamento($data[0]));