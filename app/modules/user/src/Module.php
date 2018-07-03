<?php
namespace Logikos\Slim\Module\User;

use Logikos\Slim\App as App;
use Logikos\Util\Config\MutableConfig;
use Slim\Http\Request;
use Slim\Http\Response;

class Module implements \Logikos\Slim\Module {
  /** @var  App */
  protected $app;

  public function version() {
    return '0.0.3';
  }

  private function config() {
    return [
        ['pattern'=>'/version']
    ];
  }

  public function defineRoutes(App $app) {
    $this->app = $app;
    $module = $this;
    $app->group('/user-manager', function() use($module) {
      $module->versionRoute($module);
      $module->addUserRoute($module);
    });
  }

  private function versionRoute(Module $module) {
    $module->app->get("/version", function() use($module) {
      echo $module->version();
    })->setName('userman-version');
  }

  private function addUserRoute(Module $module) {
    $module->app->get("/users", function(Request $request, Response $response) use ($module) {
      $c = new MutableConfig();
      $c->name = 'John';
      $c->age = 23;
      return $response->withJson($c->toArray());

    })->setName('userman-create');
  }

}