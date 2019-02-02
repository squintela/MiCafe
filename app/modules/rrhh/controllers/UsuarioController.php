<?php

require_once './modules/rrhh/models/Usuario.php';
require_once './security/Session.php';
require_once './render/Render.php';

class UsuarioController
{

  public static function create() {
    return Render::to_response("@rrhh/usuario.twig", []);
  }

  public static function getFindById($id) {
    $usuario = Usuario::getFindById($id);
    return Render::to_response("@rrhh/usuario.twig", ['usuario'=> $usuario]);
  }

  public static function save($data) {
    $usuario = new Usuario();
    $usuario->setId($data['id']);
    $usuario->setUsername($data['username']);
    $usuario->setPassword($data['password']);
    $usuario->setEmail($data['email']);

    $status = ($usuario->getId() != 0) ? $usuario->update(): $usuario->save();
    $context = ['usuario' => $usuario];

    if (!$status)
      $context['errors'] = "Error en la transaccion";

    return Render::to_response("@rrhh/usuario.twig", $context);
  }

  public static function delete($id) {
    Usuario::delete($id);
    return self::getdAll();
  }

  public static function getdAll() {
    $usuarios = Usuario::getAll();
    return Render::to_response("@rrhh/usuario-list.twig", ['usuarios'=> $usuarios]);
  }

  public static function isLogIn($data){
    $usuario = Usuario::isLogin($data);
    $session = Session::getInstance();

    if (count($usuario) != 0) {
      $user = new Usuario();
      $user->setId($usuario['id']);
      $user->setUsername($usuario['username']);
      $user->setEmail($usuario['email']);
      $session->user = $user;
      return Render::to_response('@admin/base.twig', ['user'=> $user]);
    } else {
      $session->destroy();
      return Render::to_response('@admin/login.twig', []);
    }
  }

  public static function isLogOut() {
    $session = Session::getInstance();
    $session->destroy();
    return Render::to_response('@admin/login.twig', []);
  }
}