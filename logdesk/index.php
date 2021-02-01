<?php
session_start();
require 'config.php';
require 'functions.php';

spl_autoload_register(function ($class) {
  if (file_exists('modules/' . $class . '/' . $class . '.php')) {
    require 'modules/' . $class . '/' . $class . '.php';
  }
  if (file_exists('modules/Site/Cadastros/' . $class . '/' . $class . '.php')) {
    require 'modules/Site/Cadastros/' . $class . '/' . $class . '.php';
  }
});

Core::getInstance()->run($config);