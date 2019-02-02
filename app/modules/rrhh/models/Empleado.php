<?php

require_once './db/DataBase.php';
require_once './modules/rrhh/models/Usuario.php';

class Empleado
{
  private $id;
  private $nombres;
  private $apellidos;
  private $ci;
  private $genero;
  private $cargo;
  private $telefono;
  private $id_usuario;

  public static $generos = [['id'=>'M', 'name'=>'Masculino'],['id'=>'F', 'name'=>'Femenino']];

  public static $cargos = [
    ['id'=>'Mesero', 'name'=>'Mesero'],
    ['id'=>'Cocinero', 'name'=>'Cocinero'],
    ['id'=>'Cajero', 'name'=>'Cajero'],
    ['id'=>'Administrador', 'name'=>'Administrador']
    ];

  public function __construct()
  {
    $this->id = 0;
    $this->nombres = "";
    $this->apellidos = "";
    $this->ci = "";
    $this->genero = '';
    $this->cargo = "";
    $this->telefono = "";
    $this->id_usuario = 0;
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

  public function getCi()
  {
    return $this->ci;
  }

  public function setCi($ci)
  {
    $this->ci = $ci;
  }

  public function getGenero()
  {
    return $this->genero;
  }

  public function setGenero($genero)
  {
    $this->genero = $genero;
  }

  public function getCargo()
  {
    return $this->cargo;
  }

  public function setCargo($cargo)
  {
    $this->cargo = $cargo;
  }

  public function getTelefono()
  {
    return $this->telefono;
  }

  public function setTelefono($telefono)
  {
    $this->telefono = $telefono;
  }

  public function getIdUsuario()
  {
    return $this->id_usuario;
  }

  public function setIdUsuario($id_usuario)
  {
    $this->id_usuario = $id_usuario;
  }

  public function save()
  {
    return DataBase::insert("empleado", [
      'nombres' => $this->nombres,
      'apellidos' => $this->apellidos,
      'ci' => $this->ci,
      'genero' => $this->genero,
      'cargo' => $this->cargo,
      'telefono' => $this->telefono,
      'id_usuario' => $this->id_usuario,
    ]);
  }

  public function update() {
    return DataBase::update("empleado", [
      'nombres' => $this->nombres,
      'apellidos' => $this->apellidos,
      'ci' => $this->ci,
      'genero' => $this->genero,
      'cargo' => $this->cargo,
      'telefono' => $this->telefono,
      'id_usuario' => $this->id_usuario,
    ], 'id='.$this->id);
  }

  public static function getAll() {
    return DataBase::getAll("select e.id, e.nombres, e.apellidos, e.ci, e.genero, e.cargo, u.username as id_usuario from empleado e, usuario u where e.id_usuario = u.id;");
  }

  public static function delete ($id) {
    return DataBase::delete("delete from empleado where id=$id;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from empleado where id=$id;");
    return self::toObject($data);
  }

  public static function getUsuarios() {
    return Usuario::getAssoc();
  }

  public static function getAssoc() {
    return DataBase::getAll("select  id, concat(ci,' | ', nombres, ' ' , apellidos) as name from empleado;");
  }

  private static function toObject($data) {
    $empleado = new Empleado();
    $empleado->setId($data['id']);
    $empleado->setNombres($data['nombres']);
    $empleado->setApellidos($data['apellidos']);
    $empleado->setCi($data['ci']);
    $empleado->setGenero($data['genero']);
    $empleado->setCargo($data['cargo']);
    $empleado->setTelefono($data['telefono']);
    $empleado->setIdUsuario($data['id_usuario']);

    return $empleado;
  }
}