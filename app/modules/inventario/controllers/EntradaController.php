<?php

require_once './modules/inventario/models/Entrada.php';
require_once './render/Render.php';

class EntradaController
{
  public static function create() {
    $entrada = new Entrada();
    $entrada->setCodigo('IN-' . uniqid());

    $context = [
      'empleados'=> Entrada::getEmpleados(),
      'entrada' => $entrada
    ];

    return Render::to_response("@inventario/entrada.twig", $context);
  }

  public static function getFindById($id) {
    $entrada = Entrada::getFindById($id);

    $context = [
      'empleados'=> Entrada::getEmpleados(),
      'entrada' => $entrada,
      'status' => true
    ];

    return Render::to_response("@inventario/entrada.twig", $context);
  }

  public static function save($data) {
    $entrada = new Entrada();
    $entrada->setId($data['id']);
    $entrada->setCodigo($data['codigo']);
    $entrada->setFecha($data['fecha']);
    $entrada->setIdEmpleado($data['id_empleado']);

    $status = ($entrada->getId() != 0) ? $entrada->update(): $entrada->save();

    $context = [
      'empleados'=> Entrada::getEmpleados(),
      'entrada' => $entrada,
      'status' => $status
    ];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@inventario/entrada.twig", $context);
  }

  public static function delete($id) {
    Entrada::delete($id);
    return self::getdAll();
  }

  public static function getdAll() {
    $entradas = Entrada::getAll();

    return Render::to_response("@inventario/entrada-list.twig", ['entradas'=> $entradas]);
  }
}