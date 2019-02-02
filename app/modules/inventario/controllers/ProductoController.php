<?php

require_once './modules/inventario/models/Producto.php';
require_once './render/Render.php';

class ProductoController
{

  public static function create() {
    $producto = new Producto();
    $producto->setCodigo('PR-' . uniqid());

    $context = [
      'unidades'=> Producto::$unidades,
      'tipos' => Producto::$tipos,
      'producto' => $producto
      ];

    return Render::to_response("@inventario/producto.twig", $context);
  }

  public static function getFindById($id) {
    $producto = Producto::getFindById($id);

    $context = [
      'producto'=> $producto,
      'unidades'=> Producto::$unidades,
      'tipos' => Producto::$tipos
    ];

    return Render::to_response("@inventario/producto.twig", $context);
  }

  public static function save($data) {
    $producto = new Producto();
    $producto->setId($data['id']);
    $producto->setCodigo($data['codigo']);
    $producto->setNombre($data['nombre']);
    $producto->setMarca($data['marca']);
    $producto->setUnidad($data['unidad']);
    $producto->setTipo($data['tipo']);
    $producto->setPrecio($data['precio']);
    $producto->setVolumen($data['volumen']);

    $status = ($producto->getId() != 0) ? $producto->update(): $producto->save();

    $context = [
      'producto'=>$producto,
      'unidades'=> Producto::$unidades,
      'tipos' => Producto::$tipos
    ];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@inventario/producto.twig", $context);
  }

  public static function delete($id) {
    Producto::delete($id);
    return self::getdAll();
  }

  public static function getdAll() {
    $productos = Producto::getAll();
    return Render::to_response("@inventario/producto-list.twig", ['productos'=> $productos]);
  }
}