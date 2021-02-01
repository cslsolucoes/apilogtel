<?php

class Router {

  private $core;
  private $get;
  private $post;

  private function __construct() {}

  public static function getInstance() {
    static $inst = null;
    if($inst === null) {
      $inst = new Router();
    }
    return $inst;
  }

  public function load() {
    $this->core = Core::getInstance();
    $this->loadRouteFile('default');
    return $this;
  }

  public function loadRouteFile($file) {
    if(file_exists('routes/' . $file . '.php')) {
      require 'routes/' . $file . '.php';
    }
  }

  public function match() {
    $url = (isset($_GET['url']) ? $_GET['url'] : '');
    switch($_SERVER['REQUEST_METHOD']) {
      case 'GET':
      default:
        $type = $this->get;
      break;
      case 'POST':
        $type = $this->post;
      break;
    }

    foreach($type as $pattern => $function) {
      $validPattern = preg_replace('(\{[a-z0-9]{0,}\})', '([a-z0-9]{0,})', $pattern);
      if(preg_match('#^(' . $validPattern . ')*$#i', $url, $matches) === 1) {
        array_shift($matches);
        array_shift($matches);

        $itens = array();
        if(preg_match_all('(\{[a-z0-9]{0,}\})', $pattern, $matchesAll)) {
          $itens = preg_replace('(\{|\})', '', $matchesAll[0]);
        }

        $args = array();
        foreach($matches as $key => $match) {
          $args[$itens[$key]] = $match;
        }
        
        $function($args);
        break;
      }
    }
  }

  public function get($pattern, $function) {
    $this->get[$pattern] = $function;
  }

  public function post($pattern, $function) {
    $this->post[$pattern] = $function;
  }
}