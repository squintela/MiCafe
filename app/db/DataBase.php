<?php

require '../vendor/adodb/adodb-php/adodb.inc.php';

class DataBase
{
  private static function getConnection()
  {
    $db = NewADOConnection('mysqli');
    $db->debug = false;
    $db->Connect('localhost', 'root', '', 'micafe');
    return $db->isConnected() ? $db : null;
  }

  public static function getAll($query)
  {
    $rows = [];
    $db = self::getConnection();

    if (!is_null($db)) {
      $rows = $db->getAll($query);
      $db->Close();
    }
    return $rows;
  }

  /**
   * return key => value
   * @param $query
   * @return array
   */
  public static function getAssoc($query)
  {
    $rows = [];
    $db = self::getConnection();

    if (!is_null($db)){
      $rows = $db->getAssoc($query);
      $db->Close();
    }

    return $rows;
  }

  public static function getRow($query)
  {
    $rows = [];
    $db = self::getConnection();

    if (!is_null($db)){
      $rows = $db->getRow($query);
      $db->Close();
    }

    return $rows;
  }

  public static function insert($table, $record)
  {
    $db = self::getConnection();
    $rows = 0;

    if (!is_null($db)) {
      $db->autoExecute($table, $record, 'INSERT');
      $rows = $db->affected_rows();
      $db->Close();
    }
    return $rows != 0;
  }

  public static function update($table, $record, $set)
  {
    $db = self::getConnection();
    $rows = 0;

    if (!is_null($db)) {
      $db->autoExecute($table, $record, 'UPDATE', $set);
      $rows = $db->affected_rows();
      $db->Close();
    }

    return $rows != 0;
  }

  public static function delete($query)
  {
    $db = self::getConnection();
    $rows = 0;

    if (!is_null($db)) {
      $db->Execute($query);
      $rows = $db->affected_rows();
      $db->Close();
    }

    return $rows != 0;
  }

  public static function executeQuery($query)
  {
    $db = self::getConnection();
    $rows = [];

    if (!is_null($db)) {
      $rs = $db->Execute($query);
      if ($rs)
        $rows = $rs->GetArray();
      $db->Close();
    }

    return $rows;
  }
}
