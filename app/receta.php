<?php

require './modules/inventario/controllers/RecetaController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo RecetaController::create();
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo RecetaController::getAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo RecetaController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo RecetaController::delete($_GET['id']);
            }
            break;
          default :
            {
              if (Session::getInstance()->user)
                echo RecetaController::create();
            }
            break;
        }
      } else {
        if (Session::getInstance()->user)
          echo RecetaController::create();
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'id' => $_POST['id'],
        'codigo' => $_POST['codigo'],
        'nombre' => $_POST['nombre'],
        'descripcion' => $_POST['descripcion']
      ];

      if (Session::getInstance()->user)
        echo RecetaController::save($data);
    }
    break;
}