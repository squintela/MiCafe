<?php

require_once './db/DataBase.php';

class Usuario
{
  private $id;
  private $username;
  private $password;
  private $email;

  public function __construct()
  {
    $this->id = 0;
    $this->username = "";
    $this->password = "";
    $this->email = "";
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

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function save () {
    return DataBase::insert("usuario", [
      "username"=> $this->username,
      "password" => $this->password,
      "email" => $this->email
    ]);
  }

  public function update () {
    return DataBase::update("usuario", [
      "username"=> $this->username,
      "email" => $this->email,
      "password" => $this->password
    ], 'id='.$this->id );
  }

  public static function delete ($id) {
    return DataBase::delete("delete from usuario where id=$id");
  }

  public static function getAll() {
    return DataBase::getAll("select * from usuario;");
  }

  public static function getFindById($id) {
    $data = DataBase::getRow("select * from usuario where id=$id;");
    return self::toObject($data);
  }

  public static function getAssoc() {
    return DataBase::getAll("select  id, username as name from usuario;");
  }

  public static function isLogin($data){
    $username = $data['username'];
    $password = $data['password'];

    return DataBase::getRow("select * from usuario where username='$username' and password='$password'");
  }

  private static function toObject($data) {
    $usuario = new Usuario();
    $usuario->setId($data['id']);
    $usuario->setUsername($data['username']);
    $usuario->setPassword($data['password']);
    $usuario->setEmail($data['email']);

    return $usuario;
  }
}