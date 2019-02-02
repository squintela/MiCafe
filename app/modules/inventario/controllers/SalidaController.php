<?php

require_once './modules/inventario/models/Salida.php';
require_once './render/Render.php';

class SalidaController
{
  public static function create() {
    $salida = new Salida();
    $salida->setCodigo('OU-' . uniqid());

    $context = [
      'empleados'=> salida::getEmpleados(),
      'salida' => $salida
    ];

    return Render::to_response("@inventario/salida.twig", $context);
  }

  public static function getFindById($id) {
    $salida = salida::getFindById($id);

    $context = [
      'empleados'=> salida::getEmpleados(),
      'salida' => $salida,
      'status' => true
    ];

    return Render::to_response("@inventario/salida.twig", $context);
  }

  public static function save($data) {
    $salida = new salida();
    $salida->setId($data['id']);
    $salida->setCodigo($data['codigo']);
    $salida->setFecha($data['fecha']);
    $salida->setIdEmpleado($data['id_empleado']);

    $status = ($salida->getId() != 0) ? $salida->update(): $salida->save();

    $context = [
      'empleados'=> salida::getEmpleados(),
      'salida' => $salida,
      'status' => $status
    ];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@inventario/salida.twig", $context);
  }

  public static function delete($id) {
    salida::delete($id);
    return self::getdAll();
  }

  public static function getdAll() {
    $salidas = salida::getAll();

    return Render::to_response("@inventario/salida-list.twig", ['salidas'=> $salidas]);
  }
}