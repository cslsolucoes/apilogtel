<?php
  $core = Core::getInstance();
  $uri = $core->getConfig('httpHost') . '/' . $core->getConfig('sitePath');
  $assets = $uri . $core->getConfig('assetsFolder');
  $curl = $core->loadModule('curl');
  $call = $curl->sendRequest();
  echo $_SERVER['REQUEST_URI'];
  echo $call;
?>
