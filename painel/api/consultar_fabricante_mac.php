<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  echo $api->consultarFabricanteMac($data[0]);