<?php

require './modules/inventario/controllers/StockController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (Session::getInstance()->user)
        echo StockController::getdAll();
    }
    break;

  default : {
    if (Session::getInstance()->user)
      echo StockController::getdAll();
  }
}