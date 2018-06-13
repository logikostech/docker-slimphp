<?php

if (isset($_GET['debug'])) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

$composerAutoloader = __DIR__.'/../vendor/autoload.php';
if (!file_exists($composerAutoloader)) {
  http_response_code(500);
  die('Please run `composer update` first');
}

require_once $composerAutoloader;

phpinfo();
