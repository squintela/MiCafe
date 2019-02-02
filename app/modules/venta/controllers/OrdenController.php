<?php

require_once './modules/venta/models/Orden.php';
require_once './render/Render.php';

class OrdenController
{
  public static function create($id) {
    $pedido = Orden::getPedidoByCodigo($id);

    $context = [
      'pedido' => $pedido,
      'productos' => Orden::getProductos(),
      'ordenproductos' => Orden::getOrdenProductos($pedido->getId())
    ];

    return Render::to_response("@venta/orden.twig", $context);
  }

  public static function save($data) {
    $orden = new Orden();
    $orden->setCantidad($data['cantidad']);
    $orden->setPrecio($data['precio']);
    $orden->setIdPedido($data['id_pedido']);
    $orden->setIdProducto($data['id_producto']);

    $status = $orden->save();

    return !$status ? "No puede realizar esta operacion o no existe el producto en stock" : "Procesado con exito";
  }

  public static function getAll($id) {
    $pedido = Orden::getPedidoByCodigo($id);
    $ordenproductos = Orden::getOrdenProductos($pedido->getId());


    $context = [
      'ordenproductos'=> $ordenproductos,
      'pedido'=> $pedido
    ];
    return Render::to_response("@venta/orden-list.twig", $context );
  }
}