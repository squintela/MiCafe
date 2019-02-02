<?php

require_once './db/DataBase.php';
require_once './modules/inventario/models/Salida.php';
require_once './modules/inventario/models/Producto.php';

class SalidaProducto
{
  private $id;
  private $cantidad;
  private $observacion;
  private $id_salida;
  private $id_producto;

  public function __construct()
  {
    $this->id = 0;
    $this->cantidad = 0;
    $this->observacion = "";
    $this->id_salida = 0;
    $this->id_producto = 0;
  }

  public function setId($id)
  {
    if ($id != '')
      $this->id = $id;
  }

  public function setCantidad($cantidad)
  {
    $this->cantidad = $cantidad;
  }

  public function setObservacion($observacion)
  {
    $this->observacion = $observacion;
  }

  public function setIdSalida($id_salida)
  {
    $this->id_salida = $id_salida;
  }

  public function setIdProducto($id_producto)
  {
    $this->id_producto = $id_producto;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getCantidad()
  {
    return $this->cantidad;
  }

  public function getObservacion()
  {
    return $this->observacion;
  }

  public function getIdSalida()
  {
    return $this->id_salida;
  }

  public function getIdProducto()
  {
    return $this->id_producto;
  }

  public function save () {
    return DataBase::insert("salida_producto", [
      "cantidad"=> $this->cantidad,
      "observacion" => $this->observacion,
      "id_salida" => $this->id_salida,
      "id_producto" => $this->id_producto
    ]);
  }

  public static function delete ($id) {
    return DataBase::delete("delete from salida_producto where id=$id");
  }

  public static function getAll($id) {
    return DataBase::getAll("select ep.id, ep.cantidad, ep.observacion, p.codigo, concat (p.nombre, ' / ', p.marca ,'  (', p.unidad,' )' ) as id_producto from salida_producto ep, producto p where ep.id_salida=$id and  ep.id_producto=p.id;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from salida_producto where id=$id;");
    return self::toObject($data);
  }

  public static function getSalida($id) {
    return Salida::getFindById($id);
  }

  public static function getSalidaCodigo($id) {
    return Salida::getFindCodigo($id);
  }

  public static function getProductos($id) {
    return DataBase::getAll("select id, codigo, nombre, marca, unidad, precio from producto where id not in ( select id_producto from salida_producto where id_salida=$id);");
  }

  public static function getSalidaProductos($id){
    return DataBase::getAll("select p.id, p.codigo, p.nombre, p.marca, p.unidad, p.precio, ep.observacion, ep.cantidad from salida_producto ep, producto p where ep.id_salida=$id and ep.id_producto=p.id;");
  }

  private static function toObject($data) {
    $salidaproducto = new SalidaProducto();
    $salidaproducto->setCantidad($data['cantidad']);
    $salidaproducto->setObservacion($data['observacion']);
    $salidaproducto->setIdSalida($data['id_salida']);
    $salidaproducto->setIdProducto($data['id_producto']);

    return $salidaproducto;
  }
}