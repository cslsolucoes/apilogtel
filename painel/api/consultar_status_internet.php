<?php
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  if(!isset($_SESSION['user']) || !isset($_SESSION['pass'])) {
    header("Location: " . $uri . "logout");
  }
  $userid = $api->getUserIDBySession($_SESSION['user']);
  echo json_encode($api->getInternetStatus($data[0], array('username' => $_SESSION['user'], 'password' => $_SESSION['pass'])));
  