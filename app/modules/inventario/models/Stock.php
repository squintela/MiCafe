<?php

require_once './db/DataBase.php';

class Stock
{
  private $id;
  private $id_producto;
  private $entradas;
  private $salidas;
  private $existencias;

  public function __construct()
  {
    $this->id = 0;
    $this->id_producto = 0;
    $this->entradas = 0;
    $this->salidas = 0;
    $this->existencias = 0;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getIdProducto()
  {
    return $this->id_producto;
  }

  public function setIdProducto($id_producto)
  {
    $this->id_producto = $id_producto;
  }

  public function getEntradas()
  {
    return $this->entradas;
  }

  public function setEntradas($entradas)
  {
    $this->entradas = $entradas;
  }

  public function getSalidas()
  {
    return $this->salidas;
  }

  public function setSalidas($salidas)
  {
    $this->salidas = $salidas;
  }

  public function getExistencias()
  {
    return $this->existencias;
  }

  public function setExistencias($existencias)
  {
    $this->existencias = $existencias;
  }

  public static function getAll() {
    return DataBase::getAll("select s.id, p.codigo, concat(p.nombre, ' / ', p.marca, ' ( ' , p.unidad, ' )' )  as id_producto, s.entradas, s.salidas, s.existencias from stock s, producto p where s.id_producto = p.id;");
  }
}