<?php

require_once './db/DataBase.php';

class OrdenProduccion
{
  private $id;
  private $codigo;
  private $cantidad;
  private $fecha;
  private $fecha_entrega;
  private $id_empleado;
  private $id_receta;

  public function __construct()
  {
    $this->id = 0;
    $this->codigo = "";
    $this->cantidad = 0;
    $this->fecha = "";
    $this->fecha_entrega = "";
    $this->id_empleado = 0;
    $this->id_receta = 0;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
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

  public function getCantidad()
  {
    return $this->cantidad;
  }

  public function setCantidad($cantidad)
  {
    $this->cantidad = $cantidad;
  }

  public function getFecha()
  {
    return $this->fecha;
  }

  public function setFecha($fecha)
  {
    $this->fecha = $fecha;
  }

  public function getFechaEntrega()
  {
    return $this->fecha_entrega;
  }

  public function setFechaEntrega($fecha_entrega)
  {
    $this->fecha_entrega = $fecha_entrega;
  }

  public function getIdEmpleado()
  {
    return $this->id_empleado;
  }

  public function setIdEmpleado($id_empleado)
  {
    $this->id_empleado = $id_empleado;
  }

  public function getIdReceta()
  {
    return $this->id_receta;
  }

  public function setIdReceta($id_receta)
  {
    $this->id_receta = $id_receta;
  }

  public function save () {
    return DataBase::insert("orden_produccion", [
      "codigo"=> $this->codigo,
      "cantidad" => $this->cantidad,
      "fecha" => $this->fecha,
      "fecha_entrega" => $this->fecha_entrega,
      "id_empleado" => $this->id_empleado,
      "id_receta" => $this->id_receta
    ]);
  }

  public function update () {
    return DataBase::update("orden_produccion", [
      "codigo"=> $this->codigo,
      "cantidad" => $this->cantidad,
      "fecha" => $this->fecha,
      "fecha_entrega" => $this->fecha_entrega,
      "id_empleado" => $this->id_empleado,
      "id_receta" => $this->id_receta
    ], 'id='.$this->id );
  }

  public static function delete ($id) {
    return DataBase::delete("delete from orden_produccion where id=$id");
  }

  public static function getAll() {
    return DataBase::getAll("select * from orden_produccion;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from orden_produccion where id=$id;");
    return self::toObject($data);
  }

  public static function getAssoc() {
    return DataBase::getAll("select  id, nombre as name from orden_produccion;");
  }

  private static function toObject($data) {
    $receta = new Receta();
    $receta->setId($data['id']);
    $receta->setCodigo($data['codigo']);
    $receta->setCantidad($data['cantidad']);
    $receta->setFecha($data['nombre']);
    $receta->setPreparacion($data['preparacion']);
    return $receta;
  }
}