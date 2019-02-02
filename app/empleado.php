<?php

require './modules/rrhh/controllers/EmpleadoController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo EmpleadoController::create();
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo EmpleadoController::getdAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo EmpleadoController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo EmpleadoController::delete($_GET['id']);
            }
            break;

          default :
            {
              if (Session::getInstance()->user)
                echo EmpleadoController::create();
            }
            break;
        }
      } else {
        if (Session::getInstance()->user)
          echo EmpleadoController::create();
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'id' => $_POST['id'],
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'ci' => $_POST['ci'],
        'genero' => $_POST['genero'],
        'cargo' => $_POST['cargo'],
        'telefono' => $_POST['telefono'],
        'id_usuario' => $_POST['id_usuario']
      ];

      if (Session::getInstance()->user)
        echo EmpleadoController::save($data);
    }
    break;
}