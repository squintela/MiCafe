<?php

require './modules/venta/controllers/OrdenController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user || Session::getInstance()->cliente)
                echo OrdenController::create($_GET['codigo']);
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user || Session::getInstance()->cliente)
                echo OrdenController::getAll($_GET['codigo']);
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user || Session::getInstance()->cliente)
                echo OrdenController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user || Session::getInstance()->cliente)
                echo OrdenController::delete($_GET['id']);
            }
            break;
        }
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'cantidad' => $_POST['cantidad'],
        'precio' => $_POST['precio'],
        'id_pedido' => $_POST['id_pedido'],
        'id_producto' => $_POST['id_producto']
      ];

      if (Session::getInstance()->user || Session::getInstance()->cliente)
        echo OrdenController::save($data);
    }
    break;
}