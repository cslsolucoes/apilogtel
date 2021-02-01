<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo json_encode($api->getOnuUniqueId($data[0], $data[1]));