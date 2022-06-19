<?php
/* 
* App Core Class
* Creates URL & Loads Core Controller
* URL Format - /controller/method/params
*/

class Core {
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct() {
    // print_r($this->getUrl());

    $url = $this->getUrl();

    // Look in controller for first value
    if (file_exists('../app/controllers/' . $url[0]. '.php')) {
      // If exists, set as controller
      $this->currentController = ucwords($url[0]);
      // Unset zero index
      unset($url[0]);
    }

    // Require the controller
    require_once '../app/controllers/'. $this->currentController . '.php';

    // Instantiate controller
    $this->currentController = new $this->currentController;

    // Check for second part of URL and method in controller
    if (isset($url[1])) {
      if (method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
          // Unset one index
        unset($url[1]);
      }
    }

    // Get params
    $this->params = $url ? array_values($url) : [];

    // Callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getUrl() {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
    return ['pages'];
  }
}