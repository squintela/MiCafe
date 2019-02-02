<?php

require_once './db/DataBase.php';
require_once './modules/inventario/models/Entrada.php';
require_once './modules/inventario/models/Producto.php';

class EntradaProducto
{
  private $id;
  private $cantidad;
  private $observacion;
  private $id_entrada;
  private $id_producto;

  public function __construct()
  {
    $this->id = 0;
    $this->cantidad = 0;
    $this->observacion = "";
    $this->id_entrada = 0;
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

  public function setIdEntrada($id_entrada)
  {
    $this->id_entrada = $id_entrada;
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

  public function getIdEntrada()
  {
    return $this->id_entrada;
  }

  public function getIdProducto()
  {
    return $this->id_producto;
  }

  public function save () {
    return DataBase::insert("entrada_producto", [
      "cantidad"=> $this->cantidad,
      "observacion" => $this->observacion,
      "id_entrada" => $this->id_entrada,
      "id_producto" => $this->id_producto
    ]);
  }

  public static function delete ($id) {
    return DataBase::delete("delete from entrada_producto where id=$id");
  }

  public static function getAll($id) {
    return DataBase::getAll("select ep.id, ep.cantidad, ep.observacion, p.codigo ,concat (p.nombre, ' / ', p.marca ,'  (', p.unidad,' )' ) as id_producto from entrada_producto ep, producto p where ep.id_entrada=$id and  ep.id_producto=p.id;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from entrada_producto where id=$id;");
    return self::toObject($data);
  }

  public static function getEntrada($id) {
    return Entrada::getFindById($id);
  }

  public static function getEntradaCodigo($id) {
    return Entrada::getFindCodigo($id);
  }

  public static function getProductos($id) {
    return DataBase::getAll("select id, codigo, nombre, marca, unidad, precio from producto where id not in ( select id_producto from entrada_producto where id_entrada=$id);");
  }

  public static function getEntradaProductos($id){
    return DataBase::getAll("select p.id, p.codigo, p.nombre, p.marca, p.unidad, p.precio, ep.observacion, ep.cantidad from entrada_producto ep, producto p where ep.id_entrada=$id and ep.id_producto=p.id;");
  }

  private static function toObject($data) {
    $entradaproducto = new EntradaProducto();
    $entradaproducto->setCantidad($data['cantidad']);
    $entradaproducto->setObservacion($data['observacion']);
    $entradaproducto->setIdEntrada($data['id_entrada']);
    $entradaproducto->setIdProducto($data['id_producto']);

    return $entradaproducto;
  }
}