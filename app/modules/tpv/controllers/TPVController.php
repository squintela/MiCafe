<?php

require_once './render/Render.php';
require_once './security/Session.php';
require_once './modules/venta/models/Pedido.php';
require_once './modules/venta/models/Cliente.php';
require_once './modules/venta/models/Orden.php';

class TPVController
{
  public static function createPedido($id_cliente) {
    $pedido = new Pedido();
    $pedido->setCodigo('PE-' . uniqid());

    $context = [
      'tipo_pagos' => Pedido::$tipo_pagos,
      'estados' => Pedido::$estados,
      'pedido' => $pedido,
      'cliente' => Cliente::getFindById($id_cliente)
    ];

    return Render::to_response("@tpv/pedido.twig", $context);
  }

  public static function savePedido($data) {
    if ($data['estado'] == 'Pagado')
      $data['estado'] = 'Pendiente';

    $pedido = new Pedido();
    $pedido->setId($data['id']);
    $pedido->setCodigo($data['codigo']);
    $pedido->setFecha($data['fecha']);
    $pedido->setMonto($data['monto']);
    $pedido->setTipoPago($data['tipo_pago']);
    $pedido->setIdEmpleado(1);
    $pedido->setIdCliente($data['id_cliente']);
    $pedido->setEstado($data['estado']);

    $status = ($pedido->getId() != 0) ? $pedido->update(): $pedido->save();

    $context = [
      'tipo_pagos' => Pedido::$tipo_pagos,
      'estados' => Pedido::$estados,
      'cliente' => Cliente::getFindById($data['id_cliente']),
      'pedido' => $pedido,
      'status' => $status
    ];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@tpv/pedido.twig", $context);
  }

  public static function getFindPedido($id) {
    $pedido = Pedido::getFindByIdProcess($id);

    $context = [
      'tipo_pagos' => Pedido::$tipo_pagos,
      'estados' => Pedido::$estados,
      'pedido' => $pedido,
      'cliente' => Cliente::getFindById($pedido->getIdCliente()),
      'status' => true
    ];

    return Render::to_response("@tpv/pedido.twig", $context);
  }

  public static function listPedido($id_cliente) {
    $pedidos = Pedido::getAllCliente($id_cliente);
    return Render::to_response("@tpv/pedido-list.twig", ['pedidos'=> $pedidos, 'id_cliente' => $id_cliente]);
  }

  public static function createOrden($id) {
    $pedido = Orden::getPedidoByCodigo($id);

    $context = [
      'pedido' => $pedido,
      'productos' => Orden::getProductos(),
      'ordenproductos' => Orden::getOrdenProductos($pedido->getId())
    ];

    return Render::to_response("@tpv/orden.twig", $context);
  }

  public static function listOrden($id) {
    $pedido = Orden::getPedidoByCodigo($id);
    $ordenproductos = Orden::getOrdenProductos($pedido->getId());

    $context = [
      'ordenproductos'=> $ordenproductos,
      'pedido'=> $pedido
    ];
    return Render::to_response("@tpv/orden-list.twig", $context );
  }

  public static function isLogIn($data){
    $usuario = Cliente::isLogin($data);
    $session = Session::getInstance();

    if (count($usuario) != 0) {
      $cliente = new Cliente();
      $cliente->setId($usuario['id']);
      $cliente->setNombres($usuario['nombres']);
      $cliente->setApellidos($usuario['apellidos']);
      $cliente->setCelular($usuario['celular']);
      $cliente->setNit($usuario['nit']);

      $session->cliente = $cliente;
      return self::createPedido($usuario['id']);

    } else {
      $session->destroy();
      return Render::to_response('@tpv/login.twig', []);
    }
  }

  public static function login() {
    return Render::to_response('@tpv/login.twig', []);
  }

  public static function isLogOut() {
    $session = Session::getInstance();
    $session->destroy();
    return Render::to_response('@tpv/login.twig', []);
  }
}