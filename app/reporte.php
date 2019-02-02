<?php

require './modules/reporte/controllers/ReporteController.php';
require_once './security/Session.php';

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    {
      if (isset($_GET['option'])) {
        switch ($_GET['option']) {
          case 'pedido' :
            {
              switch ($_GET['list']) {
                case 'all':
                  {
                    if (Session::getInstance()->user)
                      echo ReporteController::listaPedidos();
                  } break;
                case 'dia':
                  {
                    if (isset($_GET['dia'])) {
                      if (Session::getInstance()->user)
                        echo  ReporteController::utilidadesDayProcess($_GET['dia']);
                    } else {
                      if (Session::getInstance()->user)
                        echo ReporteController::utilidadesDay();
                    }
                  } break;
                case 'mes': {
                  if (isset($_GET['mes'])) {
                    if (Session::getInstance()->user)
                      echo ReporteController::utilidadesMonthProcess($_GET['mes']);
                  } else {
                    if (Session::getInstance()->user)
                      echo ReporteController::utilidadesMonth();
                  }
                } break;
              }
            } break;
          case 'entrada':
            {
              switch ($_GET['list']) {
                case 'dia':
                  {
                    if (isset($_GET['dia'])) {
                      if (Session::getInstance()->user)
                        echo  ReporteController::entradasDayProcess($_GET['dia']);
                    } else {
                      if (Session::getInstance()->user)
                        echo ReporteController::entradasDay();
                    }
                  } break;
                case 'mes': {
                  if (isset($_GET['mes'])) {
                    if (Session::getInstance()->user)
                      echo ReporteController::entradasMonthProcess($_GET['mes']);
                  } else {
                    if (Session::getInstance()->user)
                      echo ReporteController::entradasMonth();
                  }
                } break;
              }
            } break;
        }
      }
    }
    break;
}