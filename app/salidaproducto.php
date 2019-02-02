<?php

require './modules/inventario/controllers/SalidaProductoController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo SalidaProductoController::create($_GET['codigo']);
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo SalidaProductoController::getdAll($_GET['codigo']);
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
        'id_salida' => $_POST['id_salida'],
        'id_producto' => $_POST['id_producto']
      ];

      if (Session::getInstance()->user)
        echo SalidaProductoController::save($data);
    }
    break;
}
