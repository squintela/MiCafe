<?php

require_once './modules/inventario/models/EntradaProducto.php';
require_once './modules/inventario/models/Entrada.php';
require_once './render/Render.php';

class EntradaProductoController
{
  public static function create($id) {
    $entrada = EntradaProducto::getEntradaCodigo($id);

    $context = [
      'entrada'=> $entrada,
      'productos' => EntradaProducto::getProductos($entrada->getId()),
      'entradaproductos' => EntradaProducto::getEntradaProductos($entrada->getId())
    ];

    return Render::to_response("@inventario/entradaproducto.twig", $context);
  }

  public static function save($data) {
    $entradaproducto = new EntradaProducto();
    $entradaproducto->setCantidad($data['cantidad']);
    $entradaproducto->setObservacion($data['observacion']);
    $entradaproducto->setIdEntrada($data['id_entrada']);
    $entradaproducto->setIdProducto($data['id_producto']);

    $status = $entradaproducto->save();

    return !$status ? "Error Transaccional" : "Procesado con exito";
  }

  public static function getdAll($id) {
    $entrada = EntradaProducto::getEntradaCodigo($id);
    $entradaproductos = EntradaProducto::getAll($entrada->getId());


    $context = [
      'entradaproductos'=> $entradaproductos,
      'entrada'=> $entrada
    ];
    return Render::to_response("@inventario/entradaproducto-list.twig", $context );
  }
}