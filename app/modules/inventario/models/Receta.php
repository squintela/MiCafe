<?php

require_once './db/DataBase.php';

class Receta
{
  private $id;
  private $codigo;
  private $nombre;
  private $descripcion;

  public function __construct()
  {
    $this->id = 0;
    $this->codigo = "";
    $this->nombre = "";
    $this->descripcion = "";
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

  public function getNombre()
  {
    return $this->nombre;
  }

  public function setNombre($nombre)
  {
    $this->nombre = $nombre;
  }

  public function getCodigo()
  {
    return $this->codigo;
  }

  public function setCodigo($codigo)
  {
    $this->codigo = $codigo;
  }

  
  public function getDescripcion()
  {
    return $this->descripcion;
  }

  public function setDescripcion($descripcion)
  {
    $this->descripcion = $descripcion;
  }

  public function save () {
    return DataBase::insert("receta", [
      "nombre"=> $this->nombre,
      "codigo" => $this->codigo,
      "descripcion" => $this->descripcion
    ]);
  }

  public function update () {
    return DataBase::update("receta", [
      "nombre"=> $this->nombre,
      "codigo" => $this->codigo,
      "descripcion" => $this->descripcion
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
    return DataBase::getAll("select  id, nombre as name from receta;");
  }

  private static function toObject($data) {
    $receta = new Receta();
    $receta->setId($data['id']);
    $receta->setCodigo($data['codigo']);
    $receta->setNombre($data['nombre']);
    $receta->setDescripcion($data['descripcion']);
    return $receta;
  }
}