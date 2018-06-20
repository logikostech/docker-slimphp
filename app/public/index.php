<?php

$configDir = realpath(__DIR__.'/../config');

lt_init_debug();
lt_ci_server_check();
lt_init_composer();
lt_dotenv($configDir);
$app = new \Slim\App();
lt_routes($app);
$userModule = new \Logikos\Slim\Module\User\Module();
$userModule->defineRoutes($app);
$app->run();

function lt_init_debug() {
  if (isset($_GET['debug'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  }
}

function lt_ci_server_check() {
  if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
      return false;
    }
  }
}

function lt_init_composer() {
  $composerAutoloader = __DIR__ . '/../vendor/autoload.php';

  if (!file_exists($composerAutoloader)) {
    http_response_code(500);
    die('Please run `composer update` first');
  }

  require_once $composerAutoloader;
}

function lt_dotenv($location) {
  $dotenv = new Dotenv\Dotenv($location);
  $dotenv->load();
}

function lt_routes(\Slim\App $app) {
  $app->get('/version', function(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args) {

    echo "1.0.0";
  })->setName('version');
}