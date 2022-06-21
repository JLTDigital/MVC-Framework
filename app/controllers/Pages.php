<?php

class Pages extends Controller {
  public function __construct() {
   
  }

  public function index() {
    $data = [
      'title' => 'PHP MVC Framework',
    ];

    $this->view('pages/index', $data);
  }

  public function about() {
    $data = [
      'title' => 'About - PHP MVC Framework'
    ];
    $this->view('pages/about', $data);
  }
}