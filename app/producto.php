<?php

require './modules/inventario/controllers/ProductoController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo ProductoController::create();
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo ProductoController::getdAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo ProductoController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo ProductoController::delete($_GET['id']);
            }
            break;

          default :
            {
              if (Session::getInstance()->user)
                echo ProductoController::create();
            }
            break;
        }
      } else {
        if (Session::getInstance()->user)
          echo ProductoController::create();
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'id' => $_POST['id'],
        'codigo' => $_POST['codigo'],
        'nombre' => $_POST['nombre'],
        'marca' => $_POST['marca'],
        'unidad' => $_POST['unidad'],
        'tipo' => $_POST['tipo'],
        'precio' => $_POST['precio'],
        'volumen' => $_POST['volumen']
      ];

      if (Session::getInstance()->user)
        echo ProductoController::save($data);
    }
    break;
}