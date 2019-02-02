<?php

require_once './db/DataBase.php';

class Producto
{
  private $id;
  private $codigo;
  private $nombre;
  private $marca;
  private $unidad;
  private $tipo;
  private $precio;
  private $volumen;

  public static $tipos = [
    ['id' => 'Consumible', 'name'=>'Consumible'],
    ['id' => 'Insumo', 'name'=>'Insumo'],
    ['id' => 'Almacenable', 'name'=>'Almacenable']
  ];

  public static $unidades = [
    ['id' => 'Gramo', 'name'=>'Gramo'],
    ['id' => 'Kilogramo', 'name'=>'Kilogramo'],
    ['id' => 'Libra', 'name'=>'Libra'],
    ['id' => 'Arroba', 'name'=>'Arroba'],
    ['id' => 'Quintal', 'name'=>'Quintal'],
    ['id' => 'Unidad', 'name'=>'Unidad'],
    ['id' => 'Litro', 'name'=>'Litro'],
    ['id' => 'Galon', 'name'=>'Galon']
  ];

  public function __construct()
  {
    $this->id = 0;
    $this->codigo = "";
    $this->nombre = "";
    $this->marca = "";
    $this->unidad = "";
    $this->tipo = "";
    $this->precio = 0.0;
    $this->volumen = 0.0;
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

  public function setCodigo($codigo)
  {
    $this->codigo = $codigo;
  }

  public function setNombre($nombre)
  {
    $this->nombre = $nombre;
  }

  public function setMarca($marca)
  {
    $this->marca = $marca;
  }

  public function setUnidad($unidad)
  {
    $this->unidad = $unidad;
  }

  public function setTipo($tipo)
  {
    $this->tipo = $tipo;
  }

  public function getNombre()
  {
    return $this->nombre;
  }

  public function getMarca()
  {
    return $this->marca;
  }

  public function getCodigo()
  {
    return $this->codigo;
  }

  public function getUnidad()
  {
    return $this->unidad;
  }

  public function getTipo()
  {
    return $this->tipo;
  }

  public function getPrecio()
  {
    return $this->precio;
  }

  public function setPrecio($precio)
  {
    $this->precio = $precio;
  }

  public function getVolumen()
  {
    return $this->volumen;
  }

  public function setVolumen($volumen)
  {
    $this->volumen = $volumen;
  }

  public function save () {
    return DataBase::insert("producto", [
      "codigo" => $this->codigo,
      "nombre" => $this->nombre,
      "marca" => $this->marca,
      "unidad" => $this->unidad,
      "tipo" => $this->tipo,
      "precio" => $this->precio,
      "volumen" => $this->volumen
    ]);
  }

  public function update () {
    return DataBase::update("producto", [
      "codigo" => $this->codigo,
      "nombre" => $this->nombre,
      "marca" => $this->marca,
      "unidad" => $this->unidad,
      "tipo" => $this->tipo,
      "precio" => $this->precio,
      "volumen" => $this->volumen
    ], 'id='.$this->id );
  }

  public static function delete ($id) {
    return DataBase::delete("delete from producto where id=$id");
  }

  public static function getAll() {
    return DataBase::getAll("select * from producto;");
  }

  public static function getAllConsumible() {
    return DataBase::getAll("select * from producto where tipo='Consumible';");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from producto where id=$id;");
    return self::toObject($data);
  }

  public static function getAssoc() {
    return DataBase::getAll("select  id, nombre from producto;");
  }

  private static function toObject($data) {
    $producto = new Producto();
    $producto->setId($data['id']);
    $producto->setCodigo($data['codigo']);
    $producto->setNombre($data['nombre']);
    $producto->setMarca($data['marca']);
    $producto->setUnidad($data['unidad']);
    $producto->setTipo($data['tipo']);
    $producto->setPrecio($data['precio']);
    $producto->setVolumen($data['volumen']);

    return $producto;
  }

}