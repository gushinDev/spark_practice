<?php

namespace app\Core;

class App
{
  public function __construct($url)
  {
    new Router($url);
  }

}