<?php


namespace Logikos\Slim;


interface Module {
  public function defineRoutes(App $app);
}