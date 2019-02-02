<?php

require_once './db/DataBase.php';
require_once './modules/venta/models/Pedido.php';
require_once './modules/inventario/models/Producto.php';

class Orden
{
  private $id;
  private $cantidad;
  private $precio;
  private $id_pedido;
  private $id_producto;

  public function __construct()
  {
    $this->id = 0;
    $this->cantidad = 0;
    $this->precio = 0.0;
    $this->id_pedido = 0;
    $this->id_producto = 0;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setCantidad($cantidad)
  {
    $this->cantidad = $cantidad;
  }

  public function setPrecio($precio)
  {
    $this->precio = $precio;
  }

  public function setIdPedido($id_pedido)
  {
    $this->id_pedido = $id_pedido;
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

  public function getPrecio()
  {
    return $this->precio;
  }

  public function getIdPedido()
  {
    return $this->id_pedido;
  }

  public function getIdProducto()
  {
    return $this->id_producto;
  }

  public function save () {
    $pedido = self::getPedido($this->id_pedido);

    if ($pedido->getEstado() != 'Pagado')
      return DataBase::insert("orden", [
      "cantidad"=> $this->cantidad,
      "precio" => $this->precio,
      "id_pedido" => $this->id_pedido,
      "id_producto" => $this->id_producto
    ]);

    return false;
  }

  public static function delete ($id) {
    return DataBase::delete("delete from salida_producto where id=$id");
  }

  public static function getAll($id) {
    return DataBase::getAll("select ep.id, ep.cantidad, ep.observacion, concat (p.nombre, ' / ', p.marca ,'  (', p.unidad,' )' ) as id_producto from salida_producto ep, producto p where ep.id_salida=$id and  ep.id_producto=p.id;");
  }

  public static function getPedidoByCodigo($id) {
    return Pedido::geFindByIdCodigo($id);
  }

  public static function getPedido($id) {
    return Pedido::geFindById($id);
  }

  public static function getProductos() {
    return Producto::getAllConsumible();
  }

  public static function getOrdenProductos($id){
    return DataBase::getAll("select p.id, p.nombre, p.marca, p.precio, o.cantidad, o.precio as precio_total from orden o, producto p where o.id_pedido=$id and o.id_producto=p.id ");
  }
}