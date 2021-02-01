<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require 'config.php';
//require 'functions.php';

spl_autoload_register(function ($class) {
  if (file_exists('modules/' . $class . '/' . $class . '.php')) {
    require 'modules/' . $class . '/' . $class . '.php';
  }
});

Core::getInstance()->run($config);

/*
API Unvoip
Site do Unvoip
API multiempresa
Site de venda automática Falepaco
*/