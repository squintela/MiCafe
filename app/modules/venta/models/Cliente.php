<?php

require_once './db/DataBase.php';

class Cliente
{
  private $id;
  private $nombres;
  private $apellidos;
  private $celular;
  private $nit;

  public function __construct()
  {
    $this->id = 0;
    $this->nombres = "";
    $this->apellidos = "";
    $this->celular = "";
    $this->nit = "";
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

  public function getNombres()
  {
    return $this->nombres;
  }

  public function setNombres($nombres)
  {
    $this->nombres = $nombres;
  }

  public function getApellidos()
  {
    return $this->apellidos;
  }

  public function setApellidos($apellidos)
  {
    $this->apellidos = $apellidos;
  }

  public function getCelular()
  {
    return $this->celular;
  }

  public function setCelular($celular)
  {
    $this->celular = $celular;
  }

  public function getNit()
  {
    return $this->nit;
  }

  public function setNit($nit)
  {
    $this->nit = $nit;
  }

  public function save()
  {
    return DataBase::insert("cliente", [
      'nombres' => $this->nombres,
      'apellidos' => $this->apellidos,
      'celular' => $this->celular,
      'nit' => $this->nit
    ]);
  }

  public function update() {
    return DataBase::update("cliente", [
      'nombres' => $this->nombres,
      'apellidos' => $this->apellidos,
      'celular' => $this->celular,
      'nit' => $this->nit
    ], 'id='.$this->id);
  }

  public function feullname() {
    return $this->getNit() . ' / ' . $this->getNombres() . ' ' . $this->getApellidos();
  }

  public static function getAll() {
    return DataBase::getAll("select * from cliente;");
  }

  public static function delete ($id) {
    return DataBase::delete("delete from cliente where id=$id;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from cliente where id=$id;");
    return self::toObject($data);
  }

  public static function getAssoc() {
    return DataBase::getAll("select  id, concat(nombres, ' ' , apellidos) as name from cliente;");
  }

  public static function isLogin($data){
    $celular = $data['celular'];
    $nit = $data['nit'];

    return DataBase::getRow("select * from cliente where celular='$celular' and nit='$nit'");
  }

  private static function toObject($data) {
    $cliente = new Cliente();
    $cliente->setId($data['id']);
    $cliente->setNombres($data['nombres']);
    $cliente->setApellidos($data['apellidos']);
    $cliente->setCelular($data['celular']);
    $cliente->setNit($data['nit']);

    return $cliente;
  }
}