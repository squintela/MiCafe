<?php

require_once './modules/venta/models/Factura.php';
require_once './render/Render.php';

class FacturaController
{

  public static function create($id_pedido) {

    $pedido = Factura::getPedidoFindById($id_pedido);
    $cliente = Factura::getClienteFindById($pedido->getIdCliente());

    $factura = new Factura();
    $factura->setIdPedido($pedido->getId());
    $factura->setCodigo('FA-' . uniqid());
    $factura->setMonto($pedido->getMonto());
    $factura->setNit($cliente->getNit());
    $factura->setCliente($cliente->getNombres() .' '. $cliente->getApellidos());

    $context = [
      'pedido' => $pedido,
      'factura' => $factura
    ];

    return Render::to_response("@venta/factura.twig", $context);
  }

  public static function getFindById($id) {
    $factura = Factura::getFindById($id);
    $pedido = Factura::getPedidoFindById($factura->getIdPedido());

    $context = [
      'factura'=> $factura,
      'pedido' => $pedido
    ];

    return Render::to_response("@venta/factura.twig", $context);
  }

  public static function save($data) {

    $factura = new Factura();
    $factura->setId($data['id']);
    $factura->setCodigo($data['codigo']);
    $factura->setNit($data['nit']);
    $factura->setFecha($data['fecha']);
    $factura->setMonto($data['monto']);
    $factura->setRazon($data['razon']);
    $factura->setCliente($data['cliente']);
    $factura->setIdPedido($data['id_pedido']);

    $status = ($factura->getId() != 0) ? $factura->update(): $factura->save();

    $context = [
      'factura' => $factura,
      'pedido' => Factura::getPedidoFindById($factura->getIdPedido())
    ];

    if (!$status)
      $context['errors'] = "Existe una factura para este pedido";

    return Render::to_response("@venta/factura.twig", $context);
  }

  public static function delete($id) {
    Factura::delete($id);
    return self::getdAll();
  }

  public static function getdAll() {
    $facturas = Factura::getAll();
    return Render::to_response("@venta/factura-list.twig", ['facturas'=> $facturas]);
  }
}