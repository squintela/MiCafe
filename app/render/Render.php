<?php

require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\CoreExtension;


class Render
{
  public static function to_response($template_name, $data) {

    $loader = new FilesystemLoader("./templates/");
    $loader->addPath('./templates/', 'admin');
    $loader->addPath('./modules/rrhh/views/', 'rrhh');
    $loader->addPath('./modules/inventario/views/', 'inventario');
    $loader->addPath('./modules/venta/views/', 'venta');
    $loader->addPath('./modules/tpv/views/', 'tpv');
    $loader->addPath('./modules/reporte/views/', 'reporte');
    $loader->addPath('./modules/addons/views/', 'addons');

    $twig = new Environment($loader, ['debug'=> true]);
    $twig->getExtension('Twig_Extension_Core')->setTimezone('America/La_Paz');

    return $twig->render($template_name, $data);
  }
}

//$twig = new Environment($loader, ['debug'=> true, "cache"=> "/var/www/html/micafe/cache/compilation_cache/"])
// /var/www/html/micafe/app;