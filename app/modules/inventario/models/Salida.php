<?php

require_once './db/DataBase.php';
require_once './modules/rrhh/models/Empleado.php';

class Salida
{
  private $id;
  private $codigo;
  private $fecha;
  private $id_empleado;

  public function __construct()
  {
    $this->id = 0;
    $this->codigo = "";
    $this->fecha = "";
    $this->id_empleado = 0;
  }

  public function setId($id)
  {
    if ($id != '')
      $this->id = $id;
  }

  public function setCodigo($codigo)
  {
    $this->codigo = $codigo;
  }

  public function setFecha($fecha)
  {
    $this->fecha = $fecha;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getCodigo()
  {
    return $this->codigo;
  }

  public function getFecha()
  {
    return $this->fecha;
  }

  public function getIdEmpleado()
  {
    return $this->id_empleado;
  }

  public function setIdEmpleado($id_empleado)
  {
    $this->id_empleado = $id_empleado;
  }

  public function save () {
    return DataBase::insert("salida", [
      "codigo"=> $this->codigo,
      "fecha" => $this->fecha,
      "id_empleado" => $this->id_empleado
    ]);
  }

  public function update () {
    return DataBase::update("salida", [
      "codigo"=> $this->codigo,
      "fecha" => $this->fecha,
      "id_empleado" => $this->id_empleado
    ], 'id='.$this->id );
  }

  public static function delete ($id) {
    return DataBase::delete("delete from salida where id=$id");
  }

  public static function getAll() {
    return DataBase::getAll("select en.id, en.codigo, en.fecha, concat(e.ci, ' | ', e.nombres ,' ', e.apellidos ) as id_empleado from salida en, empleado e where en.id_empleado = e.id");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from salida where id=$id;");
    return self::toObject($data);
  }

  public static function getFindCodigo($id) {
    $data = DataBase::getRow("select * from salida where codigo='$id';");
    return self::toObject($data);
  }

  public static function getAssoc() {
    return DataBase::getAll("select  id, codigo as name from salida;");
  }

  public static function getEmpleados() {
    return Empleado::getAssoc();
  }

  private static function toObject($data) {
    $salida = new salida();
    $salida->setId($data['id']);
    $salida->setCodigo($data['codigo']);
    $salida->setFecha($data['fecha']);
    $salida->setIdEmpleado($data['id_empleado']);

    return $salida;
  }
}