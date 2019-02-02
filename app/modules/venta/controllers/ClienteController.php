<?php

require_once './modules/venta/models/Cliente.php';
require_once './render/Render.php';

class ClienteController
{
  public static function create() {
    return Render::to_response("@venta/cliente.twig", []);
  }

  public static function getFindById($id) {
    $cliente = Cliente::getFindById($id);
    return Render::to_response("@venta/cliente.twig", ['cliente'=> $cliente]);
  }

  public static function save($data) {
    $cliente = new Cliente();
    $cliente->setId($data['id']);
    $cliente->setNombres($data['nombres']);
    $cliente->setApellidos($data['apellidos']);
    $cliente->setCelular($data['celular']);
    $cliente->setNit($data['nit']);

    $status = ($cliente->getId() != 0) ? $cliente->update(): $cliente->save();

    $context = ['cliente' => $cliente];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@venta/cliente.twig", $context);
  }

  public static function delete($id) {
    Cliente::delete($id);
    return self::getdAll();
  }

  public static function getdAll() {
    $clientes = Cliente::getAll();
    return Render::to_response("@venta/cliente-list.twig", ['clientes'=> $clientes]);
  }
}