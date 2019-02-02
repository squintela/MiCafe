<?php

require './modules/venta/controllers/FacturaController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo FacturaController::create($_GET['id_pedido']);
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo FacturaController::getdAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo FacturaController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo FacturaController::delete($_GET['id']);
            }
            break;
        }
      }
    }
    break;

  case 'POST':
    {
      $data = [
        'id' => $_POST['id'],
        'codigo' => $_POST['codigo'],
        'nit' => $_POST['nit'],
        'fecha' => $_POST['fecha'],
        'monto' => $_POST['monto'],
        'razon' => $_POST['razon'],
        'cliente' => $_POST['cliente'],
        'id_pedido' => $_POST['id_pedido']
      ];

      if (Session::getInstance()->user)
        echo FacturaController::save($data);
    }
    break;
}