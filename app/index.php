<?php

require_once './render/Render.php';
require_once './security/Session.php';

$session = Session::getInstance();

if ( $session->username ) {
  echo Render::to_response('@admin/base.twig', []);
} else {
  echo Render::to_response('@admin/login.twig', []);
}
