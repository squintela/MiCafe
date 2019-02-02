<?php

require_once './modules/venta/models/Pedido.php';
require_once './render/Render.php';

class PedidoController
{
  public static function create() {
    $pedido = new Pedido();
    $pedido->setCodigo('PE-' . uniqid());

    $context = [
      'tipo_pagos' => Pedido::$tipo_pagos,
      'estados' => Pedido::$estados,
      'empleados' => Pedido::getEmpleados(),
      'clientes' => Pedido::getClientes(),
      'pedido' => $pedido
    ];

    return Render::to_response("@venta/pedido.twig", $context);
  }

  public static function getFindById($id) {
    $pedido = Pedido::getFindByIdProcess($id);

    $context = [
      'tipo_pagos' => Pedido::$tipo_pagos,
      'estados' => Pedido::$estados,
      'empleados' => Pedido::getEmpleados(),
      'clientes' => Pedido::getClientes(),
      'pedido' => $pedido,
      'status' => true
    ];

    return Render::to_response("@venta/pedido.twig", $context);
  }

  public static function save($data) {

    $pedido = new Pedido();
    $pedido->setId($data['id']);
    $pedido->setCodigo($data['codigo']);
    $pedido->setFecha($data['fecha']);
    $pedido->setMonto($data['monto']);
    $pedido->setTipoPago($data['tipo_pago']);
    $pedido->setIdEmpleado($data['id_empleado']);
    $pedido->setIdCliente($data['id_cliente']);
    $pedido->setEstado($data['estado']);

    $status = ($pedido->getId() != 0) ? $pedido->update(): $pedido->save();

    $context = [
      'tipo_pagos' => Pedido::$tipo_pagos,
      'estados' => Pedido::$estados,
      'empleados' => Pedido::getEmpleados(),
      'clientes' => Pedido::getClientes(),
      'pedido' => $pedido,
      'status' => $status
    ];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@venta/pedido.twig", $context);
  }

  public static function delete($id) {
    Pedido::delete($id);
    return self::getAll();
  }

  public static function getAll() {
    $pedidos = Pedido::getAll();
    return Render::to_response("@venta/pedido-list.twig", ['pedidos'=> $pedidos]);
  }
}