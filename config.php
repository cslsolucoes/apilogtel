<?php
$config = array(
  'httpHost' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]",
  // DEVELOPMENT
  // 'sitePath' => 'sistemalogtel/dist/',
  // PRODUCTION
  'sitePath' => '/',
  'assetsFolder' => 'assets',
  'dbErp' => array(
    'host' => '201.87.240.202',
    'port' => 5432,
    'user' => 'postgres',
    'pass' => 'postmy',
    'dbname' => 'dbsgp'
  ),
  'dbLocal' => array(
    'host' => '201.87.240.2',
    'port' => 5432,
    'user' => 'postgres',
    'pass' => '1q2w3e4r5T@',
    'dbname' => 'logtel'
  ),
  'apiSGP' => array(
    'ip' => '201.87.240.202',
    'port' => '8000',
    'app' => 'ura',
    'token' => '7789c183-98c1-4667-b31f-b20931376f6f'
  )
);
