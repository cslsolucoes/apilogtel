<?php
  header('Content-Type: application/json');
  $core = Core::getInstance();
  $api = $core->loadModule('api');
  if(!isset($_SESSION['user']) || !isset($_SESSION['pass']) || !$_SESSION['user'] || !$_SESSION['pass']) {
    if(isset($uri) && $uri) {
      header("Location: " . $uri . "logout");
    }
    die('invalid session');
  }
  $userid = $api->getUserIDBySession($_SESSION['user']);
  echo json_encode($api->getInternetStatus($data[0], array('username' => $_SESSION['user'], 'password' => $_SESSION['pass'])));
  