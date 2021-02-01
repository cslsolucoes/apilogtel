<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
require 'config.php';
require 'functions.php';

$_SESSION['token'] = $_POST['token'] ?? false;

spl_autoload_register(function ($class) {
  if (file_exists('modules/' . $class . '/' . $class . '.php')) {
    require 'modules/' . $class . '/' . $class . '.php';
  }
  if (file_exists('modules/Site/Cadastros/' . $class . '/' . $class . '.php')) {
    require 'modules/Site/Cadastros/' . $class . '/' . $class . '.php';
  }
});

Core::getInstance()->run($config);