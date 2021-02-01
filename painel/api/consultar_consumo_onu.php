<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->getTxRxBandwidth($data[0], array('username' => $_SESSION['user'], 'password' => $_SESSION['pass'])));