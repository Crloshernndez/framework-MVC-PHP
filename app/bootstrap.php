<?php
  // load Config
  require_once 'config/config.php';

  // load Libraries
  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  });

  //require_once 'libraries/Controller.php';
  //require_once 'libraries/Core.php';
  //require_once 'libraries/Database.php';

