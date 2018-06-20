<?php
namespace Logikos\Slim\Module\User;

use Logikos\Slim\AppInterface as App;

class Module {
  /** @var  App */
  protected $app;

  public function defineRoutes(App $app, $group = null) {
    $this->app = $app;
    if (is_null($group)) $this->routes();
    else $this->defineRoutesInGroup($group);
  }

  private function defineRoutesInGroup($group) {
    $module = $this;
    $this->app->group($group, function() use($app, $module) {
      $module->routes();
    });
  }

  private function routes() {
    $module = $this;
    $this->app->group('/user-manager', function() use($module) {
      $module->app->get("/version", function() use($module) {
        echo $module->version();
      })->setName('userman-version');
    });
  }

  public function version() {
    return '0.0.1';
  }
}