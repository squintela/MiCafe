<?php

require './modules/rrhh/controllers/UsuarioController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'add' :
            {
              if (Session::getInstance()->user)
                echo UsuarioController::create();
            }
            break;

          case 'list' :
            {
              if (Session::getInstance()->user)
                echo UsuarioController::getdAll();
            }
            break;

          case 'find' :
            {
              if (Session::getInstance()->user)
                echo UsuarioController::getFindById($_GET['id']);
            }
            break;

          case 'delete' :
            {
              if (Session::getInstance()->user)
                echo UsuarioController::delete($_GET['id']);
            }
            break;

          case 'logout' :
            {
              if (Session::getInstance()->user)
                echo UsuarioController::isLogOut();
            }
            break;

          default :
            {
              if (Session::getInstance()->user)
                echo UsuarioController::create();
            }
            break;
        }
      } else {
        if (Session::getInstance()->user)
          echo UsuarioController::create();
      }
    }
    break;

  case 'POST':
    {
      if (isset($_POST['email'])) {
        $data = [
          'id' => $_POST['id'],
          'username' => $_POST['username'],
          'password' => $_POST['password'],
          'email' => $_POST['email']
        ];

        if (Session::getInstance()->user)
          echo UsuarioController::save($data);

      } else {
        $data = [
          'username' => $_POST['username'],
          'password' => $_POST['password']
        ];
        echo UsuarioController::isLogIn($data);
      }
    }
    break;
}