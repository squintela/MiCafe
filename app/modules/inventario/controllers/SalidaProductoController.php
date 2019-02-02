<?php

require_once './modules/inventario/models/SalidaProducto.php';
require_once './render/Render.php';

class SalidaProductoController
{
  public static function create($id) {
    $salida = SalidaProducto::getSalidaCodigo($id);

    $context = [
      'salida'=> $salida,
      'productos' => SalidaProducto::getProductos($salida->getId()),
      'salidaproductos' => SalidaProducto::getSalidaProductos($salida->getId())
    ];

    return Render::to_response("@inventario/salidaproducto.twig", $context);
  }

  public static function save($data) {
    $salidaproducto = new SalidaProducto();
    $salidaproducto->setCantidad($data['cantidad']);
    $salidaproducto->setObservacion($data['observacion']);
    $salidaproducto->setIdSalida($data['id_salida']);
    $salidaproducto->setIdProducto($data['id_producto']);

    $status = $salidaproducto->save();

    return !$status ? "Error Transaccional" : "Procesado con exito";
  }

  public static function getdAll($id) {
    $salida = SalidaProducto::getSalidaCodigo($id);
    $salidaproductos = SalidaProducto::getAll($salida->getId());

    $context = [
      'salidaproductos'=> $salidaproductos,
      'salida'=> $salida
    ];
    return Render::to_response("@inventario/salidaproducto-list.twig", $context );
  }
}