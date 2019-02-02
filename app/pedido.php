<?php

require './modules/venta/controllers/PedidoController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo PedidoController::create();
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo PedidoController::getAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo PedidoController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo PedidoController::delete($_GET['id']);
            }
            break;

          default :
            {
              if (Session::getInstance()->user)
                echo PedidoController::create();
            }
            break;
        }
      } else {
        if (Session::getInstance()->user)
          echo PedidoController::create();
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'id' => $_POST['id'],
        'codigo' => $_POST['codigo'],
        'fecha' => $_POST['fecha'],
        'monto' => $_POST['monto'],
        'tipo_pago' => $_POST['tipo_pago'],
        'id_empleado' => $_POST['id_empleado'],
        'id_cliente' => $_POST['id_cliente'],
        'estado' => $_POST['estado']
      ];

      if (Session::getInstance()->user)
        echo PedidoController::save($data);
    }
    break;
}