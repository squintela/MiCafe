<?php

require './modules/venta/controllers/ClienteController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo ClienteController::create();
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo ClienteController::getdAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo ClienteController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo ClienteController::delete($_GET['id']);
            }
            break;

          default :
            {
              if (Session::getInstance()->user)
                echo ClienteController::create();
            }
            break;
        }
      } else {
        if (Session::getInstance()->user)
          echo ClienteController::create();
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'id' => $_POST['id'],
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'celular' => $_POST['celular'],
        'nit' => $_POST['nit']
      ];

      if (Session::getInstance()->user)
        echo ClienteController::save($data);
    }
    break;
}