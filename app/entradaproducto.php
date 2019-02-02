<?php

require './modules/inventario/controllers/EntradaProductoController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo EntradaProductoController::create($_GET['codigo']);
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo EntradaProductoController::getdAll($_GET['codigo']);
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
        'observacion' => $_POST['observacion'],
        'id_entrada' => $_POST['id_entrada'],
        'id_producto' => $_POST['id_producto']
      ];

      if (Session::getInstance()->user)
        echo EntradaProductoController::save($data);
    }
    break;
}
