<?php
class Template {
  private function __construct() {}

  public static function getInstance() {
    static $inst = null;
    if($inst === null) {
      $inst = new Template();
    }
    return $inst;
  }

  public function render($template, ...$data) {
    if(file_exists('api/' . $template . '.php')) {
      require 'api/' . $template . '.php';
      return $data;
    }
    if(isset($_SESSION['user']) && $_SESSION['user']) {
      if(file_exists('templates/' . $template . '.php')) {
        require 'templates/' . $template . '.php';
      } else {
        echo json_encode(array('msg' => '404', 'path' => 'templates/' . $template . '.php'));
      }
    } else {
      require 'templates/login.php';
    }
  }
}