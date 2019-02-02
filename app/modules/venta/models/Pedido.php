<?php

require_once './db/DataBase.php';
require_once './modules/rrhh/models/Empleado.php';
require_once './modules/venta/models/Cliente.php';

class Pedido
{
  private $id;
  private $codigo;
  private $fecha;
  private $monto;
  private $tipo_pago;
  private $id_empleado;
  private $id_cliente;
  private $estado;

  public static $estados = [
    ['id'=>'Pendiente', 'name'=>'Pendiente'],
    ['id'=>'Cancelado', 'name'=>'Cancelado'],
    ['id'=>'Pagado', 'name'=>'Pagado'],
  ];
  public static $tipo_pagos = [
    ['id'=>'Efectivo', 'name'=>'Efectivo'],
    ['id'=>'Tarjeta credito', 'name'=>'Tarjeta credito'],
    ['id'=>'Tarjeta de debito', 'name'=>'Tarjeta de debito']
  ];

  public function __construct()
  {
    $this->id = 0;
    $this->codigo = "";
    $this->fecha = "";
    $this->monto = 0.0;
    $this->tipo_pago = "";
    $this->id_empleado = 0;
    $this->id_cliente = 0;
    $this->estado = "";
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    if ($id != '')
      $this->id = $id;
  }

  public function getCodigo()
  {
    return $this->codigo;
  }

  public function setCodigo($codigo)
  {
    $this->codigo = $codigo;
  }

  public function getFecha()
  {
    return $this->fecha;
  }

  public function setFecha($fecha)
  {
    $this->fecha = $fecha;
  }

  public function getMonto()
  {
    return $this->monto;
  }

  public function setMonto($monto)
  {
    $this->monto = $monto;
  }

  public function getTipoPago()
  {
    return $this->tipo_pago;
  }

  public function setTipoPago($tipo_pago)
  {
    $this->tipo_pago = $tipo_pago;
  }

  public function getIdEmpleado()
  {
    return $this->id_empleado;
  }

  public function setIdEmpleado($id_empleado)
  {
    $this->id_empleado = $id_empleado;
  }

  public function getIdCliente()
  {
    return $this->id_cliente;
  }

  public function setIdCliente($id_cliente)
  {
    $this->id_cliente = $id_cliente;
  }

  public function getEstado()
  {
    return $this->estado;
  }

  public function setEstado($estado)
  {
    $this->estado = $estado;
  }

  public function save()
  {
    return DataBase::insert("pedido", [
      'codigo' => $this->codigo,
      'fecha'=> $this->fecha,
      'monto'=> $this->monto,
      'tipo_pago'=> $this->tipo_pago,
      'id_empleado'=> $this->id_empleado,
      'id_cliente'=> $this->id_cliente,
      'estado'=> $this->estado
    ]);
  }

  public function update() {
    return DataBase::update("pedido", [
      'codigo' => $this->codigo,
      'fecha'=> $this->fecha,
      'monto'=> $this->monto,
      'tipo_pago'=> $this->tipo_pago,
      'id_empleado'=> $this->id_empleado,
      'id_cliente'=> $this->id_cliente,
      'estado'=> $this->estado
    ], 'id='.$this->id);
  }

  public static function getAllToDay() {
    return DataBase::getAll("SELECT p.id, p.codigo, p.fecha, p.tipo_pago, p.estado, p.id_empleado, p.id_cliente , sum(o.precio) as monto, concat(c.nombres, ' ', c.apellidos, ' | ', c.nit) as id_cliente FROM pedido p, orden o, cliente c where Date_format(fecha, '%y-%m-%d') = curdate() and p.id = o.id_pedido and p.id_cliente = c.id group by p.id");
  }

  public static function getAll() {
    return DataBase::getAll("SELECT p.id, p.codigo, p.fecha, p.tipo_pago, p.estado, p.id_empleado, p.id_cliente , sum(o.precio) as monto, concat(c.nombres, ' ', c.apellidos, ' | ', c.nit) as id_cliente FROM pedido p, orden o, cliente c where p.id = o.id_pedido and p.id_cliente = c.id group by p.id");
  }

  public static function getAllCliente($id_cliente) {
    return DataBase::getAll("SELECT p.id, p.codigo, p.fecha, p.tipo_pago, p.estado, p.id_empleado, p.id_cliente , sum(o.precio) as monto, concat(c.nombres, ' ', c.apellidos, ' | ', c.nit) as id_cliente FROM pedido p, orden o, cliente c where p.id = o.id_pedido and p.id_cliente = c.id and c.id=$id_cliente group by p.id");
  }

  public static function delete ($id) {
    return DataBase::delete("delete from pedido where id=$id;");
  }

  public static function getFindByIdProcess($id) {
    $data = DataBase::getRow("select p.id, p.codigo, p.fecha, p.tipo_pago, p.estado, p.id_empleado, p.id_cliente, sum(o.precio) as monto from pedido p, orden o where p.id=$id and p.id = o.id_pedido");
    return self::toObject($data);
  }

  public static function geFindById ($id) {
    $data = DataBase::getRow("select * from pedido where id=$id;");
    return self::toObject($data);
  }

  public static function geFindByIdCodigo ($id) {
    $data = DataBase::getRow("select * from pedido where codigo='$id';");
    return self::toObject($data);
  }

  public static function getClientes () {
    return Cliente::getAssoc();
  }

  public static function getEmpleados () {
    return Empleado::getAssoc();
  }

  private static function toObject($data) {
    $pedido = new Pedido();
    $pedido->setId($data['id']);
    $pedido->setCodigo($data['codigo']);
    $pedido->setFecha($data['fecha']);
    $pedido->setMonto($data['monto']);
    $pedido->setTipoPago($data['tipo_pago']);
    $pedido->setIdEmpleado($data['id_empleado']);
    $pedido->setIdCliente($data['id_cliente']);
    $pedido->setEstado($data['estado']);

    return $pedido;
  }

}