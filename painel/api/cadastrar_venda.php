<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->cadastrarVenda($data[0]));