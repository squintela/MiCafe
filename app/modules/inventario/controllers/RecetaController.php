<?php

require_once './modules/inventario/models/Receta.php';
require_once './security/Session.php';
require_once './render/Render.php';

class RecetaController
{

  public static function create() {
    return Render::to_response("@inventario/receta.twig", []);
  }

  public static function getFindById($id) {
    $receta = Receta::getFindById($id);
    return Render::to_response("@inventario/receta.twig", ['receta'=> $receta]);
  }

  public static function save($data) {
    $receta = new Receta();
    $receta->setId($data['id']);
    $receta->setCodigo($data['codigo']);
    $receta->setNombre($data['nombre']);
    $receta->setDescripcion($data['descripcion']);

    $status = ($receta->getId() != 0) ? $receta->update(): $receta->save();
    $context = ['receta' => $receta];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@inventario/receta.twig", $context);
  }

  public static function delete($id) {
    Receta::delete($id);
    return self::getdAll();
  }

  public static function getAll() {
    $recetas = Receta::getAll();
    return Render::to_response("@inventario/receta-list.twig", ['recetas'=> $recetas]);
  }
}