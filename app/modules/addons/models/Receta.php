<?php

require_once './db/DataBase.php';

class Receta
{
  private $id;
  private $codigo;
  private $nombre;
  private $cantidad;
  private $preparacion;

  public function __construct()
  {
    $this->id = 0;
    $this->codigo = '';
    $this->nombre = '';
    $this->cantidad = 0;
    $this->preparacion = '';
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

  public function getNombre()
  {
    return $this->nombre;
  }

  public function setNombre($nombre)
  {
    $this->nombre = $nombre;
  }

  public function getCantidad()
  {
    return $this->cantidad;
  }

  public function setCantidad($cantidad)
  {
    $this->cantidad = $cantidad;
  }

  public function getPreparacion()
  {
    return $this->preparacion;
  }

  public function setPreparacion($preparacion)
  {
    $this->preparacion = $preparacion;
  }

  public function save () {
    return DataBase::insert("receta", [
      "codigo"=> $this->codigo,
      "nombre" => $this->nombre,
      "cantidad" => $this->cantidad,
      "preparacion" => $this->preparacion
    ]);
  }

  public function update () {
    return DataBase::update("receta", [
      "codigo"=> $this->codigo,
      "nombre" => $this->nombre,
      "cantidad" => $this->cantidad,
      "preparacion" => $this->preparacion
    ], 'id='.$this->id );
  }

  public static function delete ($id) {
    return DataBase::delete("delete from receta where id=$id");
  }

  public static function getAll() {
    return DataBase::getAll("select * from receta;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from receta where id=$id;");
    return self::toObject($data);
  }

  public static function getAssoc() {
    return DataBase::getAll("select  id, nombre as name from usuario;");
  }

  private static function toObject($data) {
    $receta = new Receta();
    $receta->setId($data['id']);
    $receta->setCodigo($data['codigo']);
    $receta->setNombre($data['nombre']);
    $receta->setCantidad($data['cantidad']);
    $receta->setPreparacion($data['preparacion']);
    return $receta;
  }
}