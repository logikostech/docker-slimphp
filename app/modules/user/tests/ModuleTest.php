<?php
namespace LogikosTest\Slim\Module\User;

use Exception;
use InvalidArgumentException;
use Logikos\Slim\App;
use Logikos\Slim\AppInterface;
use Logikos\Slim\Module\User\Module;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;
use Slim\Interfaces\RouteInterface;
use Slim\Route;
use Slim\UriInterface;

class ModuleTest extends TestCase {
  public function testDefineRoutes() {
    $mod = new Module();
  }

  private function appSpy() {
    $app = new class implements AppInterface {
      /** @var  RouteInterface */
      public $routeInterface;

      public $groupPattern;
      public $routes = [];

      public function group  ($pattern, $callable) {
        $this->_appendRoute($pattern);
        $this->groupPattern = $pattern;
      }
      public function get    ($pattern, $callable) { return $this->map(['get'],    $pattern, $callable); }
      public function post   ($pattern, $callable) { return $this->map(['post'],   $pattern, $callable); }
      public function put    ($pattern, $callable) { return $this->map(['put'],    $pattern, $callable); }
      public function patch  ($pattern, $callable) { return $this->map(['patch'],  $pattern, $callable); }
      public function delete ($pattern, $callable) { return $this->map(['delete'], $pattern, $callable); }

      public function map(array $methods, $pattern, $callable) {
        $this->_appendRoute($pattern);
        return $this->routeInterface;
      }

      private function _appendRoute($pattern) { array_push($this->routes, $pattern); }

      public function getContainer() {}
      public function add($callable) {}
      public function options($pattern, $callable) {}
      public function any($pattern, $callable) {}
      public function redirect($from, $to, $status = 302) {}
      public function run($silent = false) {}
      public function process(ServerRequestInterface $request, ResponseInterface $response) {}
      public function respond(ResponseInterface $response) {}
      public function subRequest(
          $method, $path, $query = '', array $headers = [],
          array $cookies = [], $bodyContent = '',
          ResponseInterface $response = null
      ) {}
    };
    $app->routeInterface = $this->mockRouteInterface();
    return $app;
  }

  private function mockRouteInterface() {
    return new class implements RouteInterface {
      public function getArgument($name, $default = null) {}
      public function getArguments() {}
      public function getName() {}
      public function getPattern() {}
      public function setArgument($name, $value) {}
      public function setArguments(array $arguments) {}
      public function setOutputBuffering($mode) {}
      public function setName($name) {}
      public function add($callable) {}
      public function prepare(ServerRequestInterface $request, array $arguments) {}
      public function run(ServerRequestInterface $request, ResponseInterface $response) {}
      public function __invoke(ServerRequestInterface $request, ResponseInterface $response) {}
    };
  }
}