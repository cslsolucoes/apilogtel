<?php
  header('Content-Type: application/json');
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo $api->consultarFabricanteMac($data[0]);