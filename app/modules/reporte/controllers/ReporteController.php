<?php

require_once './render/Render.php';
require_once './db/DataBase.php';
require_once './modules/venta/models/Pedido.php';

class ReporteController
{
  public static function listaPedidos(){
    $context = [
      'pedidos' => Pedido::getAll()
    ];
    return Render::to_response('@reporte/pedido-list.twig', $context);
  }

  public static function utilidadesDay() {
    return Render::to_response('@reporte/pedido-dia.twig', []);
  }

  public static function utilidadesDayProcess($dia) {
    $pedidos = DataBase::getAll("SELECT pr.id, pr.codigo, pr.nombre, pr.precio as precio_unid, sum(o.cantidad) as cantidad, sum(o.precio) as precio FROM pedido pe, orden o, producto pr where pe.id=o.id_pedido and Date_format(pe.fecha, '%Y-%m-%d')='$dia' and pe.estado='Pagado' and o.id_producto = pr.id group by pr.id;");
    $total = DataBase::getRow("select sum(monto) as monto, count(id) as pedidos from pedido where estado='Pagado' and Date_format(fecha, '%Y-%m-%d')='$dia';");

    $context = [
      'pedidos' => $pedidos,
      'total' => $total,
      'dia' => $dia
    ];
    return Render::to_response('@reporte/pedido-dia.twig', $context);
  }

  public static function utilidadesMonth() {
    return Render::to_response('@reporte/pedido-mes.twig', []);
  }

  public static function utilidadesMonthProcess($dia) {
    $pedidos = DataBase::getAll("SELECT pr.id, pr.codigo, pr.nombre, pr.precio as precio_unid, sum(o.cantidad) as cantidad, sum(o.precio) as precio FROM pedido pe, orden o, producto pr where pe.id=o.id_pedido and Date_format(pe.fecha, '%Y-%m')='$dia' and pe.estado='Pagado' and o.id_producto = pr.id group by pr.id;");
    $total = DataBase::getRow("select sum(monto) as monto, count(id) as pedidos from pedido where estado='Pagado' and Date_format(fecha, '%Y-%m')='$dia';");

    $context = [
      'pedidos' => $pedidos,
      'total' => $total,
      'mes' => $dia
    ];
    return Render::to_response('@reporte/pedido-mes.twig', $context);
  }





  public static function entradasDay() {
    return Render::to_response('@reporte/entrada-dia.twig', []);
  }

  public static function entradasDayProcess($dia) {
    $entradas = DataBase::getAll("select p.id , p.codigo, p.nombre, sum(ep.cantidad) as cantidad, sum(ep.cantidad) * p.precio as precio from entrada e, entrada_producto ep, producto p where e.id = ep.id_entrada and Date_format(e.fecha, '%Y-%m-%d') = '$dia' and ep.id_producto=p.id group by p.id;");
    $monto = 0;
    $total = 0;

    for ($i = 0; $i < count($entradas); $i++ ) {
      $monto += $entradas[$i]['precio'];
      $total += $entradas[$i]['cantidad'];
    }

    $context = [
      'entradas' => $entradas,
      'total' => $total,
      'monto' => $monto,
      'dia' => $dia
    ];
    return Render::to_response('@reporte/entrada-dia.twig', $context);
  }

  public static function entradasMonth() {
    return Render::to_response('@reporte/entrada-mes.twig', []);
  }

  public static function entradasMonthProcess($dia) {
    $entradas = DataBase::getAll("select p.id , p.codigo, p.nombre, sum(ep.cantidad) as cantidad, sum(ep.cantidad) * p.precio as precio from entrada e, entrada_producto ep, producto p where e.id = ep.id_entrada and Date_format(e.fecha, '%Y-%m') = '$dia' and ep.id_producto=p.id group by p.id;");
    $monto = 0;
    $total = 0;

    for ($i = 0; $i < count($entradas); $i++ ) {
      $monto += $entradas[$i]['precio'];
      $total += $entradas[$i]['cantidad'];
    }

    $context = [
      'entradas' => $entradas,
      'total' => $total,
      'monto' => $monto,
      'mes' => $dia
    ];
    return Render::to_response('@reporte/entrada-mes.twig', $context);
  }
}