<?php

require './modules/tpv/controllers/TPVController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'addpedido' :
            {
              if (Session::getInstance()->cliente)
                echo TPVController::createPedido($_GET['id_cliente']);
            }
            break;

          case 'listpedido' :
            {
              if (Session::getInstance()->cliente)
                echo TPVController::listPedido($_GET['id_cliente']);
            }
            break;

          case 'findpedido' :
            {
              if (Session::getInstance()->cliente)
                echo TPVController::getFindPedido($_GET['id']);
            }
            break;

          case 'addorden' :
            {
              if (Session::getInstance()->cliente)
                echo TPVController::createOrden($_GET['codigo']);
            }
            break;

          case 'listorden' :
            {
              if (Session::getInstance()->cliente)
                echo TPVController::listOrden($_GET['codigo']);
            }
            break;

          case 'logout' :
            {
              if (Session::getInstance()->cliente)
                echo TPVController::isLogOut();
            }
            break;

          default :
            {
              if (!Session::getInstance()->cliente)
                echo TPVController::login();
              else
                echo TPVController::createPedido(Session::getInstance()->cliente->getId());
            }
            break;
        }
      } else {
        if (!Session::getInstance()->cliente)
          echo TPVController::login();
        else
          echo TPVController::createPedido(Session::getInstance()->cliente->getId());
      }
    }
    break;

  case 'POST':
    {
      if (isset($_POST['celular']) && isset($_POST['nit'])) {
        $data = [
          'celular' => $_POST['celular'],
          'nit' => $_POST['nit']
        ];

        echo TPVController::isLogIn($data);

      } else {
        $data = [
          'id' => $_POST['id'],
          'codigo' => $_POST['codigo'],
          'fecha' => $_POST['fecha'],
          'monto' => $_POST['monto'],
          'tipo_pago' => $_POST['tipo_pago'],
          'id_cliente' => $_POST['id_cliente'],
          'estado' => $_POST['estado']
        ];

        if (Session::getInstance()->cliente)
          echo TPVController::savePedido($data);
      }
    }
    break;
}