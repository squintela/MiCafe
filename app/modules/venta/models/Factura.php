<?php

require_once './db/DataBase.php';
require_once './modules/venta/models/Pedido.php';
require_once './modules/venta/models/Cliente.php';

class Factura
{
  private $id;
  private $codigo;
  private $nit;
  private $fecha;
  private $monto;
  private $razon;
  private $cliente;
  private $id_pedido;

  public function __construct()
  {
    $this->id = 0;
    $this->codigo = "";
    $this->nit = "";
    $this->fecha = "";
    $this->monto = 0.0;
    $this->razon = "";
    $this->cliente = "";
    $this->id_pedido = 0;
  }

  public function setId($id)
  {
    if ($id != '')
      $this->id = $id;
  }

  public function setNit($nit)
  {
    $this->nit = $nit;
  }

  public function setFecha($fecha)
  {
    $this->fecha = $fecha;
  }

  public function setHora($hora)
  {
    $this->hora = $hora;
  }

  public function setRazon($razon)
  {
    $this->razon = $razon;
  }

  public function getCodigo()
  {
    return $this->codigo;
  }

  public function setCodigo($codigo)
  {
    $this->codigo = $codigo;
  }

  public function getMonto()
  {
    return $this->monto;
  }

  public function setMonto($monto)
  {
    $this->monto = $monto;
  }

  public function getCliente()
  {
    return $this->cliente;
  }

  public function setCliente($cliente)
  {
    $this->cliente = $cliente;
  }

  public function getIdPedido()
  {
    return $this->id_pedido;
  }

  public function setIdPedido($id_pedido)
  {
    $this->id_pedido = $id_pedido;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getNit()
  {
    return $this->nit;
  }

  public function getFecha()
  {
    return $this->fecha;
  }

  public function getRazon()
  {
    return $this->razon;
  }

  public function save () {
    return DataBase::insert("factura", [
      "codigo"=> $this->codigo,
      "nit" => $this->nit,
      "fecha" => $this->fecha,
      "monto" => $this->monto,
      "razon" => $this->razon,
      "cliente" => $this->cliente,
      "id_pedido" => $this->id_pedido
    ]);
  }

  public function update () {
    return DataBase::update("factura", [
      "codigo"=> $this->codigo,
      "nit" => $this->nit,
      "fecha" => $this->fecha,
      "monto" => $this->monto,
      "razon" => $this->razon,
      "cliente" => $this->cliente,
      "id_pedido" => $this->id_pedido
    ], 'id='.$this->id );
  }

  public static function delete ($id) {
    return DataBase::delete("delete from factura where id=$id");
  }

  public static function getAll() {
    return DataBase::getAll("select * from factura;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from factura where id=$id;");
    return self::toObject($data);
  }

  public static function getPedidoFindById($id_pedido) {
    return Pedido::geFindById($id_pedido);
  }

  public static function getClienteFindById($id_cliente) {
    return Cliente::getFindById($id_cliente);
  }

  private static function toObject($data) {
    $factura = new Factura();
    $factura->setId($data['id']);
    $factura->setCodigo($data['codigo']);
    $factura->setNit($data['nit']);
    $factura->setFecha($data['fecha']);
    $factura->setMonto($data['monto']);
    $factura->setRazon($data['razon']);
    $factura->setCliente($data['cliente']);
    $factura->setIdPedido($data['id_pedido']);

    return $factura;
  }
}