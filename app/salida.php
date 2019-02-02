<?php

require './modules/inventario/controllers/SalidaController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo SalidaController::create();
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo SalidaController::getdAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo SalidaController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo SalidaController::delete($_GET['id']);
            }
            break;

          default :
            {
              if (Session::getInstance()->user)
                echo SalidaController::create();
            }
            break;
        }
      } else {
        if (Session::getInstance()->user)
          echo SalidaController::create();
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'id' => $_POST['id'],
        'codigo' => $_POST['codigo'],
        'fecha' => $_POST['fecha'],
        'id_empleado' => $_POST['id_empleado']
      ];

      if (Session::getInstance()->user)
        echo SalidaController::save($data);
    }
    break;
}