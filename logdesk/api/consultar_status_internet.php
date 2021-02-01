<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  $userid = $api->getUserIDBySession($_SESSION['user']);
  echo json_encode($api->getInternetStatus($data[0], array('username' => $_SESSION['user'], 'password' => $_SESSION['pass'])));
  