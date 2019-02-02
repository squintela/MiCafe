<?php

require_once './modules/inventario/models/Stock.php';
require_once './render/Render.php';

class StockController
{
  public static function getdAll() {
    $stocks = Stock::getAll();
    return Render::to_response("@inventario/stock-list.twig", ['stocks'=> $stocks]);
  }
}