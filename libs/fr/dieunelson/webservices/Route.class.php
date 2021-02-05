<?php

namespace fr\dieunelson\webservices;

use Exception;

class Route{
  
  private static $instance;
  private $routes;

  private function __construct()
  {
    $this->routes = [
      "GET" => [],
      "POST" => [],
      "PUT" => [],
      "DELETE" => []
    ];
  }

  public static function getInstance() : Route
  {
    if(empty(Route::$instance)){
      Route::$instance = new Route();
    }
    return Route::$instance;
  }

  public static function get($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("GET", $path, $callback, $validator);
  }

  public static function post($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("POST", $path, $callback, $validator);
  }

  public static function put($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("PUT", $path, $callback, $validator);
  }

  public static function delete($path, $callback, RequestValidator $validator = null)
  {
    Route::getInstance()->addRoute("DELETE", $path, $callback, $validator);
  }

  public function resolve($protocole, $path)
  {

    $find = false;
    $route = null;
    foreach ($this->routes[$protocole] as $key => $value) {
      if (preg_match($value["pattern"], $path)) {
        $route = $value;
        $find = true;
        break;
      }
    }

    if (array_key_exists($protocole, $this->routes) && $find)
    {
      $path_tab = explode("/", $path);
      $variables = [];

      foreach ($route["variables"] as $variable) {
        $variables[$variable["name"]] = $path_tab[$variable["index"]];
      }

      return [
        "variables" => $variables,
        "callback" => $route["callback"],
        "validator" => $route["validator"]
      ];
    }
    throw new Exception("Route [$protocole] $path not exists", 404);
  }

  public function addRoute($protocole, $path, $callback, RequestValidator $validator = null)
  {
    if (array_key_exists($protocole, $this->routes))
    {      
      $path_tab = explode("/", $path);

      $pattern_tab = [];
      $variables = [];
      foreach ($path_tab as $index => $section) {
        if (strpos($section, ":")===0) {
          $variables[] = [
            "name" => substr($section, 1),
            "index" => $index
          ];
          $pattern_tab[] = "([A-Za-z0-9][A-Za-z0-9]*)";
        }else{          
          $pattern_tab[] = $section;
        }
      }

      $this->routes[$protocole][$path] = [
        "pattern" => "/^".implode("\/", $pattern_tab)."$/",
        "variables" => $variables,
        "callback" => $callback,
        "validator" => $validator
      ];
    }else{
      throw new Exception("Protocole $protocole not exists",500);
    }
    
  }



}