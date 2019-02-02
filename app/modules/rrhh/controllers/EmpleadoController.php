<?php

require_once './modules/rrhh/models/Empleado.php';
require_once './render/Render.php';

class EmpleadoController
{
  public static function create() {
    $context = [
      'usuarios' => Empleado::getUsuarios(),
      'generos' => Empleado::$generos,
      'cargos' => Empleado::$cargos
    ];

    return Render::to_response("@rrhh/empleado.twig", $context);
  }

  public static function getFindById($id) {
    $empleado = Empleado::getFindById($id);

    $context = [
      'empleado' => $empleado,
      'usuarios' => Empleado::getUsuarios(),
      'generos' => Empleado::$generos,
      'cargos' => Empleado::$cargos
    ];

    return Render::to_response("@rrhh/empleado.twig", $context);
  }

  public static function save($data) {
    $empleado = new Empleado();
    $empleado->setId($data['id']);
    $empleado->setNombres($data['nombres']);
    $empleado->setApellidos($data['apellidos']);
    $empleado->setCi($data['ci']);
    $empleado->setGenero($data['genero']);
    $empleado->setCargo($data['cargo']);
    $empleado->setTelefono($data['telefono']);
    $empleado->setIdUsuario($data['id_usuario']);

    $status = ($empleado->getId() != 0) ? $empleado->update(): $empleado->save();

    $context = [
      'empleado' => $empleado,
      'usuarios' => Empleado::getUsuarios(),
      'generos' => Empleado::$generos,
      'cargos' => Empleado::$cargos
    ];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@rrhh/empleado.twig", $context);
  }

  public static function delete($id) {
    Empleado::delete($id);
    return self::getdAll();
  }

  public static function getdAll() {
    $empleados = Empleado::getAll();
    return Render::to_response("@rrhh/empleado-list.twig", ['empleados'=> $empleados]);
  }
}