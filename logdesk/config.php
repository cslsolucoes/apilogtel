<?php
$config = array(
  'httpHost' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]",
  // DEVELOPMENT
  // 'sitePath' => 'sistemalogtel/dist/',
  // PRODUCTION
  'sitePath' => 'logdesk/',
  'assetsFolder' => 'assets',
  'db' => array(
    'host' => '201.87.240.202',
    'port' => 5432,
    'user' => 'postgres',
    'pass' => 'postmy',
    'dbname' => 'dbsgp'
  )
);
