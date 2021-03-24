<?php
$config = array(
  'httpHost' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]",
  // DEVELOPMENT
  'sitePath' => 'painel/',
  // PRODUCTION
  //'sitePath' => 'logdesk/',
  'assetsFolder' => 'assets',
  'db' => array(
    'host' => '201.87.240.202',
    'port' => 5432,
    'user' => 'postgres',
    'pass' => 'postmy',
    'dbname' => 'dbsgp'
  ),
  'dbToken' => array(
    'host' => '201.87.240.2',
    'port' => 5432,
    'user' => 'postgres',
    'pass' => '1q2w3e4r5T@',
    'dbname' => 'logtel'
  )
);
