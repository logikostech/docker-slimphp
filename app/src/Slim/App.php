<?php

namespace Logikos\Slim;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;
use Slim\Interfaces\RouteGroupInterface;
use Slim\Interfaces\RouteInterface;
use Slim\UriInterface;


/**
 * App
 *
 * This is the primary class with which you instantiate,
 * configure, and run a Slim Framework application.
 * The \Slim\App class also accepts Slim Framework middleware.
 *
 * @property-read callable $errorHandler
 * @property-read callable $phpErrorHandler
 * @property-read callable $notFoundHandler   function($request, $response)
 * @property-read callable $notAllowedHandler function($request, $response, $allowedHttpMethods)
 */
interface App {
  /**
   * Enable access to the DI container by consumers of $app
   *
   * @return ContainerInterface
   */
  public function getContainer();

  /**
   * Add middleware
   *
   * This method prepends new middleware to the app's middleware stack.
   *
   * @param  callable|string $callable The callback routine
   *
   * @return static
   */
  public function add($callable);

  /**
   * Add GET route
   *
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return \Slim\Interfaces\RouteInterface
   */
  public function get($pattern, $callable);

  /**
   * Add POST route
   *
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return \Slim\Interfaces\RouteInterface
   */
  public function post($pattern, $callable);

  /**
   * Add PUT route
   *
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return \Slim\Interfaces\RouteInterface
   */
  public function put($pattern, $callable);

  /**
   * Add PATCH route
   *
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return \Slim\Interfaces\RouteInterface
   */
  public function patch($pattern, $callable);

  /**
   * Add DELETE route
   *
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return \Slim\Interfaces\RouteInterface
   */
  public function delete($pattern, $callable);

  /**
   * Add OPTIONS route
   *
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return \Slim\Interfaces\RouteInterface
   */
  public function options($pattern, $callable);

  /**
   * Add route for any HTTP method
   *
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return \Slim\Interfaces\RouteInterface
   */
  public function any($pattern, $callable);

  /**
   * Add route with multiple methods
   *
   * @param  string[]        $methods  Numeric array of HTTP method names
   * @param  string          $pattern  The route URI pattern
   * @param  callable|string $callable The route callback routine
   *
   * @return RouteInterface
   */
  public function map(array $methods, $pattern, $callable);

  /**
   * Add a route that sends an HTTP redirect
   *
   * @param string              $from
   * @param string|UriInterface $to
   * @param int                 $status
   *
   * @return RouteInterface
   */
  public function redirect($from, $to, $status = 302);

  /**
   * Route Groups
   *
   * This method accepts a route pattern and a callback. All route
   * declarations in the callback will be prepended by the group(s)
   * that it is in.
   *
   * @param string   $pattern
   * @param callable $callable
   *
   * @return RouteGroupInterface
   */
  public function group($pattern, $callable);

  /**
   * Run application
   *
   * This method traverses the application middleware stack and then sends the
   * resultant Response object to the HTTP client.
   *
   * @param bool|false $silent
   * @return ResponseInterface
   *
   * @throws Exception
   * @throws MethodNotAllowedException
   * @throws NotFoundException
   */
  public function run($silent = false);

  /**
   * Process a request
   *
   * This method traverses the application middleware stack and then returns the
   * resultant Response object.
   *
   * @param ServerRequestInterface $request
   * @param ResponseInterface      $response
   * @return ResponseInterface
   *
   * @throws Exception
   * @throws MethodNotAllowedException
   * @throws NotFoundException
   */
  public function process(ServerRequestInterface $request, ResponseInterface $response);

  /**
   * Send the response to the client
   *
   * @param ResponseInterface $response
   */
  public function respond(ResponseInterface $response);

  /**
   * Perform a sub-request from within an application route
   *
   * This method allows you to prepare and initiate a sub-request, run within
   * the context of the current request. This WILL NOT issue a remote HTTP
   * request. Instead, it will route the provided URL, method, headers,
   * cookies, body, and server variables against the set of registered
   * application routes. The result response object is returned.
   *
   * @param  string            $method      The request method (e.g., GET, POST, PUT, etc.)
   * @param  string            $path        The request URI path
   * @param  string            $query       The request URI query string
   * @param  array             $headers     The request headers (key-value array)
   * @param  array             $cookies     The request cookies (key-value array)
   * @param  string            $bodyContent The request body
   * @param  ResponseInterface $response    The response object (optional)
   * @return ResponseInterface
   */
  public function subRequest(
      $method,
      $path,
      $query = '',
      array $headers = [],
      array $cookies = [],
      $bodyContent = '',
      ResponseInterface $response = null
  );
}